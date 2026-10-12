<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Kunjungan
    </title>

    <style>

        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #111827;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 4px 0 0;
            font-size: 13px;
            font-weight: normal;
        }

        .header p {
            margin: 6px 0 0;
            font-size: 9px;
        }

        .line {
            border-bottom: 2px solid #111827;
            margin-top: 10px;
        }

        .filter-info {
            margin-bottom: 12px;
        }

        .filter-info table {
            width: 100%;
        }

        .filter-info td {
            padding: 2px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #e5e7eb;
            border: 1px solid #9ca3af;
            padding: 6px 5px;
            text-align: center;
            font-size: 8px;
        }

        table.data td {
            border: 1px solid #9ca3af;
            padding: 5px;
            vertical-align: top;
            font-size: 8px;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 8px;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>
            PEMERINTAH KABUPATEN TAPIN
        </h1>

        <h2>
            BADAN KEUANGAN DAN ASET DAERAH
        </h2>

        <h1 style="margin-top: 10px;">
            LAPORAN KUNJUNGAN TAMU
        </h1>

        <p>
            Periode
            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
            s/d
            {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}
        </p>

        <div class="line"></div>

    </div>


    <div class="filter-info">

        <table>

            <tr>

                <td width="100">
                    Bidang
                </td>

                <td>
                    :
                    {{ $namaBidang ?? 'Semua Bidang' }}
                </td>

            </tr>

            <tr>

                <td>
                    Status
                </td>

                <td>
                    :
                    {{ $status
                        ? ucfirst(str_replace('_', ' ', $status))
                        : 'Semua Status'
                    }}
                </td>

            </tr>

            <tr>

                <td>
                    Dicetak
                </td>

                <td>
                    :
                    {{ now('Asia/Makassar')->format('d-m-Y H:i') }}
                </td>

            </tr>

        </table>

    </div>


    <table class="data">

        <thead>

            <tr>

                <th width="25">
                    No
                </th>

                <th width="75">
                    Tanggal
                </th>

                <th width="120">
                    Pengunjung
                </th>

                <th width="100">
                    Instansi
                </th>

                <th width="110">
                    Bidang Tujuan
                </th>

                <th>
                    Keperluan
                </th>

                <th width="65">
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
                        {{ optional($kunjungan->created_at)
                            ->timezone('Asia/Makassar')
                            ->format('d-m-Y H:i')
                        }}
                    </td>

                    <td>

                        <strong>
                            {{ $kunjungan->nama_pengunjung }}
                        </strong>

                        @if ($kunjungan->nip)
                            <br>
                            NIP:
                            {{ $kunjungan->nip }}
                        @endif

                        @if ($kunjungan->jabatan)
                            <br>
                            {{ $kunjungan->jabatan }}
                        @endif

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
                        {{ ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $kunjungan->status
                            )
                        ) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="center"
                    >
                        Tidak ada data kunjungan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        <strong>
            Total data:
            {{ $kunjungans->count() }}
            kunjungan
        </strong>

    </div>

</body>

</html>
