<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    /**
     * Dashboard Pimpinan
     */
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'hari_ini');

        // Waktu Indonesia Tengah / WITA
        $sekarang = now('Asia/Makassar');

        /*
        |--------------------------------------------------------------------------
        | PERIODE DASHBOARD
        |--------------------------------------------------------------------------
        */

        $labelPeriode = 'Hari ini';

        switch ($periode) {

            case '7_hari':

                $tanggalMulai = $sekarang
                    ->copy()
                    ->subDays(6)
                    ->startOfDay();

                $tanggalAkhir = $sekarang
                    ->copy()
                    ->endOfDay();

                $labelPeriode = '7 hari terakhir';

                break;

            case '30_hari':

                $tanggalMulai = $sekarang
                    ->copy()
                    ->subDays(29)
                    ->startOfDay();

                $tanggalAkhir = $sekarang
                    ->copy()
                    ->endOfDay();

                $labelPeriode = '30 hari terakhir';

                break;

            case 'bulan_ini':

                $tanggalMulai = $sekarang
                    ->copy()
                    ->startOfMonth();

                $tanggalAkhir = $sekarang
                    ->copy()
                    ->endOfMonth();

                $labelPeriode = 'Bulan ini';

                break;

            case 'tahun_ini':

                $tanggalMulai = $sekarang
                    ->copy()
                    ->startOfYear();

                $tanggalAkhir = $sekarang
                    ->copy()
                    ->endOfYear();

                $labelPeriode = 'Tahun '.$sekarang->format('Y');

                break;

            case 'hari_ini':

            default:

                $tanggalMulai = $sekarang
                    ->copy()
                    ->startOfDay();

                $tanggalAkhir = $sekarang
                    ->copy()
                    ->endOfDay();

                $periode = 'hari_ini';

                $labelPeriode = 'Hari ini';

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY UTAMA
        |--------------------------------------------------------------------------
        */

        $query = Kunjungan::query()
            ->whereBetween('created_at', [
                $tanggalMulai,
                $tanggalAkhir,
            ]);

        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $totalKunjungan = (clone $query)->count();

        $menunggu = (clone $query)
            ->where('status', 'menunggu')
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

        /*
        |--------------------------------------------------------------------------
        | STATISTIK PER BIDANG
        |--------------------------------------------------------------------------
        */

        $statistikBidang = Bidang::where('aktif', true)
            ->withCount([
                'kunjungans as jumlah_kunjungan' => function ($q) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {
                    $q->whereBetween('created_at', [
                        $tanggalMulai,
                        $tanggalAkhir,
                    ]);
                },
            ])
            ->orderByDesc('jumlah_kunjungan')
            ->get();

        $maksimumBidang = max(
            1,
            (int) $statistikBidang->max('jumlah_kunjungan')
        );

        /*
        |--------------------------------------------------------------------------
        | TREND KUNJUNGAN 7 HARI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $trendKunjungan = collect();

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = $sekarang
                ->copy()
                ->subDays($i);

            $jumlah = Kunjungan::whereDate(
                'created_at',
                $tanggal->toDateString()
            )->count();

            $trendKunjungan->push([
                'tanggal' => $tanggal->format('d/m'),

                'label' => $tanggal
                    ->locale('id')
                    ->isoFormat('ddd'),

                'jumlah' => $jumlah,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NILAI MAKSIMUM TREND
        |--------------------------------------------------------------------------
        */

        $maksimumTrend = max(
            1,
            (int) $trendKunjungan->max('jumlah')
        );

        /*
        |--------------------------------------------------------------------------
        | KUNJUNGAN TERBARU
        |--------------------------------------------------------------------------
        */

        $kunjunganTerbaru = Kunjungan::with('bidangTujuan')
            ->latest('created_at')
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KUNJUNGAN PERLU PERHATIAN
        |--------------------------------------------------------------------------
        */

        $sekarangWita = now('Asia/Makassar');

        // Kategori A: Status 'baru' yang belum direspon > 10 menit
        $baruBelumDirespon = Kunjungan::with('bidangTujuan')
            ->where('status', 'baru')
            ->where('created_at', '<=', $sekarangWita->copy()->subMinutes(10))
            ->get()
            ->map(function ($k) use ($sekarangWita) {
                $k->kategori = 'baru';
                $k->waktu_acu = $k->created_at;
                $k->lama_menunggu = $k->created_at ? $k->created_at->timezone('Asia/Makassar')->diffInMinutes($sekarangWita) : 0;
                return $k;
            });

        // Kategori B: Status 'diterima' yang belum selesai > 24 jam
        $diterimaBelumSelesai = Kunjungan::with('bidangTujuan')
            ->where('status', 'diterima')
            ->where('diterima_at', '<=', $sekarangWita->copy()->subHours(24))
            ->get()
            ->map(function ($k) use ($sekarangWita) {
                $k->kategori = 'diterima';
                $k->waktu_acu = $k->diterima_at;
                $k->lama_menunggu = $k->diterima_at ? $k->diterima_at->timezone('Asia/Makassar')->diffInMinutes($sekarangWita) : 0;
                return $k;
            });

        // Gabungkan, urutkan dari yang paling lama, ambil maksimal 5
        $perluPerhatian = $baruBelumDirespon
            ->concat($diterimaBelumSelesai)
            ->sortByDesc('lama_menunggu')
            ->take(5)
            ->values();

        $totalPerluPerhatian = $baruBelumDirespon->count() + $diterimaBelumSelesai->count();

        /*
        |--------------------------------------------------------------------------
        | BIDANG TERATAS
        |--------------------------------------------------------------------------
        */

        $bidangTeratas = $statistikBidang->first();

        $persentaseBidangTeratas = 0;

        if ($bidangTeratas && $totalKunjungan > 0) {

            $persentaseBidangTeratas = round(
                ($bidangTeratas->jumlah_kunjungan / $totalKunjungan) * 100
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

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
     * Halaman Laporan Pimpinan
     */
    public function laporan(Request $request)
    {
        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now('Asia/Makassar')->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now('Asia/Makassar')->toDateString()
        );

        $bidangId = $request->input('bidang_id');

        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

        $baseQuery = Kunjungan::with('bidangTujuan')
            ->whereDate(
                'created_at',
                '>=',
                $tanggalMulai
            )
            ->whereDate(
                'created_at',
                '<=',
                $tanggalAkhir
            );

        /*
        |--------------------------------------------------------------------------
        | FILTER BIDANG
        |--------------------------------------------------------------------------
        */

        if ($bidangId) {

            $baseQuery->where(
                'bidang_tujuan_id',
                $bidangId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($status) {

            $baseQuery->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA TABEL
        |--------------------------------------------------------------------------
        */

        $kunjungans = (clone $baseQuery)
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DAFTAR BIDANG
        |--------------------------------------------------------------------------
        */

        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $total = (clone $baseQuery)->count();

        $selesai = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $diterima = (clone $baseQuery)
            ->where('status', 'diterima')
            ->count();

        $menunggu = (clone $baseQuery)
            ->where('status', 'menunggu')
            ->count();

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
     * Export Laporan Pimpinan ke PDF
     */
    public function pdf(Request $request)
    {
        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now('Asia/Makassar')->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now('Asia/Makassar')->toDateString()
        );

        $bidangId = $request->input('bidang_id');

        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Kunjungan::with('bidangTujuan')
            ->whereDate(
                'created_at',
                '>=',
                $tanggalMulai
            )
            ->whereDate(
                'created_at',
                '<=',
                $tanggalAkhir
            );

        /*
        |--------------------------------------------------------------------------
        | FILTER BIDANG
        |--------------------------------------------------------------------------
        */

        if ($bidangId) {

            $query->where(
                'bidang_tujuan_id',
                $bidangId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($status) {

            $query->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $kunjungans = $query
            ->latest('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | NAMA BIDANG
        |--------------------------------------------------------------------------
        */

        $namaBidang = null;

        if ($bidangId) {

            $bidang = Bidang::find($bidangId);

            $namaBidang = $bidang?->nama;
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'pimpinan.laporan-pdf',
            [
                'kunjungans' => $kunjungans,
                'tanggalMulai' => $tanggalMulai,
                'tanggalAkhir' => $tanggalAkhir,
                'namaBidang' => $namaBidang,
                'status' => $status,
            ]
        );

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            'laporan-kunjungan-pimpinan-'.
            $tanggalMulai.
            '-sampai-'.
            $tanggalAkhir.
            '.pdf'
        );
    }

    /**
     * Export Laporan Pimpinan ke CSV / Excel
     */
    public function csv(Request $request)
    {
        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now('Asia/Makassar')->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now('Asia/Makassar')->toDateString()
        );

        $bidangId = $request->input('bidang_id');

        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Kunjungan::with('bidangTujuan')
            ->whereDate(
                'created_at',
                '>=',
                $tanggalMulai
            )
            ->whereDate(
                'created_at',
                '<=',
                $tanggalAkhir
            );

        /*
        |--------------------------------------------------------------------------
        | FILTER BIDANG
        |--------------------------------------------------------------------------
        */

        if ($bidangId) {

            $query->where(
                'bidang_tujuan_id',
                $bidangId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($status) {

            $query->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $kunjungans = $query
            ->latest('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $namaFile =
            'laporan-kunjungan-pimpinan-'.
            $tanggalMulai.
            '-sampai-'.
            $tanggalAkhir.
            '.csv';

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD CSV
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(
            function () use ($kunjungans) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | BOM UTF-8
                |--------------------------------------------------------------------------
                */

                fprintf(
                    $handle,
                    chr(0xEF).
                    chr(0xBB).
                    chr(0xBF)
                );

                /*
                |--------------------------------------------------------------------------
                | HEADER
                |--------------------------------------------------------------------------
                */

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

                /*
                |--------------------------------------------------------------------------
                | DATA
                |--------------------------------------------------------------------------
                */

                foreach ($kunjungans as $index => $kunjungan) {

                    $tanggal = $kunjungan->created_at
                        ? $kunjungan->created_at
                            ->timezone('Asia/Makassar')
                        : null;

                    fputcsv($handle, [

                        $index + 1,

                        $tanggal
                            ? $tanggal->format('d-m-Y')
                            : '-',

                        $tanggal
                            ? $tanggal->format('H:i')
                            : '-',

                        $kunjungan->nama_pengunjung,

                        $kunjungan->nip,

                        $kunjungan->jabatan,

                        $kunjungan->instansi,

                        $kunjungan->bidangTujuan?->nama ?? '-',

                        $kunjungan->keperluan,

                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $kunjungan->status
                            )
                        ),

                        $kunjungan->jawaban_bidang ?? '-',
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
}
