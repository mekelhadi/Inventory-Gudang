<x-guest-layout>
    <canvas id="warehouse-bg"></canvas>

    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('assets/img/logo_sinarmax.jpg') }}" alt="Logo Sinarmax" class="login-logo">
            <h1>Lupa Password</h1>
            <p>Masukkan email untuk menerima link reset password</p>
        </div>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-5">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">KIRIM LINK RESET</button>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="forgot-link">Kembali ke Login</a>
            </div>
        </form>
    </div>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(180deg, #f9fafb 0%, #e5e7eb 100%);
            overflow: hidden;
            position: relative;
            color: #1e293b;
        }

        #warehouse-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 3rem 2.5rem;
            border-radius: 1.25rem;
            background: rgba(255,255,255,0.9);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08), inset 0 0 0 1px rgba(209,213,219,0.5);
            backdrop-filter: blur(12px);
            animation: slideFade 0.9s ease-out;
        }

        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-logo { width: 100px; height: 100px; object-fit: contain; border-radius: 16px; margin: 0 auto 12px; display: block; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .login-header h1 { font-size: 2rem; font-weight: 700; background: linear-gradient(90deg, #6366f1, #14b8a6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .login-header p { color: #64748b; font-size: 0.9rem; }

        label { font-size: 0.85rem; font-weight: 500; color: #475569; display: block; margin-bottom: 0.3rem; }

        input[type="email"] {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border-radius: 0.5rem;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }
        input[type="email"]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            margin-top: 1.2rem;
            border-radius: 0.6rem;
            border: none;
            background: linear-gradient(90deg, #6366f1, #0ea5e9);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 8px 20px rgba(99,102,241,0.25);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99,102,241,0.35);
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover { color: #4f46e5; text-decoration: underline; }

        .alert-success {
            background: #ecfdf5;
            color: #059669;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        @keyframes slideFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .login-container { padding: 2.5rem 1.5rem; }
            .login-header h1 { font-size: 1.75rem; }
        }
    </style>
</x-guest-layout>
