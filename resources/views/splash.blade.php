<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>MedisCare</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d9488">
    <style>
        body { margin:0; height:100vh; background:#0d9488; display:flex; align-items:center;
               justify-content:center; flex-direction:column; font-family: system-ui, sans-serif; }
        .logo { width:88px; height:88px; border-radius:24px; background:white; color:#0d9488;
                display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:800;
                margin-bottom:20px; animation: pulse 1.4s ease-in-out infinite; }
        h1 { color:white; font-size:22px; margin:0; }
        p { color:#d1fae5; font-size:13px; margin-top:6px; }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.06); } }
    </style>
</head>
<body>
    <div class="logo">M+</div>
    <h1>MedisCare</h1>
    <p>Sistem Informasi Manajemen Rumah Sakit</p>

    <script>
        // Splash tampil sebentar (Bagian 32), lalu meneruskan ke login/dashboard.
        setTimeout(() => {
            window.location.href = "{{ $next }}";
        }, 900);
    </script>
</body>
</html>
