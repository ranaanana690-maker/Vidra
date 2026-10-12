<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'نظام إدارة مركز الدعم') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Cairo', ui-sans-serif, system-ui, sans-serif; background: #0a0a14; color: #e2e8f0; }
        .grad-text {
            background: linear-gradient(135deg, #818cf8, #c084fc, #e879f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); backdrop-filter:blur(12px); }
        .module-card { border-radius:1rem; padding:1.5rem; transition: transform .25s; }
        .module-card:hover { transform:translateY(-6px); }
    </style>
</head>
<body>

<nav style="position:fixed;top:0;right:0;left:0;z-index:100;background:rgba(10,10,20,.85);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.07);">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:4rem;">
        <span style="font-weight:800;font-size:1rem;color:#f1f5f9;">{{ config('app.name', 'نظام إدارة مركز الدعم') }}</span>
        <a href="{{ route('login') }}" style="padding:.5rem 1.5rem;font-size:.875rem;font-weight:700;color:#fff;text-decoration:none;border-radius:.5rem;background:linear-gradient(135deg,#4f46e5,#7c3aed);">
            تسجيل الدخول
        </a>
    </div>
</nav>

<section style="min-height:100vh;display:flex;align-items:center;padding:7rem 1.5rem 4rem;">
    <div style="max-width:900px;margin:0 auto;text-align:center;">
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;line-height:1.4;color:#f8fafc;">
            كل ما يحتاجه مركز دروس الدعم<br>
            <span class="grad-text">في منصة واحدة</span>
        </h1>
        <p style="margin-top:1.5rem;font-size:1.0625rem;color:#94a3b8;line-height:2;">
            تسيير التلاميذ بجميع الأطوار، الدورات (القرآن الكريم، اللغات، السوروبان)،
            الحضور، الاشتراكات الشهرية، والمدفوعات — باللغة العربية.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;margin-top:2.5rem;flex-wrap:wrap;">
            <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.875rem 2.5rem;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:.75rem;font-weight:700;font-size:1rem;color:#fff;text-decoration:none;">
                دخول المنصة
            </a>
            <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;padding:.875rem 2.5rem;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:.75rem;font-weight:600;font-size:1rem;color:#e2e8f0;text-decoration:none;">
                لوحة التحكم
            </a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;margin-top:4rem;">
            @foreach([
                ['التلاميذ', '👨‍🎓'],
                ['الأقسام والأفواج', '🏫'],
                ['الدورات', '📚'],
                ['الحضور', '✅'],
                ['الاشتراكات', '💰'],
                ['القرآن الكريم', '🕌'],
            ] as [$label, $icon])
            <div class="glass" style="padding:1.25rem 1rem;border-radius:.875rem;text-align:center;">
                <div style="font-size:1.5rem;">{{ $icon }}</div>
                <div style="font-size:.8125rem;color:#cbd5e1;margin-top:.5rem;font-weight:600;">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<footer style="border-top:1px solid rgba(255,255,255,.06);padding:1.5rem;text-align:center;">
    <p style="font-size:.75rem;color:#475569;">&copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
</footer>

</body>
</html>
