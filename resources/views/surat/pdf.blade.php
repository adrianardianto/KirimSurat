<!DOCTYPE html>
<html>

<head>
    <title>Surat #{{ $surat->reference_number }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
        }

        .meta {
            margin-bottom: 30px;
        }

        .meta table {
            width: 100%;
        }

        .meta td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 120px;
        }

        .content {
            margin-bottom: 50px;
            line-height: 1.6;
            text-align: justify;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signature {
            float: right;
            width: 200px;
            text-align: center;
            margin-top: 50px;
        }

        .status-stamp {
            position: absolute;
            top: 100px;
            right: 50px;
            border: 3px solid green;
            color: green;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 20px;
            transform: rotate(-15deg);
            opacity: 0.5;
        }
    </style>
</head>

<body>
    @if ($surat->status == 'approved')
        <div class="status-stamp">APPROVED</div>
    @endif

    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Sistem Manajemen Persuratan Digital</p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td class="label">Nomor Surat</td>
                <td>: {{ $surat->reference_number }}</td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td>: {{ $surat->file_path ? '1 Berkas' : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td>: {{ $surat->subject }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $surat->date->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="meta" style="margin-top: 20px;">
        <table>
            <tr>
                <td class="label">Kepada Yth.</td>
                <td>: {{ $surat->recipient }}</td>
            </tr>
            <tr>
                <td class="label">Dari</td>
                <td>: {{ $surat->sender }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Dengan hormat,</p>
        <p>
            {{ $surat->content }}
        </p>
        <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p>Menyetujui,</p>
        <br><br><br>
        <p><strong>{{ $surat->approver->name ?? 'Administrator' }}</strong></p>
        @if ($surat->approved_at)
            <p style="font-size: 10px;">Digitally Signed<br>on
                {{ $surat->approved_at->format('d/m/Y H:i') }}</p>
        @endif
    </div>

    <div class="footer">
        Dicetak otomatis oleh Sistem {{ config('app.name') }} pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>

</html>
