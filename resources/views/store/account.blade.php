@extends('store.layout')
@section('title', 'My Account')

@section('head')
<style>
    .account-page { background: #EAEDED; min-height: 80vh; padding: 20px 0 60px; }
    .account-container { max-width: 800px; margin: 0 auto; padding: 0 20px; }
    .account-header { font-size: 28px; font-weight: 700; margin-bottom: 24px; color: #0F1111; }

    .account-card { background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .account-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #e3e6e6; }

    .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f2f2; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-weight: 600; color: #555; }
    .info-value { color: #0F1111; }

    .api-key-box { background: #f7f8f8; border: 1px solid #d5d9d9; border-radius: 6px; padding: 12px; font-family: monospace; font-size: 13px; word-break: break-all; }
    .api-note { font-size: 12px; color: #555; margin-top: 8px; }
</style>
@endsection

@section('content')
<div class="account-page">
    <div class="account-container">
        <h1 class="account-header">My Account</h1>

        <div class="account-card">
            <h3>Profile Information</h3>
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ Auth::user()->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ Auth::user()->email }}</span>
            </div>
        </div>

        <div class="account-card">
            <h3>API Key</h3>
            <div class="api-key-box">{{ Auth::user()->api_key ?? 'Not generated' }}</div>
            <p class="api-note">Use this API key to access the API. Keep it secret!</p>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('orders.index') }}" style="display: inline-block; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 12px 24px; font-size: 14px; font-weight: 700; color: #131921; text-decoration: none;">View My Orders</a>
        </div>
    </div>
</div>
@endsection
