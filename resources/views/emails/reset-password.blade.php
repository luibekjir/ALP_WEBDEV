<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8f8f8; padding:30px;">

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">

                <table width="500" style="background:#ffffff; padding:30px; border-radius:8px;">
                    <tr>
                        <td align="center">
                            <h2 style="color:#5F1D2A;">Batik Bulau Sayang</h2>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,</p>

                            <p>
                                Kami menerima permintaan untuk mereset password akun Anda.
                                Silakan klik tombol di bawah ini untuk melanjutkan.
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ $url }}"
                                   style="background:#5F1D2A; color:#ffffff;
                                          padding:12px 24px;
                                          text-decoration:none;
                                          border-radius:6px;
                                          display:inline-block;">
                                    Reset Password
                                </a>
                            </p>

                            <p>
                                Link ini hanya berlaku selama <strong>60 menit</strong>.
                                Jika Anda tidak merasa melakukan permintaan ini,
                                silakan abaikan email ini.
                            </p>

                            <p>Salam hangat,<br>
                            <strong>Batik Bulau Sayang</strong></p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
