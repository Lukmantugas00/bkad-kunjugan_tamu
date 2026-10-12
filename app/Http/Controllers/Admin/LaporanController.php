<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now()->timezone('Asia/Makassar')->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now()->timezone('Asia/Makassar')->toDateString()
        );

        $query = Kunjungan::with('bidangTujuan');

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE WITA
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {
            $mulai = Carbon::parse(
                $tanggalMulai,
                'Asia/Makassar'
            )->startOfDay()->utc();

            $query->where(
                'created_at',
                '>=',
                $mulai
            );
        }

        if ($tanggalAkhir) {
            $akhir = Carbon::parse(
                $tanggalAkhir,
                'Asia/Makassar'
            )->endOfDay()->utc();

            $query->where(
                'created_at',
                '<=',
                $akhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER BIDANG
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bidang_id')) {
            $query->where(
                'bidang_tujuan_id',
                $request->bidang_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KEPERLUAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('keperluan')) {
            $keperluan = trim($request->keperluan);

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
        return [
            'tanggal_mulai' => $request->input(
                'tanggal_mulai',
                now()->timezone('Asia/Makassar')->toDateString()
            ),

            'tanggal_akhir' => $request->input(
                'tanggal_akhir',
                now()->timezone('Asia/Makassar')->toDateString()
            ),

            'bidang_id' => $request->input('bidang_id'),

            'status' => $request->input('status'),

            'keperluan' => $request->input('keperluan'),
        ];
    }

    public function index(Request $request)
    {
        $query = $this->buildQuery($request);

        $filter = $this->filterData($request);

        $total = (clone $query)->count();

        $totalBaru = (clone $query)
            ->where('status', 'baru')
            ->count();

        $totalDiterima = (clone $query)
            ->where('status', 'diterima')
            ->count();

        $totalSelesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $rekapBidang = (clone $query)
            ->selectRaw(
                'bidang_tujuan_id, COUNT(*) as jumlah'
            )
            ->groupBy('bidang_tujuan_id')
            ->with('bidangTujuan')
            ->get()
            ->sortByDesc('jumlah');

        $kunjungans = $query
            ->orderByDesc('created_at')
            ->paginate(20)
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

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function pdf(Request $request)
    {
        $query = $this->buildQuery($request);

        $kunjungans = $query
            ->orderByDesc('created_at')
            ->get();

        $filter = $this->filterData($request);

        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            compact(
                'kunjungans',
                'filter'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        $namaFile = 'laporan-kunjungan-'
            .$filter['tanggal_mulai']
            .'-'
            .$filter['tanggal_akhir']
            .'.pdf';

        return $pdf->download($namaFile);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT CSV / EXCEL
    |--------------------------------------------------------------------------
    */

    public function csv(Request $request): StreamedResponse
    {
        $query = $this->buildQuery($request);

        $kunjungans = $query
            ->orderByDesc('created_at')
            ->get();

        $filter = $this->filterData($request);

        $namaFile = 'laporan-kunjungan-'
            .$filter['tanggal_mulai']
            .'-'
            .$filter['tanggal_akhir']
            .'.csv';

        return response()->streamDownload(
            function () use ($kunjungans) {

                $handle = fopen('php://output', 'w');

                /*
                |--------------------------------------------------------------------------
                | BOM AGAR EXCEL MEMBACA UTF-8
                |--------------------------------------------------------------------------
                */

                fprintf(
                    $handle,
                    chr(0xEF).chr(0xBB).chr(0xBF)
                );

                fputcsv(
                    $handle,
                    [
                        'No',
                        'Waktu',
                        'Nama Pengunjung',
                        'NIP',
                        'Jabatan',
                        'Instansi',
                        'Bidang Tujuan',
                        'Keperluan',
                        'Status',
                    ],
                    ';'
                );

                foreach ($kunjungans as $index => $kunjungan) {

                    $waktu = $kunjungan->created_at
                        ? $kunjungan->created_at
                            ->timezone('Asia/Makassar')
                            ->format('d-m-Y H:i:s')
                        : '-';

                    fputcsv(
                        $handle,
                        [
                            $index + 1,
                            $waktu,
                            $kunjungan->nama_pengunjung,
                            $kunjungan->nip,
                            $kunjungan->jabatan,
                            $kunjungan->instansi,
                            $kunjungan->bidangTujuan?->nama ?? '-',
                            $kunjungan->keperluan,
                            strtoupper($kunjungan->status),
                        ],
                        ';'
                    );
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
