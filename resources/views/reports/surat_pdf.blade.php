<!DOCTYPE html>
<html>

<head>
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
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Data Surat</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Surat</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Pengirim</th>
                <th>Penerima</th>
                <th>Subjek</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $surat->reference_number }}</td>
                    <td>{{ ucfirst($surat->type) }}</td>
                    <td>{{ $surat->category ? $surat->category->name : '-' }}</td>
                    <td>{{ $surat->sender }}</td>
                    <td>{{ $surat->recipient }}</td>
                    <td>{{ $surat->subject }}</td>
                    <td>{{ date('d-m-Y', strtotime($surat->date)) }}</td>
                    <td>{{ ucfirst($surat->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
