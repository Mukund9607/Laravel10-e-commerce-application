@extends('layout.main_layout')
@section('main-section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop_page') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form id="orderForm" name="orderForm" action="{{ route('store_checkout_data') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                placeholder="First Name" value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->first_name: ''}}">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                placeholder="Last Name" value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->last_name: ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email" value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->email: ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select Country</option>
                                                @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                <option {{ (!empty( $CustomersAddresses)&& $CustomersAddresses->country_id == $country->id)? 'selected' : ''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3"
                                                placeholder="Address" class="form-control">{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->address: ''}}</textarea>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="apartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)"  value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->apartment: ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="City" value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->city: ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control"
                                                placeholder="State" value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->state: ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control"
                                                placeholder="Zip"  value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->zip: ''}}">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                placeholder="Mobile No." value="{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->mobile: ''}}">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2"
                                                placeholder="Order Notes (optional)" class="form-control">{{ (!empty( $CustomersAddresses ))? $CustomersAddresses->order_notes: ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @foreach (Cart::content() as $item )
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{ $item->name }} - {{ $item->qty }}</div>
                                    <div class="h6">${{ $item->price }}</div>
                                </div>
                                @endforeach
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>$0</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong>${{ Cart::subtotal() }}</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card payment-form ">
                            <h3 class="card-title h5 mb-3">Payment Method</h3>
                            <div>
                                <div>
                                    <input checked type="radio" name="payment_method" value="cod"
                                        id="payment_method_one">
                                    <label for="payment_method_one " class="form-check-label">Cod</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input checked type="radio" name="payment_method" value="card_payment"
                                        id="payment_method_two">
                                    <label for="payment_method_two" class="form-check-label">stripe</label>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Place Order</button>
                            </div>
                        </div>
                        <!-- CREDIT CARD FORM ENDS HERE -->
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
@section('frontjs')

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
$('#orderForm').submit(function (e) { 
        e.preventDefault();
  
        $.ajax({
        type: "POST",
        url: "{{ route('store_checkout_data') }}",
        data: $(this).serializeArray(),
        dataType: "json",
        success: function (response) {
            console.log("Success:", response);
            var errors = response.errors;
            if (response.status == true) {
                // Check if the response contains a payment_url
                if (response.payment_url) {
                    // Redirect to the Stripe payment page
                    window.location.href = response.payment_url;
                } else {
                    // Assuming 'response.success' indicates a successful submission
                    alert('Your order placed successfully!');
                    window.location.href = "{{ route('thankyou') }}"; // Consider redirecting to a success page instead of reloading
                }
            } else if (response.errors) {
                // Handle validation errors
                $.each(response.errors, function(key, value) {
                    $('#' + key).siblings("p").addClass('invalid-feedback').html(value);
                    $('#' + key).addClass('is-invalid');
                });
            } else {
                // Handle other errors
                alert('An error occurred while processing your order.');
            }
        },
        error: function(jQXHR, textStatus) {
            // Handle errors
            // console.error(jQXHR, textStatus);
           
            alert('An error occurred while registering the user.');
        }
    });
   
});

</script>

@endsection
