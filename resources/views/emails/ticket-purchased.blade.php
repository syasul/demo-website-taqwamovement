<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket Taqwa Movement</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #F9F6F0;
            color: #241640;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(80, 46, 136, 0.05);
            border: 1px solid rgba(80, 46, 136, 0.05);
        }
        .header {
            background-color: #502E88;
            padding: 40px 20px;
            text-align: center;
            color: #FFFFFF;
        }
        .header h1 {
            font-family: Georgia, serif;
            margin: 0;
            font-size: 28px;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            color: #EDCCD7;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            font-family: Georgia, serif;
            font-size: 20px;
            color: #502E88;
            margin-top: 0;
        }
        .details-box {
            background-color: #EDCCD7;
            background-color: rgba(237, 204, 215, 0.2);
            border-left: 4px solid #CA80DC;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .details-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-box td {
            padding: 6px 0;
            font-size: 14px;
        }
        .details-box td.label {
            color: rgba(36, 22, 64, 0.6);
            width: 30%;
            font-weight: bold;
        }
        .footer {
            background-color: #241640;
            color: #EDCCD7;
            padding: 30px 20px;
            text-align: center;
            font-size: 12px;
        }
        .footer a {
            color: #CA80DC;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Elevating faith. Empowering life.</p>
            <h1>Taqwa Movement</h1>
        </div>
        <div class="content">
            <h2>Assalamualaikum {{ $order->user->name }},</h2>
            <p>Alhamdulillah, kami telah memverifikasi pembayaran Anda untuk pemesanan tiket <strong>{{ $order->event->title }}</strong>.</p>
            <p>Rincian pemesanan Anda terlampir di bawah ini. E-Ticket resmi Anda dalam format PDF sudah kami sertakan sebagai lampiran email ini. Silakan unduh dan tunjukkan QR Code pada tiket tersebut saat melakukan registrasi ulang di lokasi acara.</p>
            
            <div class="details-box">
                <table>
                    <tr>
                        <td class="label">No. Order</td>
                        <td><strong>{{ $order->order_number }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Event</td>
                        <td>{{ $order->event->title }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal</td>
                        <td>{{ $order->event->date->format('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Lokasi</td>
                        <td>{{ $order->event->location }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total Bayar</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <p>Terima kasih telah bergabung dalam ekosistem tumbuh bersama ini. Semoga Allah senantiasa melimpahkan kelapangan batin dan petunjuk dalam kehidupan kita.</p>
            
            <p style="margin-top: 30px;">Salam hangat,<br><strong>Tim Taqwa Movement</strong></p>
        </div>
        <div class="header" style="background-color: #241640; padding: 25px 20px; font-size: 12px; color: #EDCCD7;">
            Situs web: <a href="{{ url('/') }}" style="color: #CA80DC; text-decoration: none;">taqwamovement.id</a> | Hubungi Kami jika ada kendala.
        </div>
    </div>
</body>
</html>
