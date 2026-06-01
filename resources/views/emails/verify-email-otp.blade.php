<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>

<body style="font-family: Arial, sans-serif; padding:20px;">

    <h2>Verifikasi Email Zorie</h2>

    <p>Halo,</p>

    <p>Gunakan kode OTP berikut untuk memverifikasi email akun Zorie Anda:</p>

    <div
        style="
        font-size:32px;
        font-weight:bold;
        letter-spacing:5px;
        padding:15px;
        background:#f5f5f5;
        display:inline-block;
        border-radius:10px;
    ">
        {{ $otp }}
    </div>

    <p style="margin-top:20px;">
        OTP berlaku selama 10 menit.
    </p>

    <p>
        Jika Anda tidak meminta verifikasi email ini,
        abaikan email ini.
    </p>

</body>

</html>
