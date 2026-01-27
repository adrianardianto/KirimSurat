<!DOCTYPE html>
<html>

<head>
    <title>Surat #{{ $surat->reference_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 20px;
            padding-bottom: 80px;
            position: relative;
            min-height: 100vh;
        }

        /* Letterhead - DIPERBAIKI untuk benar-benar tengah */
        .letterhead-container {
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .letterhead {
            display: inline-block;
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            width: 100%;
            max-width: 800px;
        }

        .letterhead h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .letterhead h2 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0 0 8px 0;
        }

        .letterhead p {
            font-size: 10pt;
            margin: 3px 0;
            line-height: 1.4;
        }

        /* Status Badge - DIPINDAHKAN ke bawah letterhead */
        .status-badge {
            text-align: center;
            padding: 8px 20px;
            border: 2px solid;
            font-weight: bold;
            font-size: 12pt;
            margin: 10px auto 20px auto;
            display: inline-block;
        }

        .status-approved {
            border-color: #059669;
            color: #059669;
        }

        .status-pending {
            border-color: #d97706;
            color: #d97706;
        }

        .status-rejected {
            border-color: #dc2626;
            color: #dc2626;
        }

        /* Reference */
        .reference {
            text-align: right;
            margin: 20px 0;
        }

        .reference table {
            margin-left: auto;
            border-collapse: collapse;
        }

        .reference td {
            padding: 2px 8px;
            font-size: 10pt;
        }

        .reference .label {
            text-align: left;
            width: 80px;
        }

        /* Date */
        .date {
            text-align: right;
            margin: 15px 0;
        }

        /* Recipient */
        .recipient {
            margin: 15px 0;
        }

        .recipient p {
            margin: 3px 0;
        }

        /* Greeting */
        .greeting {
            margin: 15px 0;
        }

        /* Content */
        .content {
            text-align: justify;
            margin: 15px 0;
        }

        .content p {
            margin-bottom: 12px;
            text-indent: 40px;
        }

        /* Closing */
        .closing {
            margin: 20px 0;
        }


        /* Approved By Style */
        .approved-by {
            background-color: #059669;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 15px;
            display: inline-block;
        }

        .signature-name {
            font-weight: bold;
            font-size: 12pt;
            margin: 10px 0;
        }

        .signature-position {
            font-weight: bold;
            font-size: 10pt;
            margin: 5px 0;
        }

        .signature-user {
            color: #666;
            font-size: 9pt;
            margin-top: 5px;
        }

        /* Footer - DIUBAH menjadi fixed */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            padding: 10px 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #666;
            z-index: 100;
        }

        /* Container untuk konten utama */
        .main-content {
            margin-bottom: 50px;
        }

        /* Clearfix */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Center container */
        .center-container {
            text-align: center;
            width: 100%;
        }

        /* Signature & QR Code */
        .signature-container {
            margin-top: 20px;
            text-align: right;
            page-break-inside: auto;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            width: 280px;
        }

        .qr-code {
            margin: 10px auto;
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .digital-sign {
            /* border: 1px solid #ccc; */
            /* padding: 10px; */
            /* border-radius: 8px; */
            /* background: #fafafa; */
        }
    </style>
</head>

<body>
    <div class="main-content">
        <!-- Letterhead Container -->
        <div class="center-container">
            <div class="letterhead">
                <h1>KIRIM SURAT</h1>
                <h2>Sistem Manajemen Persuratan Digital</h2>
                <p>Jl. Contoh No. 123, Jakarta 12345</p>
                <p>Telp: (021) 1234-5678 | Email: info@example.com</p>
            </div>

            <!-- Status Badge - DIPINDAH ke sini -->
            @if ($surat->status == 'approved')
                <div class="status-badge status-approved">DISETUJUI</div>
            @elseif($surat->status == 'pending')
                <div class="status-badge status-pending">MENUNGGU</div>
            @elseif($surat->status == 'rejected')
                <div class="status-badge status-rejected">DITOLAK</div>
            @endif
        </div>

        <!-- Reference Number -->
        <div class="reference">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td>:</td>
                    <td><strong>{{ $surat->reference_number }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td>:</td>
                    <td>{{ $surat->file_path ? '1 (satu) berkas' : '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td>:</td>
                    <td><strong><u>{{ $surat->subject }}</u></strong></td>
                </tr>
            </table>
        </div>

        <!-- Date -->
        <div class="date">
            Jakarta, {{ $surat->date->isoFormat('D MMMM Y') }}
        </div>

        <!-- Recipient -->
        <div class="recipient">
            <p>Kepada Yth.</p>
            <p><strong>{{ $surat->recipient }}</strong></p>
            <p>di Tempat</p>
        </div>

        <!-- Greeting -->
        <div class="greeting">
            <p>Dengan hormat,</p>
        </div>

        <!-- Content -->
        <div class="content">
            @foreach (explode("\n", $surat->content) as $paragraph)
                @if (trim($paragraph))
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        </div>

        <!-- Closing -->
        <div class="closing">
            <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
        </div>

        <!-- Signature & Validation -->
        <div class="signature-container">
            <div class="signature-box">
                <p>Hormat Kami,</p>

                @if ($surat->status == 'approved' && $surat->approver)
                    <div class="digital-sign">
                        @if (isset($base64Qr))
                            <img src="{{ $base64Qr }}" class="qr-code" alt="QR Validation">
                        @else
                            <p>[QR Failed to Load]</p>
                        @endif
                        <p class="signature-name" style="margin-bottom: 0;">{{ $surat->approver->name }}</p>
                        <p class="signature-user" style="font-size: 8pt;">Digital Signed / Verified</p>
                    </div>
                @else
                    <br><br><br><br>
                    <p class="signature-name">(.........................)</p>
                    <p class="signature-user">Admin / Staff</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer - SELALU DI BAWAH -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh {{ config('app.name') }} pada
            {{ now()->isoFormat('dddd, D MMMM Y HH:mm:ss') }}</p>
        <p style="font-size: 7pt; margin-top: 3px;">Dokumen ini sah dan tidak memerlukan tanda tangan basah |
            Verifikasi: {{ url()->signedRoute('surat.verify', ['surat' => $surat->id]) }}</p>
    </div>
</body>

</html>
