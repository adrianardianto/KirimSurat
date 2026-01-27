<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Surat - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .status-icon {
            font-size: 64px;
            margin-bottom: 20px;
            color: #10b981;
        }

        .status-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .status-desc {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .details {
            text-align: left;
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .detail-row {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
            margin-top: 2px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">KIRIM SURAT</div>

        @if ($surat->status == 'approved')
            <div class="status-icon">✓</div>
            <div class="status-title">Dokumen Valid</div>
            <div class="status-desc">Surat ini telah disetujui secara digital dan tercatat dalam sistem kami.</div>
        @elseif($surat->status == 'rejected')
            <div class="status-icon" style="color: #ef4444;">✕</div>
            <div class="status-title">Dokumen Ditolak</div>
            <div class="status-desc">Surat ini telah ditolak oleh pimpinan dan tidak berlaku.</div>
        @else
            <div class="status-icon" style="color: #f59e0b;">!</div>
            <div class="status-title">Menunggu Persetujuan</div>
            <div class="status-desc">Surat ini masih dalam proses peninjauan dan belum disahkan.</div>
        @endif

        <div class="details">
            <div class="detail-row">
                <span class="detail-label">Nomor Surat</span>
                <span class="detail-value">{{ $surat->reference_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Perihal</span>
                <span class="detail-value">{{ $surat->subject }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Surat</span>
                <span class="detail-value">{{ $surat->date->isoFormat('D MMMM Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    @if ($surat->status == 'approved')
                        <span class="badge badge-success">Disetujui</span>
                    @elseif($surat->status == 'rejected')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-warning">Menunggu</span>
                    @endif
                </span>
            </div>
            @if ($surat->status == 'approved' && $surat->approver)
                <div class="detail-row">
                    <span class="detail-label">Disetujui Oleh</span>
                    <span class="detail-value">{{ $surat->approver->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Persetujuan</span>
                    <span class="detail-value">{{ $surat->approved_at->isoFormat('D MMMM Y HH:mm') }}</span>
                </div>
            @endif
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
            Validation ID: {{ $surat->id }}
        </div>
    </div>
</body>

</html>
