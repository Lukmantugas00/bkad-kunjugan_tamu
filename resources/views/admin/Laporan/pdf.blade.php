<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Laporan Kunjungan</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
        }

        .header h2 {
            margin: 4px 0;
            font-size: 12px;
        }

        .header p {
            margin: 3px 0;
            font-size: 9px;
        }

        .info {
            margin-bottom: 12px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 2px 0;
        }

        .data {
            width: 100%;
            border-collapse: collapse;
        }

        .data th {
            background: #1f4e78;
            color: white;
            padding: 6px 4px;
            border: 1px solid #999;
            font-size: 8px;
        }

        .data td {
            padding: 5px 4px;
            border: 1px solid #bbb;
            font-size: 8px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 8px;
        }
    </style>
</head>

<body>

<div class="header">

    <h1>
        BKAD KABUPATEN TAPIN
    </h1>

    <h2>
        SISTEM KUNJUNGAN TAMU
    </h2>

    <p>
        LAPORAN KUNJUNGAN TAMU
    </p>

</div>

<div class="info">

    <table>

        <tr>
            <td width="100">
                Periode
            </td>

            <td>
                :
                {{ \Carbon\Carbon::parse($filter['tanggal_mulai'])->format('d-m-Y') }}
                s.d.
                {{ \Carbon\Carbon::parse($filter['tanggal_akhir'])->format('d-m-Y') }}
                WITA
            </td>
        </tr>

        @if ($filter['keperluan'])

            <tr>
                <td>
                    Keperluan
                </td>

                <td>
                    :
                    {{ $filter['keperluan'] }}
                </td>
            </tr>

        @endif

    </table>

</div>

<table class="data">

    <thead>

        <tr>

            <th width="25">
                No
            </th>

            <th width="75">
                Waktu
            </th>

            <th>
                Pengunjung
            </th>

            <th width="80">
                NIP
            </th>

            <th>
                Jabatan
            </th>

            <th>
                Instansi
            </th>

            <th>
                Bidang Tujuan
            </th>

            <th>
                Keperluan
            </th>

            <th width="55">
                Status
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse ($kunjungans as $index => $kunjungan)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $kunjungan->created_at
                        ? $kunjungan->created_at
                            ->timezone('Asia/Makassar')
                            ->format('d-m-Y H:i')
                        : '-' }}
                </td>

                <td>
                    {{ $kunjungan->nama_pengunjung }}
                </td>

                <td>
                    {{ $kunjungan->nip }}
                </td>

                <td>
                    {{ $kunjungan->jabatan }}
                </td>

                <td>
                    {{ $kunjungan->instansi }}
                </td>

                <td>
                    {{ $kunjungan->bidangTujuan?->nama ?? '-' }}
                </td>

                <td>
                    {{ $kunjungan->keperluan }}
                </td>

                <td class="center">
                    {{ strtoupper($kunjungan->status) }}
                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="9"
                    class="center"
                >
                    Tidak ada data kunjungan.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">

    Dicetak:
    {{ now()->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }}
    WITA

</div>

</body>
</html>
