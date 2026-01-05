<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Baru - Batik Bulau Sayang</title>
</head>
<body style="margin:0; padding:0; background-color:#FFF8F6; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF8F6; padding:32px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                style="background:#ffffff; border-radius:16px; overflow:hidden;
                box-shadow:0 8px 24px rgba(0,0,0,0.08);">

                {{-- HEADER --}}
                <tr>
                    <td style="background:#F8D9DF; padding:28px; text-align:center;">
                        <h1 style="margin:0; color:#5F1D2A; font-size:24px;">
                            Pesanan Baru Masuk 🎉
                        </h1>
                        <p style="margin:8px 0 0; color:#5F1D2A; font-size:14px;">
                            Batik Bulau Sayang
                        </p>
                    </td>
                </tr>

                {{-- BODY --}}
                <tr>
                    <td style="padding:30px; color:#374151; font-size:15px; line-height:1.6;">
                        <p style="margin:0 0 16px;">
                            Halo <strong>Admin</strong>,
                        </p>

                        <p style="margin:0 0 16px;">
                            Sistem <strong>Batik Bulau Sayang</strong> mendeteksi adanya
                            <strong>pesanan baru</strong> yang masuk.
                        </p>

                        <p style="margin:0 0 24px;">
                            Silakan masuk ke halaman admin untuk melihat detail pesanan dan
                            segera menindaklanjuti pesanan tersebut.
                        </p>

                        {{-- <div style="text-align:center;">
                            <a href="{{ url('/admin/orders') }}"
                               style="display:inline-block; background:#5F1D2A; color:#ffffff;
                               padding:12px 28px; border-radius:999px;
                               text-decoration:none; font-weight:bold;">
                                Buka Dashboard Admin
                            </a>
                        </div> --}}

                        <p style="margin-top:30px; font-size:13px; color:#6B7280;">
                            Email ini dikirim otomatis oleh sistem.<br>
                            Mohon tidak membalas email ini.
                        </p>
                    </td>
                </tr>

                {{-- FOOTER --}}
                <tr>
                    <td style="background:#F8D9DF; padding:16px; text-align:center;
                        font-size:12px; color:#5F1D2A;">
                        © {{ date('Y') }} Batik Bulau Sayang · Handmade with Love
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
