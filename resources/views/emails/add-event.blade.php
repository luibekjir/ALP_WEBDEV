<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add to Calendar</title>
</head>
<body style="
    margin:0;
    padding:0;
    background:#ffffff;
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    color:#111827;
">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr>
        <td align="center">

            <!-- CARD -->
            <table width="420" cellpadding="0" cellspacing="0"
                   style="
                        background:#FFD9DC;
                        border-radius:12px;
                        padding:28px;
                        box-shadow:0 8px 30px rgba(16,24,40,0.08);
                   ">

                <!-- TITLE -->
                <tr>
                    <td style="font-size:22px; font-weight:600; padding-bottom:12px;">
                        📅 Tambahkan ke Kalender
                    </td>
                </tr>

                <!-- TEXT -->
                <tr>
                    <td style="font-size:14px; line-height:1.6; padding-bottom:16px;">
                        Kami telah menyiapkan jadwal berikut untuk Anda.
                        Silakan tambahkan ke kalender Anda agar tidak terlewat.
                    </td>
                </tr>

                <!-- EVENT DETAIL BOX -->
                <tr>
                    <td style="
                        background:#ffffff;
                        border-radius:8px;
                        padding:16px;
                        font-size:14px;
                        line-height:1.6;
                    ">
                        <strong>Judul:</strong> {{ $event->name }}<br>

                        @if(!empty($event->description))
                            <strong>Deskripsi:</strong> {{ $event->description }}<br>
                        @endif

                        @if(!empty($event->due_date))
                            <strong>Waktu:</strong> {{ $event->due_date }}
                        @endif
                    </td>
                </tr>

                <!-- BUTTON -->
                @if(!empty($calendarLink))
                <tr>
                    <td align="center" style="padding:24px 0 8px;">
                        <a href="{{ $calendarLink }}"
                           target="_blank"
                           style="
                                display:inline-block;
                                background:#111827;
                                color:#ffffff;
                                text-decoration:none;
                                padding:12px 26px;
                                border-radius:8px;
                                font-size:14px;
                                font-weight:600;
                           ">
                            ➕ Tambahkan ke Google Calendar
                        </a>
                    </td>
                </tr>
                @endif

                <!-- FOOTER -->
                <tr>
                    <td style="
                        font-size:12px;
                        color:#374151;
                        text-align:center;
                        padding-top:16px;
                    ">
                        Email ini dikirim otomatis oleh<br>
                        <strong>Bulau Sayang</strong>
                    </td>
                </tr>

            </table>
            <!-- END CARD -->

        </td>
    </tr>
</table>

</body>
</html>
