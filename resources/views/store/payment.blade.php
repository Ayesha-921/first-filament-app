@extends('store.layout')
@section('title', 'Payment')

@section('head')
<style>
    .payment-page { background: #EAEDED; min-height: 80vh; padding: 20px 0 60px; }
    .payment-container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
    .payment-header { font-size: 28px; font-weight: 700; margin-bottom: 24px; color: #0F1111; text-align: center; }
    
    .payment-form { background: #fff; border-radius: 8px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .payment-form h3 { font-size: 18px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #e3e6e6; }
    
    .card-element { padding: 12px; border: 1px solid #d5d9d9; border-radius: 6px; background: #fff; margin-bottom: 12px; }
    .card-element.StripeElement--focus { border-color: #FF9900; box-shadow: 0 0 0 3px rgba(255,153,0,.15); }
    .card-element.StripeElement--invalid { border-color: #CC0C39; }
    .card-row { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 12px; }
    
    .payment-total { text-align: center; padding: 20px; background: #fff8ee; border-radius: 8px; margin-bottom: 20px; }
    .payment-total-label { font-size: 14px; color: #555; margin-bottom: 8px; }
    .payment-total-amount { font-size: 32px; font-weight: 700; color: #B12704; }
    
    .pay-btn { display: block; width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 16px; font-size: 16px; font-weight: 700; color: #131921; text-align: center; cursor: pointer; }
    .pay-btn:hover:not(:disabled) { background: #F7CA00; }
    .pay-btn:disabled { opacity: 0.6; cursor: not-allowed; }
    
    .error-message { color: #CC0C39; font-size: 14px; margin-top: 12px; padding: 12px; background: #fff0f0; border-radius: 6px; display: none; }
    .error-message.show { display: block; }
    
    .secure-note { text-align: center; font-size: 12px; color: #555; margin-top: 16px; }
    .secure-note svg { vertical-align: middle; margin-right: 4px; }

    .order-info { background: #f7f8f8; border-radius: 6px; padding: 16px; margin-bottom: 20px; font-size: 13px; }
    .order-info-row { display: flex; justify-content: space-between; padding: 4px 0; }

    .dev-notice { background: #fff8ee; border: 1px solid #FF9900; border-radius: 6px; padding: 12px; margin-bottom: 16px; font-size: 12px; color: #555; }
    .dev-notice strong { color: #131921; }

    .test-cards { background: #f0f7ff; border-radius: 6px; padding: 12px; margin-bottom: 16px; font-size: 12px; }
    .test-cards strong { color: #007185; }
    .test-card-number { font-family: monospace; background: #fff; padding: 2px 6px; border-radius: 3px; }
</style>
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<div class="payment-page">
    <div class="payment-container">
        <h1 class="payment-header">Complete Your Payment</h1>
        
        <div class="payment-form">
            <div class="payment-total">
                <div class="payment-total-label">Total Amount</div>
                <div class="payment-total-amount">${{ number_format($total, 2) }}</div>
            </div>

            <div class="order-info">
                <div class="order-info-row">
                    <span>Shipping to:</span>
                    <span>{{ $checkoutData['first_name'] }} {{ $checkoutData['last_name'] }}</span>
                </div>
                <div class="order-info-row">
                    <span>Email:</span>
                    <span>{{ $checkoutData['email'] }}</span>
                </div>
                <div class="order-info-row">
                    <span>Items:</span>
                    <span>{{ count($cart) }} items</span>
                </div>
            </div>
            
            <form id="payment-form" action="{{ route('payment.stripe') }}" method="POST">
                @csrf
                <h3>Card Information</h3>

                <label style="font-size:12px;color:#555;margin-bottom:6px;display:block;">Card Number</label>
                <div id="card-number" class="card-element"></div>

                <div class="card-row">
                    <div>
                        <label style="font-size:12px;color:#555;margin-bottom:6px;display:block;">Expiry Date</label>
                        <div id="card-expiry" class="card-element"></div>
                    </div>
                    <div>
                        <label style="font-size:12px;color:#555;margin-bottom:6px;display:block;">CVC</label>
                        <div id="card-cvc" class="card-element"></div>
                    </div>
                </div>

                <div id="card-errors" class="error-message" role="alert"></div>

                <button type="submit" id="submit-button" class="pay-btn">
                    Pay ${{ number_format($total, 2) }}
                </button>
            </form>
            
            <div class="secure-note">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Your payment is secured by Stripe. We never store your card details.
            </div>
        </div>
    </div>
</div>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY', 'pk_test_YourStripePublishableKey') }}');
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#0F1111',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': { color: '#888' }
        },
        invalid: { color: '#CC0C39', iconColor: '#CC0C39' }
    };

    // Create separate card elements
    var cardNumber = elements.create('cardNumber', { style: style, placeholder: '0000 0000 0000 0000' });
    var cardExpiry = elements.create('cardExpiry', { style: style });
    var cardCvc = elements.create('cardCvc', { style: style });

    cardNumber.mount('#card-number');
    cardExpiry.mount('#card-expiry');
    cardCvc.mount('#card-cvc');

    // Handle errors
    function handleChange(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.classList.add('show');
        } else {
            displayError.textContent = '';
            displayError.classList.remove('show');
        }
    }

    cardNumber.addEventListener('change', handleChange);
    cardExpiry.addEventListener('change', handleChange);
    cardCvc.addEventListener('change', handleChange);

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';

        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                errorElement.classList.add('show');
                submitButton.disabled = false;
                submitButton.textContent = 'Pay ${{ number_format($total, 2) }}';
            } else {
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    });
</script>
@endsection
