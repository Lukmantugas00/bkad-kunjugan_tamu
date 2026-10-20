
{{--
    Template PDF Laporan Kunjungan SIKUTA
    Kompatibel dengan DomPDF.
    Logo utama: public/images/logo.jpg
--}}
@php
    $tz = 'Asia/Makassar';

    $filter = $filter ?? [
        'tanggal_mulai' => $tanggalMulai ?? request('tanggal_mulai', now($tz)->toDateString()),
        'tanggal_akhir' => $tanggalAkhir ?? request('tanggal_akhir', now($tz)->toDateString()),
        'bidang_id'     => $bidangId ?? request('bidang_id'),
        'status'        => $status ?? request('status'),
        'keperluan'     => $keperluan ?? request('keperluan'),
    ];

    if ($kunjungans instanceof \Illuminate\Contracts\Pagination\Paginator) {
        $kunjungans = collect($kunjungans->items());
    }

    $kunjungans = collect($kunjungans);

    $tglMulai = \Carbon\Carbon::parse($filter['tanggal_mulai'] ?? now($tz)->toDateString())->format('d/m/Y');
    $tglAkhir = \Carbon\Carbon::parse($filter['tanggal_akhir'] ?? now($tz)->toDateString())->format('d/m/Y');
    $dicetak = now($tz)->format('d/m/Y H:i:s') . ' WITA';

    $total = $kunjungans->count();
    $totalBaru = $kunjungans->where('status', 'baru')->count();
    $totalTerima = $kunjungans->where('status', 'diterima')->count();
    $totalAlih = $kunjungans->where('status', 'dialihkan')->count();
    $totalSelesai = $kunjungans->where('status', 'selesai')->count();

    $bidangDipilih = !empty($filter['bidang_id'])
        ? \App\Models\Bidang::find($filter['bidang_id'])
        : null;

    $ketBidang = $bidangDipilih
        ? $bidangDipilih->kode . ' - ' . $bidangDipilih->nama
        : 'Semua Bidang';

    $labelFilterStatus = [
        'baru' => 'Baru',
        'diterima' => 'Diterima',
        'dialihkan' => 'Dialihkan',
        'selesai' => 'Selesai',
    ];

    $ketStatus = $labelFilterStatus[$filter['status'] ?? ''] ?? 'Semua Status';
    $ketKeperluan = trim((string) ($filter['keperluan'] ?? ''));

    /*
    |--------------------------------------------------------------------------
    | LOGO BKAD
    |--------------------------------------------------------------------------
    | Prioritas utama mengikuti logo aplikasi: public/images/logo.jpg
    | Format PNG dan JPEG lainnya digunakan sebagai cadangan.
    */
    $daftarLogo = [
        public_path('images/logo.jpg'),
        public_path('images/logo.png'),
        public_path('images/logo.jpeg'),
        public_path('images/Logo.jpg'),
        public_path('images/Logo.png'),
    ];

    $logo = null;

    foreach ($daftarLogo as $logoPath) {
        if (is_file($logoPath) && is_readable($logoPath)) {
            $ekstensi = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));

            $mime = match ($ekstensi) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                default => null,
            };

            if ($mime) {
                $isiLogo = file_get_contents($logoPath);

                if ($isiLogo !== false && $isiLogo !== '') {
                    $logo = 'data:' . $mime . ';base64,' . base64_encode($isiLogo);
                    break;
                }
            }
        }
    }

    $statusStyle = [
        'baru'      => ['#FEF3C7', '#B45309', 'BARU'],
        'diterima'  => ['#DBEAFE', '#1E40AF', 'DITERIMA'],
        'dialihkan' => ['#F3E8FF', '#7E22CE', 'DIALIHKAN'],
        'selesai'   => ['#DCFCE7', '#166534', 'SELESAI'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>

    <style>
        @page {
            margin: 28px 34px 56px 34px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 9px;
            color: #183532;
            margin: 0;
        }

        /* KOP LAPORAN */
        .kop {
            width: 100%;
            border-collapse: collapse;
        }

        .kop td {
            vertical-align: middle;
            padding: 0;
        }

        .kop .logo-cell {
            width: 75px;
            text-align: left;
            vertical-align: middle;
            padding-right: 10px;
        }

        .kop img {
            display: block;
            width: 62px;
            height: 62px;
            object-fit: contain;
        }

        .kop .logo-fallback {
            width: 52px;
            height: 52px;
            background: #103F3C;
            color: #FFFFFF;
            text-align: center;
            line-height: 52px;
            font-size: 16px;
            font-weight: bold;
        }

        .kop .instansi {
            font-size: 15px;
            font-weight: bold;
            color: #103F3C;
            letter-spacing: .5px;
        }

        .kop .sistem {
            font-size: 10px;
            color: #078577;
            font-weight: bold;
            margin-top: 3px;
        }

        .kop .alamat {
            font-size: 8px;
            color: #718784;
            margin-top: 3px;
        }

        .kop .right {
            text-align: right;
            padding-left: 8px;
        }

        .kop .doc-title {
            font-size: 12px;
            font-weight: bold;
            color: #103F3C;
        }

        .kop .doc-sub {
            font-size: 8px;
            color: #718784;
            margin-top: 4px;
        }

        .garis {
            border-top: 3px solid #078577;
            border-bottom: 1px solid #078577;
            height: 4px;
            margin: 10px 0 14px;
        }

        /* INFORMASI FILTER */
        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .info td {
            padding: 3px 0;
            font-size: 9px;
            vertical-align: top;
        }

        .info .k {
            width: 90px;
            color: #718784;
            font-weight: bold;
        }

        .info .s {
            width: 10px;
        }

        .info .v {
            color: #183532;
            font-weight: bold;
        }

        /* RINGKASAN */
        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px 0;
            margin: 0 -5px 14px;
        }

        .summary td {
            width: 20%;
            background: #F3F7F6;
            border: 1px solid #D8E4E1;
            padding: 8px 7px;
            vertical-align: top;
        }

        .summary .lbl {
            font-size: 7px;
            color: #718784;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .summary .val {
            font-size: 16px;
            font-weight: bold;
            color: #103F3C;
            margin-top: 4px;
        }

        .summary td.primary {
            background: #103F3C;
            border-color: #103F3C;
        }

        .summary td.primary .lbl {
            color: #BFE3DC;
        }

        .summary td.primary .val {
            color: #FFFFFF;
        }

        /* TABEL DATA */
        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data thead th {
            background: #103F3C;
            color: #FFFFFF;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: .2px;
            padding: 7px 5px;
            text-align: left;
            border: 1px solid #103F3C;
        }

        table.data tbody td {
            padding: 6px 5px;
            border: 1px solid #D8E4E1;
            vertical-align: top;
            font-size: 8px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        table.data tbody tr.alt td {
            background: #F7FAF9;
        }

        table.data .c {
            text-align: center;
        }

        table.data .nama {
            font-weight: bold;
            color: #103F3C;
        }

        table.data .muted {
            color: #718784;
        }

        table.data tr {
            page-break-inside: avoid;
        }

        table.data thead {
            display: table-header-group;
        }

        .badge {
            display: inline-block;
            padding: 3px 5px;
            font-size: 7px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #718784;
            border: 1px solid #D8E4E1;
        }

        /* TANDA TANGAN */
        .ttd {
            width: 100%;
            margin-top: 22px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .ttd td {
            width: 70%;
        }

        .ttd td.box {
            width: 30%;
            text-align: center;
            font-size: 9px;
        }

        .ttd .space {
            height: 52px;
        }

        .ttd .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
        }

        /* FOOTER */
        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -38px;
            border-top: 1px solid #D8E4E1;
            padding-top: 5px;
            font-size: 7.5px;
            color: #718784;
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            padding: 0;
        }

        .footer .r {
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- FOOTER --}}
    <div class="footer">
        <table>
            <tr>
                <td>
                    SIKUTA &bull; BKAD Kabupaten Tapin &bull; Dicetak: {{ $dicetak }}
                </td>
                <td class="r"></td>
            </tr>
        </table>
    </div>

    {{-- NOMOR HALAMAN DOMPDF --}}
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 7.5;
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $w = $fontMetrics->getTextWidth($text, $font, $size);

            $pdf->page_text(
                $pdf->get_width() - 34 - $w,
                $pdf->get_height() - 25,
                $text,
                $font,
                $size,
                [0.44, 0.53, 0.52]
            );
        }
    </script>

    {{-- KOP LAPORAN --}}
    <table class="kop">
        <tr>
            <td class="logo-cell">
                @if ($logo)
                    <img src="{{ $logo }}" alt="Logo BKAD Kabupaten Tapin">
                @else
                    <div class="logo-fallback">S</div>
                @endif
            </td>

            <td>
                <div class="instansi">BKAD KABUPATEN TAPIN</div>
                <div class="sistem">Sistem Informasi Kunjungan Tamu</div>
                <div class="alamat">
                    Badan Keuangan dan Aset Daerah Kabupaten Tapin
                </div>
            </td>

            <td class="right">
                <div class="doc-title">LAPORAN KUNJUNGAN TAMU</div>
                <div class="doc-sub">
                    Periode {{ $tglMulai }} s.d. {{ $tglAkhir }} WITA
                </div>
            </td>
        </tr>
    </table>

    <div class="garis"></div>

    {{-- KETERANGAN LAPORAN --}}
    <table class="info">
        <tr>
            <td class="k">Periode</td>
            <td class="s">:</td>
            <td class="v">{{ $tglMulai }} s.d. {{ $tglAkhir }} WITA</td>
        </tr>

        <tr>
            <td class="k">Bidang</td>
            <td class="s">:</td>
            <td class="v">{{ $ketBidang }}</td>
        </tr>

        <tr>
            <td class="k">Status</td>
            <td class="s">:</td>
            <td class="v">{{ $ketStatus }}</td>
        </tr>

        @if ($ketKeperluan !== '')
            <tr>
                <td class="k">Kata Kunci</td>
                <td class="s">:</td>
                <td class="v">{{ $ketKeperluan }}</td>
            </tr>
        @endif

        <tr>
            <td class="k">Dicetak</td>
            <td class="s">:</td>
            <td class="v">{{ $dicetak }}</td>
        </tr>
    </table>

    {{-- RINGKASAN --}}
    <table class="summary">
        <tr>
            <td class="primary">
                <div class="lbl">Total Kunjungan</div>
                <div class="val">{{ number_format($total) }}</div>
            </td>

            <td>
                <div class="lbl">Baru</div>
                <div class="val">{{ number_format($totalBaru) }}</div>
            </td>

            <td>
                <div class="lbl">Diterima</div>
                <div class="val">{{ number_format($totalTerima) }}</div>
            </td>

            <td>
                <div class="lbl">Dialihkan</div>
                <div class="val">{{ number_format($totalAlih) }}</div>
            </td>

            <td>
                <div class="lbl">Selesai</div>
                <div class="val">{{ number_format($totalSelesai) }}</div>
            </td>
        </tr>
    </table>

    {{-- TABEL KUNJUNGAN --}}
    @if ($kunjungans->count() > 0)
        <table class="data">
            <thead>
                <tr>
                    <th class="c" style="width: 5%;">No</th>
                    <th style="width: 14%;">Waktu</th>
                    <th style="width: 26%;">Pengunjung</th>
                    <th style="width: 18%;">Bidang Tujuan</th>
                    <th style="width: 27%;">Keperluan</th>
                    <th class="c" style="width: 10%;">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kunjungans as $i => $k)
                    @php
                        $st = $statusStyle[$k->status]
                            ?? ['#F1F5F9', '#475569', strtoupper((string) $k->status)];

                        $waktu = $k->created_at
                            ? $k->created_at->timezone($tz)
                            : null;
                    @endphp

                    <tr class="{{ $i % 2 ? 'alt' : '' }}">
                        <td class="c">{{ $i + 1 }}</td>

                        <td>
                            @if ($waktu)
                                {{ $waktu->format('d/m/Y') }}
                                <br>
                                <span class="muted">
                                    {{ $waktu->format('H:i') }} WITA
                                </span>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>

                        <td>
                            <span class="nama">
                                {{ $k->nama_pengunjung ?: '-' }}
                            </span>

                            @if ($k->nip)
                                <br>
                                <span class="muted">NIP: {{ $k->nip }}</span>
                            @endif

                            @if ($k->jabatan || $k->instansi)
                                <br>
                                {{ collect([$k->jabatan, $k->instansi])->filter()->implode(' - ') }}
                            @endif
                        </td>

                        <td>
                            {{ $k->bidangTujuan?->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $k->keperluan ?: '-' }}
                        </td>

                        <td class="c">
                            <span
                                class="badge"
                                style="background: {{ $st[0] }}; color: {{ $st[1] }};"
                            >
                                {{ $st[2] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">
            Tidak ada data kunjungan pada periode dan filter yang dipilih.
        </div>
    @endif

    {{-- TANDA TANGAN --}}
    <table class="ttd">
        <tr>
            <td></td>

            <td class="box">
                Tapin, {{ now($tz)->translatedFormat('d F Y') }}
                <br>
                Administrator

                <div class="space"></div>

                <div class="nama-ttd">
                    {{ auth()->user()->name ?? '____________________' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
