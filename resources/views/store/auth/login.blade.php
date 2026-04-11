@extends('store.layout')
@section('title', 'Sign In — MyShop')

@section('head')
<style>
    .auth-wrap { min-height: calc(100vh - 200px); display: flex; align-items: flex-start; justify-content: center; padding: 40px 16px; background: #fff; }
    .auth-box { width: 100%; max-width: 360px; }
    .auth-logo { font-size: 28px; font-weight: 900; color: #FF9900; text-align: center; margin-bottom: 20px; }
    .auth-card { border: 1px solid #ddd; border-radius: 8px; padding: 24px; background: #fff; }
    .auth-card h2 { font-size: 22px; font-weight: 400; margin: 0 0 16px; }
    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .form-group input { width: 100%; padding: 8px 10px; border: 1px solid #888; border-radius: 3px; font-size: 14px; outline: none; }
    .form-group input:focus { border-color: #e77600; box-shadow: 0 0 0 3px rgba(231,118,0,.25); }
    .form-error { color: #CC0C39; font-size: 12px; margin-top: 4px; }
    .btn-submit { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 4px; padding: 10px; font-size: 14px; font-weight: 500; cursor: pointer; margin-top: 4px; }
    .btn-submit:hover { background: #F7CA00; }
    .auth-divider { border: none; border-top: 1px solid #e7e7e7; margin: 20px 0; }
    .auth-link-row { text-align: center; font-size: 13px; color: #555; margin-top: 16px; }
    .auth-link-row a { color: #007185; }
    .auth-link-row a:hover { color: #C7511F; text-decoration: underline; }
    .auth-terms { font-size: 11px; color: #555; margin-top: 14px; line-height: 1.5; }
    .auth-terms a { color: #007185; }
    .alert-error { background: #fff3f3; border: 1px solid #ffc0c0; border-radius: 4px; padding: 10px 14px; margin-bottom: 14px; font-size: 13px; color: #CC0C39; }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-box">
        <a href="{{ route('home') }}" class="auth-logo" style="display:block;text-decoration:none;">MyShop</a>
        <div class="auth-card">
            <h2>Sign in</h2>

            @if($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('store.login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;font-size:13px;">
                    <input type="checkbox" id="remember" name="remember" style="accent-color:#FF9900;" />
                    <label for="remember">Keep me signed in</label>
                </div>
                <button type="submit" class="btn-submit">Continue</button>
                <div class="auth-terms">
                    By continuing, you agree to MyShop's <a href="#">Conditions of Use</a> and <a href="#">Privacy Notice</a>.
                </div>
            </form>

            <hr class="auth-divider">

            <div style="font-size:13px;font-weight:700;color:#555;margin-bottom:10px;">New to MyShop?</div>
            <a href="{{ route('store.register') }}" style="display:block;width:100%;text-align:center;padding:9px;border:1px solid #ccc;border-radius:4px;font-size:13px;color:#0F1111;background:#f7f8f8;text-decoration:none;">
                Create your MyShop account
            </a>
        </div>
    </div>
</div>
@endsection
