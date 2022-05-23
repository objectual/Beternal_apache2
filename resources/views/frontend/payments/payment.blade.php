<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","Payment")
@section("content")
<div class="container-fluid bg-dash payment-back-mob">
    <div class="scroll-div">
        <div class="row pb-5">
            <div class="col-lg-6 m-auto mt-3">
                <div class="row">

                    <div class="col-lg-12">
                        <h3 class="payment-title text-white mt-3 mb-3 text-center">You are securing your legacy for $2.99 a month</h3>
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
                    <div class="col-lg-7 col-12">
                        <p class="card-label"> CREDIT CARD NUMBER</p>
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
                        <p class="card-label">EXPIRATION DATE</p>
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
                <!-- <div class="col-lg-12">
                    <p class="card-label">Billing Address</p>
                    <p> <span class="wpcf7-form-control-wrap your-message"><textarea minlength="20" required name="tmsg" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea message-area" aria-invalid="false"></textarea></span>
                    </p>
                </div> -->

                <div class="col-md-12 payment-phone phone-area">
                    <p class="card-label">Phone Number</p>
                    <div class="input-group col-md-4 mb-3">
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                    </div>
                    @if($errors->has('phone'))
                    <div class="error text-white">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
                <p class="card-label">Billing Address</p>
                <div class="col-md-12">
                    <p class="card-label">Address 1</p>
                    <div class="input-group col-md-4 mb-3">
                        <input type="text" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">Address 2</p>
                    <div class="input-group col-md-4 mb-3">
                        <input type="text" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">Country</p>
                    <div class="input-group col-md-4 mb-3">
                        <select id="country_id" name="country_id" class="form-control py-2 input-radius" aria-describedby="basic-addon1" onChange="selectCountry()" required />
                        <option value="">Select Country</option>
                        @if(isset($countries))
                        @foreach($countries as $key => $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">State / Province</p>
                    <div class="input-group col-md-4 mb-3">
                        <select id="state_province_id" name="state_province_id" class="form-control py-2 input-radius" aria-describedby="basic-addon1" onChange="selectProvince()" required />
                        <option value="">Select State / Province</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">City</p>
                    <div class="input-group col-md-4 mb-3">
                        <select id="city_id" name="city_id" class="form-control py-2 input-radius" aria-describedby="basic-addon1" required />
                        <option value="">Select City</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="card-label">Zip / Postal Code</p>
                    <div class="input-group col-md-4 mb-3">
                        <input type="text" class="form-control py-2 input-radius" aria-describedby="basic-addon1" />
                    </div>
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

<script src="{!! asset('/public/build/js/intlTelInput.js') !!}"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        utilsScript: "{!! asset('/public/build/js/utils.js') !!}",
    });
</script>
@endsection

<script type="text/javascript">
    function selectCountry() {
        var select = document.getElementById('country_id');
        var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'provinces/' + id,
            type: 'get',
            // dataType: 'json',
            success: function(response) {
                var len = 0;
                $('#state_province_id').empty();
                $('#city_id').empty();
                if (response != null) {
                    len = response.length;
                }
                if (len > 0) {
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
                    for (var i = 0; i < len; i++) {
                        var id = response[i].id;
                        var name = response[i].name;
                        var o = new Option(name, id);
                        $("#state_province_id").append(o);
                    }
                } else {
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
                }
            }
        });
    }

    function selectProvince() {
        var select = document.getElementById('state_province_id');
        var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'cities/' + id,
            type: 'get',
            // dataType: 'json',
            success: function(response) {
                var len = 0;
                $('#city_id').empty();
                if (response != null) {
                    len = response.length;
                }
                if (len > 0) {
                    var o = new Option("Select City", "");
                    $("#city_id").append(o);
                    for (var i = 0; i < len; i++) {
                        var id = response[i].id;
                        var city_name = response[i].city_name;
                        var o = new Option(city_name, id);
                        $("#city_id").append(o);
                    }
                }
            }
        });
    }
</script>