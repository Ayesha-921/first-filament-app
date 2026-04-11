@extends('store.layout')
@section('title', 'Create Account — MyShop')

@section('head')
<style>
    .auth-wrap { min-height: calc(100vh - 200px); display: flex; align-items: flex-start; justify-content: center; padding: 40px 16px; background: #fff; }
    .auth-box { width: 100%; max-width: 380px; }
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
    .auth-terms { font-size: 11px; color: #555; margin-top: 14px; line-height: 1.5; }
    .auth-terms a { color: #007185; }
    .auth-divider { border: none; border-top: 1px solid #e7e7e7; margin: 20px 0; }
    .alert-error { background: #fff3f3; border: 1px solid #ffc0c0; border-radius: 4px; padding: 10px 14px; margin-bottom: 14px; font-size: 13px; color: #CC0C39; }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-box">
        <a href="{{ route('home') }}" class="auth-logo" style="display:block;text-decoration:none;">MyShop</a>
        <div class="auth-card">
            <h2>Create account</h2>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('store.register.post') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Your name</label>
                    <input type="text" id="name" name="name" placeholder="First and last name" value="{{ old('name') }}" required autofocus />
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="At least 8 characters" required />
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Re-enter password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required />
                </div>
                <button type="submit" class="btn-submit">Continue</button>
                <div class="auth-terms">
                    By creating an account, you agree to MyShop's <a href="#">Conditions of Use</a> and <a href="#">Privacy Notice</a>.
                </div>
            </form>

            <hr class="auth-divider">

            <div style="font-size:13px;color:#555;text-align:center;">
                Already have an account?
                <a href="{{ route('store.login') }}" style="color:#007185;">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection
