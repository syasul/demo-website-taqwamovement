<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket Taqwa Movement</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #F9F6F0;
            color: #241640;
            margin: 0;
            padding: 0;
        }
        .ticket-wrapper {
            width: 100%;
            height: 100%;
            page-break-after: always;
            box-sizing: border-box;
            padding: 40px;
        }
        .ticket-wrapper:last-child {
            page-break-after: avoid;
        }
        .card {
            background-color: #FFFFFF;
            border-radius: 20px;
            border: 2px solid #EDCCD7;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(80, 46, 136, 0.04);
            margin: 0 auto;
            max-width: 580px;
        }
        .header {
            background-color: #502E88;
            color: #FFFFFF;
            padding: 25px;
            text-align: center;
        }
        .header .logo {
            font-size: 20px;
            font-family: Georgia, serif;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header .subtitle {
            font-size: 11px;
            color: #EDCCD7;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }
        .body {
            padding: 30px;
        }
        .event-title {
            font-family: Georgia, serif;
            font-size: 22px;
            color: #502E88;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: bold;
            line-height: 1.3;
        }
        .grid-info {
            width: 100%;
            margin-bottom: 30px;
        }
        .grid-info td {
            padding: 8px 0;
            vertical-align: top;
        }
        .grid-info td.label {
            width: 30%;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(36, 22, 64, 0.5);
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .grid-info td.value {
            width: 70%;
            font-size: 14px;
            color: #241640;
            font-weight: 600;
        }
        .divider {
            border-top: 2px dashed #EDCCD7;
            margin: 20px 0;
        }
        .qr-section {
            text-align: center;
            padding: 10px 0;
        }
        .qr-section img {
            border: 4px solid #EDCCD7;
            border-radius: 8px;
            padding: 5px;
            background-color: #FFFFFF;
        }
        .ticket-code {
            font-family: monospace;
            font-size: 16px;
            color: #502E88;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 10px;
            display: block;
        }
        .footer-note {
            background-color: #241640;
            color: #EDCCD7;
            text-align: center;
            padding: 15px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    @foreach ($items as $item)
        <div class="ticket-wrapper">
            <div class="card">
                <div class="header">
                    <div class="logo">TAQWA MOVEMENT</div>
                    <div class="subtitle">Official E-Ticket</div>
                </div>
                <div class="body">
                    <h2 class="event-title">{{ $event->title }}</h2>
                    
                    <table class="grid-info">
                        <tr>
                            <td class="label">Nama Peserta</td>
                            <td class="value">{{ $item->attendee_name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email Peserta</td>
                            <td class="value">{{ $item->attendee_email }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Event</td>
                            <td class="value">{{ $event->date->format('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jam Acara</td>
                            <td class="value">09.00 - 15.30 WIB</td>
                        </tr>
                        <tr>
                            <td class="label">Lokasi</td>
                            <td class="value">{{ $event->location }}</td>
                        </tr>
                    </table>

                    <div class="divider"></div>

                    <div class="qr-section">
                        @if ($item->eTicket)
                            <img src="data:image/png;base64, {!! base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(140)->margin(0)->generate($item->eTicket->qr_payload)) !!}" alt="QR Code Check-in" />
                            <span class="ticket-code">{{ $item->eTicket->ticket_code }}</span>
                        @endif
                    </div>
                </div>
                <div class="footer-note">
                    Harap tunjukkan QR Code di atas kepada panitia registrasi di lokasi acara.
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
