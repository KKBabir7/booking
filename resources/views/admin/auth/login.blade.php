<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — NGH Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; }
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .login-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 3rem;
            width: 100%; max-width: 440px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .brand-logo {
            width: 52px; height: 52px;
            background: var(--primary);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white;
            box-shadow: 0 8px 20px rgba(79,70,229,0.4);
        }
        .form-label { color: #94a3b8; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }
        .form-control {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; color: white;
            padding: 0.85rem 1.1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
        }
        .form-control::placeholder { color: #475569; }
        .btn-login {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none; border-radius: 12px;
            color: white; font-weight: 700;
            padding: 0.9rem;
            letter-spacing: 0.02em;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(79,70,229,0.5);
            color: white;
        }
        .alert-danger { background: rgba(244,63,94,0.1); border: 1px solid rgba(244,63,94,0.3); color: #f43f5e; border-radius: 12px; font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="brand-logo"><i class="bi bi-shield-lock-fill"></i></div>
        <div>
            <h1 class="mb-0 text-white" style="font-size:1.4rem; font-weight:800;">NGH Admin</h1>
            <p class="mb-0" style="color:#64748b; font-size:0.8rem;">Secure Administrator Access</p>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="admin@example.com" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Admin Panel
        </button>
    </form>

    <div class="text-center mt-4 border-top border-secondary pt-3">
        <a href="{{ url('/') }}" class="text-decoration-none" style="color:#6366f1; font-size:0.85rem;">
            <i class="bi bi-arrow-left me-1"></i> Back to Website
        </a>
    </div>
</div>
</body>
</html>
