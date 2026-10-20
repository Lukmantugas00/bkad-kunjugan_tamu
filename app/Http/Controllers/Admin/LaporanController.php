<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    private function zonaWaktu(): string
    {
        return 'Asia/Makassar';
    }

    private function buildQuery(Request $request)
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

        $query = Kunjungan::with('bidangTujuan');

        if ($tanggalMulai) {
            $mulai = Carbon::parse($tanggalMulai, $zonaWaktu)
                ->startOfDay()
                ->utc();

            $query->where('created_at', '>=', $mulai);
        }

        if ($tanggalAkhir) {
            $akhir = Carbon::parse($tanggalAkhir, $zonaWaktu)
                ->endOfDay()
                ->utc();

            $query->where('created_at', '<=', $akhir);
        }

        if ($request->filled('bidang_id')) {
            $query->where(
                'bidang_tujuan_id',
                $request->input('bidang_id')
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('keperluan')) {
            $keperluan = trim($request->input('keperluan'));

            $query->where(
                'keperluan',
                'like',
                "%{$keperluan}%"
            );
        }

        return $query;
    }

    private function filterData(Request $request): array
    {
        $zonaWaktu = $this->zonaWaktu();

        return [
            'tanggal_mulai' => $request->input(
                'tanggal_mulai',
                now($zonaWaktu)->toDateString()
            ),
            'tanggal_akhir' => $request->input(
                'tanggal_akhir',
                now($zonaWaktu)->toDateString()
            ),
            'bidang_id' => $request->input('bidang_id'),
            'status' => $request->input('status'),
            'keperluan' => $request->input('keperluan'),
        ];
    }

    private function informasiLaporan(array $filter): array
    {
        $zonaWaktu = $this->zonaWaktu();

        $tanggalMulai = Carbon::parse(
            $filter['tanggal_mulai'],
            $zonaWaktu
        )->format('d/m/Y');

        $tanggalAkhir = Carbon::parse(
            $filter['tanggal_akhir'],
            $zonaWaktu
        )->format('d/m/Y');

        $bidang = 'Semua Bidang';

        if (! empty($filter['bidang_id'])) {
            $bidangModel = Bidang::find($filter['bidang_id']);
            $bidang = $bidangModel?->nama ?? 'Tidak diketahui';
        }

        $status = ! empty($filter['status'])
            ? strtoupper($filter['status'])
            : 'Semua Status';

        return [
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
            'periode' => "{$tanggalMulai} s.d. {$tanggalAkhir} WITA",
            'bidang' => $bidang,
            'status' => $status,
            'keperluan' => $filter['keperluan'] ?? '',
            'dicetak' => now($zonaWaktu)->format('d/m/Y H:i:s').' WITA',
        ];
    }

    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $filter = $this->filterData($request);

        $total = (clone $query)->count();
        $totalBaru = (clone $query)->where('status', 'baru')->count();
        $totalDiterima = (clone $query)->where('status', 'diterima')->count();
        $totalSelesai = (clone $query)->where('status', 'selesai')->count();

        $rekapBidang = (clone $query)
            ->selectRaw('bidang_tujuan_id, COUNT(*) as jumlah')
            ->groupBy('bidang_tujuan_id')
            ->with('bidangTujuan')
            ->get()
            ->sortByDesc('jumlah');

        $kunjungans = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->onEachSide(1)
            ->withQueryString();

        $bidangs = Bidang::orderBy('nama')->get();

        return view(
            'admin.laporan.index',
            compact(
                'kunjungans',
                'bidangs',
                'filter',
                'total',
                'totalBaru',
                'totalDiterima',
                'totalSelesai',
                'rekapBidang'
            )
        );
    }

    public function pdf(Request $request)
    {
        $kunjungans = $this->buildQuery($request)
            ->orderByDesc('created_at')
            ->get();

        $filter = $this->filterData($request);

        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            compact('kunjungans', 'filter')
        );

        $pdf->setPaper('a4', 'landscape');

        $namaFile = 'laporan-kunjungan-'
            .$filter['tanggal_mulai']
            .'-'
            .$filter['tanggal_akhir']
            .'.pdf';

        return $pdf->download($namaFile);
    }

    public function csv(Request $request): StreamedResponse
    {
        $kunjungans = $this->buildQuery($request)
            ->orderByDesc('created_at')
            ->get();

        $filter = $this->filterData($request);
        $info = $this->informasiLaporan($filter);
        $zonaWaktu = $this->zonaWaktu();

        $namaFile = 'laporan-kunjungan-'
            .$filter['tanggal_mulai']
            .'-'
            .$filter['tanggal_akhir']
            .'.csv';

        return response()->streamDownload(
            function () use ($kunjungans, $info, $zonaWaktu) {
                $handle = fopen('php://output', 'w');

                fwrite($handle, "\xEF\xBB\xBF");
                fwrite($handle, "sep=;\r\n");

                $tulisBaris = function (array $kolom) use ($handle) {
                    fputcsv($handle, $kolom, ';', '"', '', "\r\n");
                };

                $tulisBaris(['BADAN KEUANGAN DAN ASET DAERAH']);
                $tulisBaris(['KABUPATEN TAPIN']);
                $tulisBaris([]);
                $tulisBaris(['LAPORAN KUNJUNGAN TAMU']);
                $tulisBaris(["Periode {$info['periode']}"]);
                $tulisBaris([]);

                $tulisBaris(['Periode', $info['periode']]);
                $tulisBaris(['Bidang', $info['bidang']]);
                $tulisBaris(['Status', $info['status']]);
                $tulisBaris(['Dicetak', $info['dicetak']]);

                if ($info['keperluan'] !== '') {
                    $tulisBaris([
                        'Pencarian Keperluan',
                        $info['keperluan'],
                    ]);
                }

                $tulisBaris([]);

                $tulisBaris([
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

                    $tulisBaris([
                        $index + 1,
                        $waktu?->format('d/m/Y') ?? '-',
                        $waktu?->format('H:i:s') ?? '-',
                        $kunjungan->nama_pengunjung ?: '-',
                        $kunjungan->nip ?: '-',
                        $kunjungan->jabatan ?: '-',
                        $kunjungan->instansi ?: '-',
                        $kunjungan->bidangTujuan?->nama ?? '-',
                        $kunjungan->keperluan ?: '-',
                        strtoupper($kunjungan->status ?? '-'),
                        $kunjungan->jawaban_bidang ?: '-',
                    ]);
                }

                fclose($handle);
            },
            $namaFile,
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }

    public function excel(Request $request): StreamedResponse
    {
        $zonaWaktu = $this->zonaWaktu();

        $kunjungans = $this->buildQuery($request)
            ->orderByDesc('created_at')
            ->get();

        $filter = $this->filterData($request);
        $info = $this->informasiLaporan($filter);

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Kunjungan');

        /*
        |--------------------------------------------------------------------------
        | LOGO BKAD KABUPATEN TAPIN
        |--------------------------------------------------------------------------
        */

        $logoPath = public_path('images/logo.jpg');

        if (file_exists($logoPath)) {
            $drawing = new Drawing;
            $drawing->setName('Logo BKAD Kabupaten Tapin');
            $drawing->setDescription('Logo BKAD Kabupaten Tapin');
            $drawing->setPath($logoPath);
            $drawing->setHeight(60);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(12);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        /*
        |--------------------------------------------------------------------------
        | KOP LAPORAN - TANPA NAMA INSTANSI BERULANG
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A4:K4');

        $sheet->setCellValue(
            'A1',
            'BADAN KEUANGAN DAN ASET DAERAH'
        );

        $sheet->setCellValue('A2', 'KABUPATEN TAPIN');

        $sheet->setCellValue(
            'A4',
            'LAPORAN KUNJUNGAN TAMU'
        );

        // Kop instansi: hijau tua dan teks putih.
        $sheet->getStyle('A1:K2')->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'bold' => true,
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

        $sheet->getStyle('A1:K1')->getFont()->setSize(16);
        $sheet->getStyle('A2:K2')->getFont()->setSize(12);

        $sheet->getRowDimension(1)->setRowHeight(28);
        $sheet->getRowDimension(2)->setRowHeight(22);
        $sheet->getRowDimension(3)->setRowHeight(8);

        // Judul laporan.
        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '155A35'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension(4)->setRowHeight(28);

        /*
        |--------------------------------------------------------------------------
        | INFORMASI FILTER
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue('A7', 'Periode');
        $sheet->setCellValue('B7', $info['periode']);

        $sheet->setCellValue('A8', 'Bidang');
        $sheet->setCellValue('B8', $info['bidang']);

        $sheet->setCellValue('A9', 'Status');
        $sheet->setCellValue('B9', $info['status']);

        $sheet->setCellValue('A10', 'Dicetak');
        $sheet->setCellValue('B10', $info['dicetak']);

        $headerRow = 12;

        if ($info['keperluan'] !== '') {
            $sheet->setCellValue('A11', 'Pencarian Keperluan');
            $sheet->setCellValue('B11', $info['keperluan']);
            $headerRow = 13;
        }

        $sheet->getStyle('A7:A10')->getFont()->setBold(true);

        if ($headerRow === 13) {
            $sheet->getStyle('A11')->getFont()->setBold(true);
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

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
            $kolom = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($kolom.$headerRow, $header);
        }

        /*
        |--------------------------------------------------------------------------
        | ISI DATA
        |--------------------------------------------------------------------------
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

            $sheet->setCellValue("F{$row}", $kunjungan->jabatan ?: '-');
            $sheet->setCellValue("G{$row}", $kunjungan->instansi ?: '-');
            $sheet->setCellValue(
                "H{$row}",
                $kunjungan->bidangTujuan?->nama ?? '-'
            );
            $sheet->setCellValue("I{$row}", $kunjungan->keperluan ?: '-');
            $sheet->setCellValue(
                "J{$row}",
                strtoupper($kunjungan->status ?? '-')
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
        |--------------------------------------------------------------------------
        | GAYA HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            "A{$headerRow}:K{$headerRow}"
        )->applyFromArray([
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
        |--------------------------------------------------------------------------
        | FORMAT ISI TABEL
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | LEBAR KOLOM
        |--------------------------------------------------------------------------
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

        /*
        |--------------------------------------------------------------------------
        | FILTER OTOMATIS TANPA FREEZE
        |--------------------------------------------------------------------------
        */

        $sheet->setAutoFilter("A{$headerRow}:K{$lastRow}");

        // Tidak ada freezePane(): seluruh baris dan kolom bebas digulir.
        $sheet->setSelectedCell('A1');

        /*
        |--------------------------------------------------------------------------
        | PENGATURAN CETAK
        |--------------------------------------------------------------------------
        */

        $sheet->getPageSetup()->setOrientation(
            PageSetup::ORIENTATION_LANDSCAPE
        );

        $sheet->getPageSetup()->setPaperSize(
            PageSetup::PAPERSIZE_A4
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
        |--------------------------------------------------------------------------
        | UNDUH XLSX
        |--------------------------------------------------------------------------
        */

        $namaFile = 'laporan-kunjungan-'
            .$filter['tanggal_mulai']
            .'-'
            .$filter['tanggal_akhir']
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
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
