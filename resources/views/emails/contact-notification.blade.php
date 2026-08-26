<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Baru Masuk</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F8FAFC; padding: 30px; color: #241640;">
    <div style="max-width: 600px; margin: 0 auto; bg-color: #FFFFFF; background: #FFFFFF; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(80,46,136,0.05); border: 1px border #EDCCD7;">
        <h2 style="color: #502E88; font-family: serif; margin-bottom: 20px;">Pesan Baru Masuk</h2>
        <p style="font-size: 14px; line-height: 1.6; color: #64748B;">Ada pesan baru yang masuk melalui formulir kontak website Taqwa Movement. Berikut rinciannya:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; font-weight: bold; width: 120px; border-bottom: 1px solid #F1F5F9;">Nama:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F1F5F9;">{{ $messageData->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-weight: bold; border-bottom: 1px solid #F1F5F9;">Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F1F5F9;"><a href="mailto:{{ $messageData->email }}" style="color: #7558B1; text-decoration: none;">{{ $messageData->email }}</a></td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-weight: bold; border-bottom: 1px solid #F1F5F9;">No. HP:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F1F5F9;">{{ $messageData->phone ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-weight: bold; border-bottom: 1px solid #F1F5F9;">Tanggal:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F1F5F9;">{{ $messageData->created_at->format('d M Y, H:i') }} WIB</td>
            </tr>
        </table>

        <div style="background-color: #F8FAFC; border-left: 4px solid #502E88; padding: 15px; border-radius: 4px; margin-bottom: 25px;">
            <h4 style="margin: 0 0 10px 0; color: #502E88;">Isi Pesan:</h4>
            <p style="margin: 0; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $messageData->message }}</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/admin/messages') }}" style="display: inline-block; padding: 12px 30px; background-color: #502E88; color: #FFFFFF; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 10px rgba(80,46,136,0.15);">
                Lihat di Admin Panel
            </a>
        </div>
    </div>
</body>
</html>
