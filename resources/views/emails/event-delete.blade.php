<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Pembatalan Acara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#FFF8F6; font-family:Arial, Helvetica, sans-serif; color:#5F1D2A;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<table width="100%" cellpadding="0" cellspacing="0"
       style="max-width:600px; background:#ffffff; border-radius:14px; box-shadow:0 8px 24px rgba(0,0,0,0.08); overflow:hidden;">

    {{-- HEADER --}}
    <tr>
        <td style="background:#F8D9DF; padding:24px; text-align:center;">
            <h1 style="margin:0; font-size:22px; font-weight:700;">
                Batik Bulau Sayang
            </h1>
            <p style="margin:6px 0 0; font-size:14px; opacity:0.8;">
                Informasi Acara
            </p>
        </td>
    </tr>

    {{-- BODY --}}
    <tr>
        <td style="padding:32px;">
            <h2 style="margin-top:0; font-size:20px;">
                Pemberitahuan Pembatalan Acara
            </h2>

            <p style="font-size:15px; line-height:1.7;">
                Dengan berat hati kami informasikan bahwa acara berikut:
            </p>

            <div style="background:#FFF1F3; border-left:4px solid #5F1D2A; padding:16px; border-radius:8px; margin:18px 0;">
                <p style="margin:0; font-size:16px; font-weight:600;">
                    {{ $event->title }}
                </p>
            </div>

            <p style="font-size:15px; line-height:1.7; margin-bottom:18px;">
                telah <strong>dibatalkan atau dihapus</strong> oleh penyelenggara.
                Kami mohon maaf atas ketidaknyamanan yang mungkin terjadi.
            </p>

            <p style="font-size:15px;">
                Terima kasih atas perhatian dan partisipasi Anda.
            </p>

            <p style="font-size:15px; margin-top:24px;">
                Salam hangat,<br>
                <strong>Tim Batik Bulau Sayang</strong>
            </p>
        </td>
    </tr>

    {{-- FOOTER --}}
    <tr>
        <td style="background:#F8D9DF; padding:16px; text-align:center; font-size:12px; opacity:0.7;">
            © {{ date('Y') }} Batik Bulau Sayang
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
