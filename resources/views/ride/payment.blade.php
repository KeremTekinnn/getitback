@extends('layouts.app')

@section('content')
    <x-progress-bar :step="$step"></x-progress-bar>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <div class="card card0 rounded-0">
                    <div class="row">
                        <div class="col-md-5 d-md-block d-none p-0 box">
                            <div class="card rounded-0 border-0 card1" id="bill">
                                <h3 id="heading1">Payment Summary</h3>
                                <div class="row">
                                    <div class="col-lg-7 col-8 mt-4 pl-4">
                                        <h2 class="bill-head">Pickup</h2>
                                        <small class="bill-date">{{ request()->get('pickup') }}</small>
                                    </div>
                                    <div class="col-lg-7 col-8 mt-4 pl-4">
                                        <h2 class="bill-head">Dropoff</h2>
                                        <small class="bill-date">{{ request()->get('dropoff') }}</small>
                                    </div>
                                    <div class="col-lg-7 col-8 mt-4 pl-4">
                                        <h2 class="bill-head">Distance</h2>
                                        <small class="bill-date">{{ request()->get('distance') }} km</small>
                                    </div>
                                    <div class="col-lg-7 col-8 mt-4 pl-4">
                                        <h2 class="bill-head">Cost</h2>
                                        <small class="bill-date">${{ request()->get('cost') }}</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 red-bg">
                                        <p class="bill-date" id="total-label">Total Price</p>
                                        <h2 class="bill-head" id="total">${{ $cost }}</h2>
                                        <small class="bill-date" id="total-label">Price includes all taxes</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 col-sm-12 p-0 box">
                            <div class="card rounded-0 border-0 card2" id="paypage">
                                <div class="form-card">
                                    <h2 id="heading2" class="text-danger">Payment Method</h2>
                                    <form action="{{ route('ride.store') }}" method="POST" id="payment-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element">
                                                <!-- A Stripe Element will be inserted here. -->
                                            </div>
                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <button type="submit">Submit Payment</button>
                                    </form>
                                    <script src="https://js.stripe.com/v3/"></script>

                                    <script>
                                        var stripe = Stripe('{{ env("STRIPE_KEY") }}');
                                        var elements = stripe.elements();
                                        var cardElement = elements.create('card');
                                        cardElement.mount('#card-element');

                                        var form = document.getElementById('payment-form');

                                        form.addEventListener('submit', function(event) {
                                            event.preventDefault();

                                            stripe.createPaymentMethod({
                                                type: 'card',
                                                card: cardElement,
                                            }).then(function(result) {
                                                if (result.error) {
                                                    var errorElement = document.getElementById('card-errors');
                                                    errorElement.textContent = result.error.message;
                                                } else {
                                                    // Insert the payment ID into the form so it gets submitted to the server
                                                    var paymentIdField = document.createElement('input');
                                                    paymentIdField.setAttribute('type', 'hidden');
                                                    paymentIdField.setAttribute('name', 'payment_method');
                                                    paymentIdField.setAttribute('value', result.paymentMethod.id);
                                                    form.appendChild(paymentIdField);
                                                    // Submit the form
                                                    form.submit();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
