@extends("frontend.layouts.layout")
@section("title","Login")
@section("content")
<style>
    .error {
        color: #f33737;
        background-color: #ccc;
    }
</style>
@if(session()->has('message'))
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">{{ session()->get('message') }}</p>
                    <div class="text-center mb-4">
                        <a href="{{ route('login') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid login-bg">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="login login-padd">
                    <h4 class="mt-3 mb-4 text-white">LOG IN TO YOUR ACCOUNT</h4>
                    @if($errors->has('email'))
                    <h4 class="error">{{ $errors->first('email') }}</h4>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-mail"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control survey-placeholder" name="email" :value="old('email')" required autofocus placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" />

                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="icon-lock"></i></span>
                            </div>
                            <input type="password" id="password" type="password" name="password" required autocomplete="current-password" class="form-control survey-placeholder" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" />
                            <div class="input-group-prepend">
                                <span class="input-group-text eye-pass" id="basic-addon1" onclick="showPassword()"><img style="height: 20px; width: 20px;" src="{{ asset('/public/assets/images/eye.png') }}" /></span>
                            </div>
                            @if($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="d-flex REMEMBER-me">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="container-check login-chk text-white" style="float: left;">Remember Me
                                        <input type="checkbox" />
                                        <span class="checkmark login-checkmark"></span>
                                    </label>
                                </div>

                                <div class="">
                                    @if (Route::has('password.request'))
                                    <a class="float-right text-black forget  text-white" href="{{ route('password.request') }}">
                                        {{ __('Forget password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="btn w-100 bg-black mb-1 m-auto text-center py-2 mt-1">
                            <button type="submit" class="btn btn-primary p-0" style="font-size: 12px; background:black; border:10px; width:100%;">
                                {{ __('CONTINUE') }}
                            </button>
                        </div>
                        <a href="{{ route('register') }}" class="create-acc-btn btn mb-2 m-auto text-center py-2 mt-3 schedule-div">
                            <span class="">CREATE ACCOUNT</span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

<script type="text/javascript">
    function showPassword() {
        var pass = document.getElementById("password");
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }
</script>