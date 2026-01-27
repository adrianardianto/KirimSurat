<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }

            @page {
                margin: 1cm;
                size: landscape;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        .btn-print {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .btn-print:hover {
            background-color: #4338ca;
        }
    </style>
</head>

<body>

    <div class="no-print" style="text-align: right; padding: 20px;">
        <button onclick="window.print()" class="btn-print">Cetak Laporan</button>
    </div>

    <h2>LAPORAN REKAPITULASI SURAT</h2>
    <p class="sub-header">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">No. Surat</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 15%">Pengirim</th>
                <th style="width: 15%">Penerima</th>
                <th style="width: 25%">Perihal</th>
                <th style="width: 10%">Tanggal</th>
                <th style="width: 5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->reference_number }}</td>
                    <td style="text-transform: capitalize;">{{ $item->type }}</td>
                    <td>{{ $item->sender }}</td>
                    <td>{{ $item->recipient }}</td>
                    <td>{{ $item->subject }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                    <td style="text-transform: capitalize;">{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
