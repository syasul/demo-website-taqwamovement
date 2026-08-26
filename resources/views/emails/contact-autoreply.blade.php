<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Anda Telah Diterima</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F8FAFC; padding: 30px; color: #241640;">
    <div style="max-width: 600px; margin: 0 auto; bg-color: #FFFFFF; background: #FFFFFF; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(80,46,136,0.05); border: 1px border #EDCCD7;">
        <h2 style="color: #502E88; font-family: serif; margin-bottom: 20px;">Assalamu'alaikum {{ $messageData->name }},</h2>
        <p style="font-size: 14px; line-height: 1.6; color: #475569;">Terima kasih telah menghubungi Taqwa Movement. Kami mengonfirmasi bahwa pesan yang Anda kirimkan telah kami terima dengan baik.</p>
        
        <p style="font-size: 14px; line-height: 1.6; color: #475569;">Tim admin kami akan membaca pesan Anda dan segera merespons melalui email ini atau nomor kontak yang telah Anda sertakan dalam waktu maksimal 2x24 jam kerja.</p>

        <div style="background-color: #F8FAFC; border-left: 4px solid #CA80DC; padding: 15px; border-radius: 4px; margin: 25px 0;">
            <span style="font-size: 12px; text-transform: uppercase; color: #502E88; font-weight: bold; tracking-wider: 1px; display: block; margin-bottom: 5px;">Salinan Pesan Anda:</span>
            <p style="margin: 0; font-size: 14px; line-height: 1.6; white-space: pre-wrap; font-style: italic; color: #64748B;">"{{ $messageData->message }}"</p>
        </div>

        <p style="font-size: 14px; line-height: 1.6; color: #475569;">Sembari menunggu, Anda juga dapat menjelajahi artikel jurnal refleksi terbaru kami atau mendaftar program event mendatang di website kami.</p>

        <p style="font-size: 14px; line-height: 1.6; color: #475569; margin-top: 30px;">
            Salam hangat,<br>
            <strong>Tim Taqwa Movement</strong>
        </p>
    </div>
</body>
</html>
