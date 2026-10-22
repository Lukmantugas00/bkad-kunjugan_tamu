<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;


class PimpinanController extends Controller
{
    /**
     * Zona waktu laporan.
     */
    private function zonaWaktu(): string
    {
        return 'Asia/Makassar';
    }

    /**
     * Dashboard Pimpinan.
     */
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'hari_ini');
        $sekarang = now($this->zonaWaktu());

        switch ($periode) {
            case '7_hari':
                $tanggalMulai = $sekarang->copy()
                    ->subDays(6)->startOfDay();
                $tanggalAkhir = $sekarang->copy()->endOfDay();
                $labelPeriode = '7 hari terakhir';
                break;

            case '30_hari':
                $tanggalMulai = $sekarang->copy()
                    ->subDays(29)->startOfDay();
                $tanggalAkhir = $sekarang->copy()->endOfDay();
                $labelPeriode = '30 hari terakhir';
                break;

            case 'bulan_ini':
                $tanggalMulai = $sekarang->copy()->startOfMonth();
                $tanggalAkhir = $sekarang->copy()->endOfMonth();
                $labelPeriode = 'Bulan ini';
                break;

            case 'tahun_ini':
                $tanggalMulai = $sekarang->copy()->startOfYear();
                $tanggalAkhir = $sekarang->copy()->endOfYear();
                $labelPeriode = 'Tahun '.$sekarang->format('Y');
                break;

            case 'hari_ini':
            default:
                $tanggalMulai = $sekarang->copy()->startOfDay();
                $tanggalAkhir = $sekarang->copy()->endOfDay();
                $periode = 'hari_ini';
                $labelPeriode = 'Hari ini';
                break;
        }

        $query = Kunjungan::query()
            ->whereBetween('created_at', [
                $tanggalMulai->copy()->utc(),
                $tanggalAkhir->copy()->utc(),
            ]);

        $totalKunjungan = (clone $query)->count();

        $menunggu = (clone $query)
            ->where('status', 'baru')
            ->count();

        $diterima = (clone $query)
            ->where('status', 'diterima')
            ->count();

        $selesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $tingkatSelesai = $totalKunjungan > 0
            ? round(($selesai / $totalKunjungan) * 100)
            : 0;

        $statistikBidang = Bidang::where('aktif', true)
            ->withCount([
                'kunjungans as jumlah_kunjungan' => function ($q) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {
                    $q->whereBetween('created_at', [
                        $tanggalMulai->copy()->utc(),
                        $tanggalAkhir->copy()->utc(),
                    ]);
                },
            ])
            ->orderByDesc('jumlah_kunjungan')
            ->get();

        $maksimumBidang = max(
            1,
            (int) $statistikBidang->max('jumlah_kunjungan')
        );

        $trendKunjungan = collect();

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = $sekarang->copy()->subDays($i);

            $mulaiHari = $tanggal->copy()->startOfDay()->utc();
            $akhirHari = $tanggal->copy()->endOfDay()->utc();

            $jumlah = Kunjungan::whereBetween('created_at', [
                $mulaiHari,
                $akhirHari,
            ])->count();

            $trendKunjungan->push([
                'tanggal' => $tanggal->format('d/m'),
                'label' => $tanggal->locale('id')->isoFormat('ddd'),
                'jumlah' => $jumlah,
            ]);
        }

        $maksimumTrend = max(
            1,
            (int) $trendKunjungan->max('jumlah')
        );

        $kunjunganTerbaru = Kunjungan::with('bidangTujuan')
            ->latest('created_at')
            ->limit(8)
            ->get();

        $sekarangWita = now($this->zonaWaktu());

        // Kunjungan baru yang belum direspons lebih dari 10 menit.
        $baruBelumDirespon = Kunjungan::with('bidangTujuan')
            ->where('status', 'baru')
            ->where(
                'created_at',
                '<=',
                $sekarangWita->copy()->subMinutes(10)->utc()
            )
            ->get()
            ->map(function ($k) use ($sekarangWita) {
                $k->kategori = 'baru';
                $k->waktu_acu = $k->created_at;

                $k->lama_menunggu = $k->created_at
                    ? (int) $k->created_at
                        ->timezone('Asia/Makassar')
                        ->diffInMinutes($sekarangWita)
                    : 0;

                return $k;
            });

        // Kunjungan diterima yang belum selesai lebih dari 24 jam.
        $diterimaBelumSelesai = Kunjungan::with('bidangTujuan')
            ->where('status', 'diterima')
            ->whereNotNull('diterima_at')
            ->where(
                'diterima_at',
                '<=',
                $sekarangWita->copy()->subHours(24)->utc()
            )
            ->get()
            ->map(function ($k) use ($sekarangWita) {
                $k->kategori = 'diterima';
                $k->waktu_acu = $k->diterima_at;

                $k->lama_menunggu = $k->diterima_at
                    ? (int) $k->diterima_at
                        ->timezone('Asia/Makassar')
                        ->diffInMinutes($sekarangWita)
                    : 0;

                return $k;
            });

        $perluPerhatian = $baruBelumDirespon
            ->concat($diterimaBelumSelesai)
            ->sortByDesc('lama_menunggu')
            ->take(5)
            ->values();

        $totalPerluPerhatian = $baruBelumDirespon->count()
            + $diterimaBelumSelesai->count();

        $bidangTeratas = $statistikBidang->first();

        $persentaseBidangTeratas = 0;

        if ($bidangTeratas && $totalKunjungan > 0) {
            $persentaseBidangTeratas = round(
                ($bidangTeratas->jumlah_kunjungan / $totalKunjungan) * 100
            );
        }

        return view(
            'pimpinan.dashboard',
            compact(
                'sekarang',
                'periode',
                'labelPeriode',
                'tanggalMulai',
                'tanggalAkhir',
                'totalKunjungan',
                'menunggu',
                'diterima',
                'selesai',
                'tingkatSelesai',
                'statistikBidang',
                'maksimumBidang',
                'trendKunjungan',
                'maksimumTrend',
                'kunjunganTerbaru',
                'perluPerhatian',
                'totalPerluPerhatian',
                'bidangTeratas',
                'persentaseBidangTeratas'
            )
        );
    }

    /**
     * Query laporan berdasarkan filter tanggal, bidang, dan status.
     * Rentang tanggal dihitung dalam WITA lalu dikonversi ke UTC.
     */
    private function queryLaporan(Request $request)
    {
        $zonaWaktu = $this->zonaWaktu();

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now($zonaWaktu)->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now($zonaWaktu)->toDateString()
        );

        $mulai = Carbon::parse($tanggalMulai, $zonaWaktu)
            ->startOfDay()
            ->utc();

        $akhir = Carbon::parse($tanggalAkhir, $zonaWaktu)
            ->endOfDay()
            ->utc();

        $query = Kunjungan::with('bidangTujuan')
            ->whereBetween('created_at', [$mulai, $akhir]);

        if ($request->filled('bidang_id')) {
            $query->where(
                'bidang_tujuan_id',
                $request->input('bidang_id')
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query;
    }

    /**
     * Halaman Laporan Pimpinan.
     */
    public function laporan(Request $request)
    {
        $query = $this->queryLaporan($request);

        $kunjungans = (clone $query)
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        $total = (clone $query)->count();

        $selesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $diterima = (clone $query)
            ->where('status', 'diterima')
            ->count();

        $menunggu = (clone $query)
            ->where('status', 'baru')
            ->count();

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now($this->zonaWaktu())->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now($this->zonaWaktu())->toDateString()
        );

        $bidangId = $request->input('bidang_id');
        $status = $request->input('status');

        return view(
            'pimpinan.laporan',
            compact(
                'kunjungans',
                'bidangs',
                'tanggalMulai',
                'tanggalAkhir',
                'bidangId',
                'status',
                'total',
                'selesai',
                'diterima',
                'menunggu'
            )
        );
    }

    /**
     * Ekspor laporan Pimpinan ke PDF.
     */
    public function pdf(Request $request)
    {
        $kunjungans = $this->queryLaporan($request)
            ->latest('created_at')
            ->get();

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now($this->zonaWaktu())->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now($this->zonaWaktu())->toDateString()
        );

        $bidangId = $request->input('bidang_id');
        $status = $request->input('status');

        $namaBidang = $bidangId
            ? Bidang::find($bidangId)?->nama
            : null;

        $pdf = Pdf::loadView(
            'pimpinan.laporan-pdf',
            compact(
                'kunjungans',
                'tanggalMulai',
                'tanggalAkhir',
                'namaBidang',
                'status'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-kunjungan-pimpinan-'
            .$tanggalMulai
            .'-sampai-'
            .$tanggalAkhir
            .'.pdf'
        );
    }

    /**
     * Ekspor laporan Pimpinan ke CSV.
     */
    public function csv(Request $request): StreamedResponse
    {
        $kunjungans = $this->queryLaporan($request)
            ->latest('created_at')
            ->get();

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now($this->zonaWaktu())->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now($this->zonaWaktu())->toDateString()
        );

        $namaFile = 'laporan-kunjungan-pimpinan-'
            .$tanggalMulai
            .'-sampai-'
            .$tanggalAkhir
            .'.csv';

        $zonaWaktu = $this->zonaWaktu();

        return response()->streamDownload(
            function () use ($kunjungans, $zonaWaktu) {
                $handle = fopen('php://output', 'w');

                // BOM UTF-8 agar karakter Indonesia terbaca di Excel.
                fwrite($handle, "\xEF\xBB\xBF");
                fwrite($handle, "sep=,\r\n");

                fputcsv($handle, [
                    'No',
                    'Tanggal',
                    'Jam',
                    'Nama Pengunjung',
                    'NIP',
                    'Jabatan',
                    'Instansi',
                    'Bidang Tujuan',
                    'Keperluan',
                    'Status',
                    'Jawaban Bidang',
                ]);

                foreach ($kunjungans as $index => $kunjungan) {
                    $waktu = $kunjungan->created_at
                        ? $kunjungan->created_at->timezone($zonaWaktu)
                        : null;

                    fputcsv($handle, [
                        $index + 1,
                        $waktu?->format('d-m-Y') ?? '-',
                        $waktu?->format('H:i:s') ?? '-',
                        $kunjungan->nama_pengunjung ?: '-',
                        $kunjungan->nip !== null
                            ? "\t".$kunjungan->nip
                            : '-',
                        $kunjungan->jabatan ?: '-',
                        $kunjungan->instansi ?: '-',
                        $kunjungan->bidangTujuan?->nama ?? '-',
                        $kunjungan->keperluan ?: '-',
                        ucfirst(str_replace(
                            '_',
                            ' ',
                            $kunjungan->status ?? ''
                        )),
                        $kunjungan->jawaban_bidang ?: '-',
                    ]);
                }

                fclose($handle);
            },
            $namaFile,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }

    /**
     * Ekspor laporan Pimpinan ke Excel XLSX.
     * Menggunakan kop dan logo yang konsisten dengan laporan Admin.
     */
    public function excel(Request $request): StreamedResponse
    {
        $zonaWaktu = $this->zonaWaktu();

        $kunjungans = $this->queryLaporan($request)
            ->latest('created_at')
            ->get();

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now($zonaWaktu)->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now($zonaWaktu)->toDateString()
        );

        $bidangId = $request->input('bidang_id');
        $status = $request->input('status');

        $namaBidang = $bidangId
            ? Bidang::find($bidangId)?->nama ?? 'Tidak diketahui'
            : 'Semua Bidang';

        $namaStatus = $status
            ? strtoupper(str_replace('_', ' ', $status))
            : 'Semua Status';

        $periode = Carbon::parse($tanggalMulai, $zonaWaktu)
            ->format('d/m/Y')
            .' s.d. '.
            Carbon::parse($tanggalAkhir, $zonaWaktu)
                ->format('d/m/Y')
            .' WITA';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pimpinan');

        /*
         * KOP LAPORAN
         */
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A4:K4');

        $sheet->setCellValue('A1', 'BADAN KEUANGAN DAN ASET DAERAH');
        $sheet->setCellValue('A2', 'KABUPATEN TAPIN');
        $sheet->setCellValue('A4', 'LAPORAN KUNJUNGAN TAMU');

        // Logo BKAD.
        $logoPath = public_path('images/logo.png');

        if (file_exists($logoPath)) {
            $drawing = new Drawing();
            $drawing->setName('Logo BKAD Kabupaten Tapin');
            $drawing->setDescription('Logo BKAD Kabupaten Tapin');
            $drawing->setPath($logoPath);
            $drawing->setHeight(60);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(12);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        $sheet->getRowDimension(1)->setRowHeight(35);
        $sheet->getRowDimension(2)->setRowHeight(23);
        $sheet->getRowDimension(3)->setRowHeight(8);
        $sheet->getRowDimension(4)->setRowHeight(30);

        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 15,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '155A35'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '155A35'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '155A35'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '155A35'],
                ],
            ],
        ]);

        /*
         * INFORMASI LAPORAN
         */
        $sheet->setCellValue('A6', 'Periode');
        $sheet->setCellValue('B6', $periode);

        $sheet->setCellValue('A7', 'Bidang');
        $sheet->setCellValue('B7', $namaBidang);

        $sheet->setCellValue('A8', 'Status');
        $sheet->setCellValue('B8', $namaStatus);

        $sheet->setCellValue('A9', 'Dicetak');
        $sheet->setCellValue(
            'B9',
            now($zonaWaktu)->format('d/m/Y H:i:s').' WITA'
        );

        $sheet->getStyle('A6:A9')->getFont()->setBold(true);

        /*
         * HEADER TABEL
         */
        $headerRow = 11;

        $headers = [
            'No',
            'Tanggal',
            'Jam',
            'Nama Pengunjung',
            'NIP',
            'Jabatan',
            'Instansi',
            'Bidang Tujuan',
            'Keperluan',
            'Status',
            'Jawaban Bidang',
        ];

        foreach ($headers as $index => $header) {
            $kolom = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                $index + 1
            );

            $sheet->setCellValue($kolom.$headerRow, $header);
        }

        /*
         * DATA LAPORAN
         */
        $row = $headerRow + 1;

        foreach ($kunjungans as $index => $kunjungan) {
            $waktu = $kunjungan->created_at
                ? $kunjungan->created_at->timezone($zonaWaktu)
                : null;

            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue(
                "B{$row}",
                $waktu?->format('d/m/Y') ?? '-'
            );
            $sheet->setCellValue(
                "C{$row}",
                $waktu?->format('H:i:s') ?? '-'
            );
            $sheet->setCellValue(
                "D{$row}",
                $kunjungan->nama_pengunjung ?: '-'
            );

            // NIP sebagai teks agar angka nol di depan tidak hilang.
            $sheet->setCellValueExplicit(
                "E{$row}",
                (string) ($kunjungan->nip ?: '-'),
                DataType::TYPE_STRING
            );

            $sheet->setCellValue(
                "F{$row}",
                $kunjungan->jabatan ?: '-'
            );
            $sheet->setCellValue(
                "G{$row}",
                $kunjungan->instansi ?: '-'
            );
            $sheet->setCellValue(
                "H{$row}",
                $kunjungan->bidangTujuan?->nama ?? '-'
            );
            $sheet->setCellValue(
                "I{$row}",
                $kunjungan->keperluan ?: '-'
            );
            $sheet->setCellValue(
                "J{$row}",
                ucfirst(str_replace(
                    '_',
                    ' ',
                    $kunjungan->status ?? ''
                ))
            );
            $sheet->setCellValue(
                "K{$row}",
                $kunjungan->jawaban_bidang ?: '-'
            );

            // Warna baris berselang-seling.
            if ($index % 2 === 1) {
                $sheet->getStyle("A{$row}:K{$row}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID);

                $sheet->getStyle("A{$row}:K{$row}")
                    ->getFill()
                    ->getStartColor()
                    ->setRGB('F0F7F2');
            }

            $row++;
        }

        $lastRow = max($headerRow, $row - 1);

        /*
         * GAYA HEADER TABEL
         */
        $sheet->getStyle("A{$headerRow}:K{$headerRow}")
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 10,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '166534'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D1D5DB'],
                    ],
                ],
            ]);

        $sheet->getRowDimension($headerRow)->setRowHeight(32);

        /*
         * GAYA DATA
         */
        if ($lastRow > $headerRow) {
            $sheet->getStyle(
                'A'.($headerRow + 1).":K{$lastRow}"
            )->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D1D5DB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true,
                ],
            ]);

            $sheet->getStyle(
                'A'.($headerRow + 1).":C{$lastRow}"
            )->getAlignment()->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );

            $sheet->getStyle(
                'J'.($headerRow + 1).":J{$lastRow}"
            )->getAlignment()->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );

            $sheet->getStyle(
                'E'.($headerRow + 1).":E{$lastRow}"
            )->getNumberFormat()->setFormatCode('@');
        }

        /*
         * LEBAR KOLOM
         */
        $widths = [
            'A' => 6,
            'B' => 13,
            'C' => 11,
            'D' => 25,
            'E' => 22,
            'F' => 20,
            'G' => 24,
            'H' => 22,
            'I' => 35,
            'J' => 15,
            'K' => 35,
        ];

        foreach ($widths as $kolom => $lebar) {
            $sheet->getColumnDimension($kolom)->setWidth($lebar);
        }

        // Filter tabel; tidak menggunakan freeze panes.
        $sheet->setAutoFilter("A{$headerRow}:K{$lastRow}");
        $sheet->setSelectedCell('A1');

        /*
         * PENGATURAN CETAK
         */
        $sheet->getPageSetup()->setOrientation(
            \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
        );

        $sheet->getPageSetup()->setPaperSize(
            \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4
        );

        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getPageSetup()->setFitToPage(true);

        $sheet->getPageMargins()->setTop(0.4);
        $sheet->getPageMargins()->setBottom(0.4);
        $sheet->getPageMargins()->setLeft(0.25);
        $sheet->getPageMargins()->setRight(0.25);

        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(
            $headerRow,
            $headerRow
        );

        $sheet->getHeaderFooter()->setOddFooter(
            '&CBKAD Kabupaten Tapin - SIKUTA&RHalaman &P dari &N'
        );

        /*
         * UNDUH FILE EXCEL
         */
        $namaFile = 'laporan-kunjungan-pimpinan-'
            .$tanggalMulai
            .'-sampai-'
            .$tanggalAkhir
            .'.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(
            function () use ($writer, $spreadsheet) {
                try {
                    $writer->save('php://output');
                } finally {
                    $spreadsheet->disconnectWorksheets();
                }
            },
            $namaFile,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}

