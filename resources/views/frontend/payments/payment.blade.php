@extends("frontend.layouts.layout")
@section("title","Capture Video")
@section("content")
<div class="container-fluid bg-dash payment-back-mob">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-4 m-auto mt-3">
                <div class="row">

                    <div class="col-lg-12">
                        <h3 class="payment-title text-white mt-3 mb-3">You are securing your legacy for $2.99 a month</h3>
                        <!-- <h3 class="payment-price">$2.99/mo</h3> -->
                        <p class="card-label">Payment Method</p>
                        <select class="form-select mb-3 payment-method" aria-label="Default select example">
                            <option selected> </option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <!-- payment method -->
                    <div class="col-lg-7 col-8">
                        <p class="card-label">CARD NAME</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                        </div>
                    </div>

                    <div class="col-lg-5 col-4 visa-picture">
                        <img class="visa-img w-100" src="{{ asset('/public/assets/images/visa.png') }}" />
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">CARDHOLDER NAME</p>
                    <div class="input-group col-md-4 mb-3">
                        <input type="email" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-8">
                        <p class="card-label">EXPIRE DATE</p>
                        <div class="input-group mb-3">
                            <input type="email input-radius" class="form-control py-2" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-4">
                        <p class="card-label">CVV</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="col-lg-12">
                    <p class="card-label">Billing Address</p>
                    <p> <span class="wpcf7-form-control-wrap your-message"><textarea minlength="20" required name="tmsg" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea message-area" aria-invalid="false"></textarea></span>
                    </p>
                </div>

                <div class="col-md-12 m-auto pt-3 pb-3">
                    <label class="container-check check-color">KEEP MY PAYMENT METHOD ON FILE
                        <input type="checkbox" />
                        <span class="checkmark check-radius"></span>
                    </label>
                </div>


                <div class="col-lg-12 pb-4 margin-message">
                    <button data-bs-toggle="modal" data-bs-target="#confirmPaymentModal" class="btn-pay w-100 m-auto text-center py-2">
                        <span class="schedule">SUBMIT PAYMENT</span>
                    </button>

                </div>
            </div>
        </div>

    </div>

</div>




<!-- Modal -->
<div class="modal fade" id="confirmPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 text-center offset-lg-2">
                        <h3 class="mt-5 payment-h3">Payment Successful</h3>
                        <p>You have successfully done the payment</p>
                        <img src="./images/payment.svg" />
                        <div class="text-center mb-4">
                            <a href="#" class="mx-1"><img src="./images/yes.png" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection