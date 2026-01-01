<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Student Portal') }} - Auth</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root { --primary: #0d6efd; }
        body { background: #f5f7fb; }
        .auth-card { max-width: 520px; margin: 7vh auto; }
        .brand-logo { width:48px; height:48px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; background:var(--primary); color:#fff; font-weight:700; }
        .pw-toggle-btn { cursor:pointer; }
        .pw-strength { height:8px; border-radius:4px; overflow:hidden; }
    </style>
</head>
<body>
<nav class="navbar navbar-light" style="background:#fff; border-bottom:1px solid #e9ecef;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <span class="brand-logo me-2">{{ strtoupper(substr(config('app.name', 'S'),0,1)) }}</span>
            <span class="fw-bold text-dark">{{ config('app.name', 'Student Portal') }}</span>
        </a>
    </div>
</nav>

<div class="container">
    <div class="auth-card">
        <div class="card shadow-sm">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
        <p class="text-center text-muted mt-3 small">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</div>

<script>
    function togglePassword(btnSelector, inputSelector) {
        const btn = document.querySelector(btnSelector);
        const input = document.querySelector(inputSelector);
        if (!btn || !input) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = 'Hide';
            } else {
                input.type = 'password';
                btn.innerHTML = 'Show';
            }
        });
    }

    function passwordStrength(inputSelector, barSelector, textSelector) {
        const input = document.querySelector(inputSelector);
        const bar = document.querySelector(barSelector);
        const text = document.querySelector(textSelector);
        if (!input || !bar || !text) return;
        input.addEventListener('input', function () {
            const val = input.value;
            let score = 0;
            if (val.length >= 8) score += 1;
            if (/[A-Z]/.test(val)) score += 1;
            if (/[0-9]/.test(val)) score += 1;
            if (/[^A-Za-z0-9]/.test(val)) score += 1;
            const percent = (score / 4) * 100;
            bar.style.width = percent + '%';
            if (score <= 1) { bar.style.background = '#dc3545'; text.textContent = 'Weak'; }
            else if (score === 2) { bar.style.background = '#fd7e14'; text.textContent = 'Medium'; }
            else if (score === 3) { bar.style.background = '#0d6efd'; text.textContent = 'Strong'; }
            else { bar.style.background = '#198754'; text.textContent = 'Very strong'; }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        togglePassword('#toggleLoginPw', '#loginPassword');
        togglePassword('#toggleRegisterPw', '#registerPassword');
        passwordStrength('#registerPassword', '#pw-strength-bar', '#pw-strength-text');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>