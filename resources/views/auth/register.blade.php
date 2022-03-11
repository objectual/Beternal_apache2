@extends("frontend.layouts.layout")
@section("title","Register")
@section("content")
<div class="container-fluid payment-back-mob accont-padding-top">
    <div class="scroll-div">
       <div class="row">        
            <div class="col-lg-3"></div>       
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('register') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="mt-4 account-head text-center text-white">CREATE AN ACCOUNT</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <img src="{{ asset('/public/media/image/default.png') }}" id="output" class="image-upload mb-2" style="border-radius: 100%" />
                                    @if($errors->has('image'))
                                        <div class="error">{{ $errors->first('image') }}</div>
                                    @endif
                                <a class="mt-5 cl-white upload upload-web px-3">
                                    <label class="icon-upload" for="file">&nbsp;&nbsp;Upload Image</label>
                                    <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;">
                                </a> 
                                    
                                  
                                <script>
                                    var loadFile = function(event) {
                                      var image = document.getElementById('output');
                                      image.src = URL.createObjectURL(event.target.files[0]);
                                    };
                                </script>
             
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row mt-2 row-height">
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Full Name</span>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control text-end" aria-describedby="basic-addon1" required/>  
                                @if($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Last Name</span>
                                </div>
                                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" class="form-control text-end" aria-describedby="basic-addon1" required/>
                                @if($errors->has('last_name'))
                                    <div class="error">{{ $errors->first('last_name') }}</div>
                                @endif   
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Email</span>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2" >Phone Number</span>
                                </div>
                                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="form-control text-end" aria-describedby="basic-addon1" required/>
                                @if($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-lg-3"></div> -->
                        <div class="col-lg-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Address</span>
                                </div>
                                <input id="address" name="address" type="text" value="{{ old('address') }}" class="form-control text-end" aria-describedby="basic-addon1" required/>                                
                            </div>
                            @if($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <!-- <div class="col-lg-3"></div> -->
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2" >Password</span>
                                </div>
                                <input id="password" name="password" type="password" value="{{ old('password') }}" class="form-control text-end" old autocomplete="new-password"  aria-describedby="basic-addon1" required/> 
                                @if($errors->has('password'))
                                    <div class="error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2" >Confirm Password</span>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" class="form-control text-end" autocomplete="new-password"  aria-describedby="basic-addon1" required/> 
                                @if($errors->has('password_confirmation'))
                                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Country</span>
                                </div>
                                <select id="country_id" name="country_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectCountry()" required/>
                                    <option value="">Select Country</option>
                                    @if(isset($countries))
                                    @foreach($countries as $key => $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if($errors->has('country'))
                                    <div class="error">{{ $errors->first('country') }}</div>
                                @endif   
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">State / Province</span>
                                </div>
                                <select id="state_province_id" name="state_province_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectProvince()" required/>  
                                    <option value="">Select State / Province</option>
                                </select>
                                @if($errors->has('state_province_id'))
                                    <div class="error">{{ $errors->first('state_province_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">City</span>
                                </div>
                                <select id="city_id" name="city_id" class="form-control text-end" aria-describedby="basic-addon1" required/>  
                                    <option value="">Select City</option>
                                </select>
                                @if($errors->has('city_id'))
                                    <div class="error">{{ $errors->first('city_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Zip / Postal Code</span>
                                </div>
                                <input id="zip_postal_code" name="zip_postal_code" type="number" value="{{ old('zip_postal_code') }}" class="form-control text-end" aria-describedby="basic-addon1" required/>  
                                @if($errors->has('zip_postal_code'))
                                    <div class="error">{{ $errors->first('zip_postal_code') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"></div>
                            <div class="col-lg-6 text-center mb-5">

                                <div  class=" btn btn-contin w-100 bg-primary m-auto" >
                                    <button type="submit" class="btn btn-primary p-1" style="font-size: 12px; color:black; background:none; border:10px; width:100%">
                                        {{ __('CONTINUE') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </div>
            </form>
            <div class="col-lg-3"></div>
        </div>     
    </div>
</div> 
@endsection

<script type="text/javascript">
	function selectCountry() {
		var select = document.getElementById('country_id');
		var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'provinces/'+id,
            type: 'get',
            // dataType: 'json',
            success: function(response){
                var len = 0;
                $('#state_province_id').empty();
                $('#city_id').empty();
                if(response != null){
                    len = response.length;
                }
                if(len > 0){
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
                    for(var i=0; i<len; i++){
                        var id = response[i].id;
                        var name = response[i].name;
                        var o = new Option(name, id);
                        $("#state_province_id").append(o);
                    }
                }
            }
        });
	}

    function selectProvince() {
		var select = document.getElementById('state_province_id');
		var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'cities/'+id,
            type: 'get',
            // dataType: 'json',
            success: function(response){
                var len = 0;
                $('#city_id').empty();
                if(response != null){
                    len = response.length;
                }
                if(len > 0){
                    var o = new Option("Select City", "");
                    $("#city_id").append(o);
                    for(var i=0; i<len; i++){
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