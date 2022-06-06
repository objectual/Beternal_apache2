<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("admin.layouts.layout")
@section("title","Admin Edit User")

@section('content_header')
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-sm-12">
          @if(isset($success))
          <h1 class="m-0" style="text-align: center; color:grey">{{ $success }}</h1>
          @endif
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>

  <!-- /.content-header -->
  @endsection
  @section('content')
  @php $base_url = url(''); @endphp
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.users.update') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user[0]->id }}">
              <input type="hidden" id="country_code" name="country_code" value="">
              <input type="hidden" id="postal_code_format" name="postal_code_format" value="{{ $user[0]->postal_code_format }}">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user[0]->name }}" placeholder="Enter Full Name" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user[0]->last_name }}" placeholder="Enter last Name" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user[0]->email }}" placeholder="Enter Email" required>
                  </div>
                  <div class="form-group d-grid col-lg-6">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user[0]->phone_number }}" maxlength="15" onKeyup='addDashes(this)' required>
                    <div class="col-12" id="show_phone_msg"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="plan">Plan / Membership Title</label>
                    <select id="plan_id" name="plan_id" class="form-control select2" style="width: 100%;" required>
                      @if(isset($plans))
                      @foreach($plans as $key => $plan)
                      @if($user[0]->plan_id == $plan->id)
                      <option value="{{ $plan->id }}" selected>
                        {{ $plan->title }}
                      </option>
                      @else
                      <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="status">User Role</label>
                    <select name="role_id" class="form-control select2" style="width: 100%;">
                      @if(isset($user_roles))
                      @foreach($user_roles as $key => $role)
                      @if($user[0]->role_id == $role->id)
                      <option value="{{ $role->id }}" selected>{{ $role->role_name }}</option>
                      @else
                      <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user[0]->address }}" placeholder="Enter Address" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="country">Country</label>
                    <select id="country_id" name="country_id" class="form-control select2" style="width: 100%;" onChange="selectCountry()" required>
                      @if(isset($countries))
                      @foreach($countries as $key => $country)
                      @if($user[0]->country_id == $country->id)
                      <option id="{{ $country->postal_code_format }}" value="{{ $country->id }}" selected>
                        {{ $country->country_name }}
                      </option>
                      @else
                      <option id="{{ $country->postal_code_format }}" value="{{ $country->id }}">{{ $country->country_name }}</option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="state_province">State / Province</label>
                    <select id="state_province_id" name="state_province_id" class="form-control select2" style="width: 100%;" onChange="selectProvince()" required>
                      @if(isset($provinces))
                      @foreach($provinces as $key => $province)
                      @if($user[0]->state_province_id == $province->id)
                      <option value="{{ $province->id }}" selected>
                        {{ $province->name }}
                      </option>
                      @else
                      <option value="{{ $province->id }}">{{ $province->name }}</option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="city">City</label>
                    <select id="city_id" name="city_id" class="form-control select2" style="width: 100%;" required>
                      <option value="{{ $user[0]->city_id }}" selected>
                        {{ $user[0]->city_name }}
                      </option>
                      @if(isset($cities))
                      @foreach($cities as $key => $city)
                      <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="status">Status</label>
                    <select name="status" class="form-control select2" style="width: 100%;">
                      @if($user[0]->status == 1)
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                      @elseif($user[0]->status == 0)
                      <option value="0">Deactive</option>
                      <option value="1">Active</option>
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6" id="zip_code">
                    <label for="zip_postal_code">Zip / Postal Code</label>
                    <input type="text" class="form-control" id="zip_postal_code" name="zip_postal_code" value="{{ $user[0]->zip_postal_code }}" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required>
                    <div class="col-12" id="show_postal_msg"></div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </section>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<script src="{!! asset('/public/build/js/intlTelInput.js') !!}"></script>
<script>
  var input = document.querySelector("#phone");
  var country_code = '<?= $user[0]->country_code ?>';
  if (country_code.length == 0) {
    country_code = "pk";
  }
  window.intlTelInput(input, {
    initialCountry: country_code,
    utilsScript: "{!! asset('/public/build/js/utils.js') !!}",
  });
</script>
@endsection
@section('js')

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script type="text/javascript">
  window.addDashes = function addDashes(f) {
    let unicode = event.keyCode;
    if (unicode != 8) {
      var phone = document.getElementById('phone');
      var phone_placeholder = phone.placeholder;
      const check_integer = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
      const index_of_char = [];
      const count_n = [];

      // var char_1 = '';
      // var char_2 = '';
      // var char_3 = '';
      // var char_4 = '';
      // var char_5 = '';
      // var num_1 = '';
      // var num_2 = '';
      // var num_3 = '';
      // var num_4 = '';
      // var num_5 = '';
      // var a = 1;
      // var b = 1;
      // var x = 0;
      // var check_length = phone_placeholder.length - 1;
      // for (var i = 0; i < phone_placeholder.length; i++) {
      //   var check_placeholder = parseInt(phone_placeholder[i]);
      //   if (check_integer.includes(check_placeholder)) {
      //     x++;
      //     if (i == check_length) {
      //       count_n.push(x);
      //     }
      //   } else {
      //     index_of_char.push(i);
      //     count_n.push(x);
      //     x = 0;
      //     if (a == 1) {
      //       char_1 = phone_placeholder[i];
      //     }
      //     if (a == 2) {
      //       char_2 = phone_placeholder[i];
      //     }
      //     if (a == 3) {
      //       char_3 = phone_placeholder[i];
      //     }
      //     if (a == 4) {
      //       char_4 = phone_placeholder[i];
      //     }
      //     if (a == 5) {
      //       char_5 = phone_placeholder[i];
      //     }
      //     a++;
      //   }
      // }
      // for (var j = 0; j < count_n.length; j++) {
      //   if (b == 1) {
      //     num_1 = count_n[j];
      //   }
      //   if (b == 2) {
      //     num_2 = count_n[j];
      //   }
      //   if (b == 3) {
      //     num_3 = count_n[j];
      //   }
      //   if (b == 4) {
      //     num_4 = count_n[j];
      //   }
      //   if (b == 5) {
      //     num_5 = count_n[j];
      //   }
      //   b++;
      // }
      // var r = /(\D+)/g,
      //   npa = '',
      //   nxx = '',
      //   nxy = '',
      //   nxz = '',
      //   last4 = '';
      // f.value = f.value.replace(r, '');
      // npa = f.value.substr(0, num_1);
      // nxx = f.value.substr(num_1, num_2);
      // nxy = f.value.substr(num_1 + num_2, num_3);
      // nxz = f.value.substr(num_2 + num_3, num_4);
      // last4 = f.value.substr(num_3 + num_4, num_5);
      // f.value = npa + char_1 + nxx + char_2 + nxy + char_3 + nxz + char_4 + last4;

      phone.setAttribute('maxlength', phone_placeholder.length);
      if (phone.value.length <= phone_placeholder.length) {
        if (phone.value.length < 2) {
          var first_index = parseInt(phone_placeholder[0]);
          var first_integer = 0;
          if (check_integer.includes(first_index)) {
            first_integer = 1;
          }
          if (first_integer == 0) {
            var first_char = '';
            first_char = phone_placeholder[0];
            first_char = first_char + phone.value;
            phone.value = first_char;
          }
        }
        if (phone.value.length < phone_placeholder.length) {
          var len = phone.value.length;
          var check_placeholder = parseInt(phone_placeholder[len]);
          if (!(check_integer.includes(check_placeholder))) {
            var phone_format = '';
            phone_format = phone.value;
            phone_format = phone_format + phone_placeholder[len];
            phone.value = phone_format;
          }
        }
        if (phone.value.length < phone_placeholder.length) {
          var len_2 = phone.value.length;
          var check_placeholder_2 = parseInt(phone_placeholder[len_2]);
          if (!(check_integer.includes(check_placeholder_2))) {
            var phone_format_2 = '';
            phone_format_2 = phone.value;
            phone_format_2 = phone_format_2 + phone_placeholder[len_2];
            phone.value = phone_format_2;
          }
        }
      }
    }
  }

  function selectCountry() {
    var base_url = '<?= $base_url ?>';
    var select = document.getElementById('country_id');
    var option = select.options[select.selectedIndex];
    var id = option.value;
    var postal_code_format = document.getElementById('postal_code_format');

    $.ajax({
      url: base_url + '/provinces/' + id,
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

    postal_code_format.value = option.id;
    var required_field = 'Required Field';
    var validity = '';
    var zip_input = '<label for="zip_postal_code">Zip / Postal Code</label><input type="text" class="form-control" id="zip_postal_code" name="zip_postal_code" value="" placeholder="Required Field" oninvalid="this.setCustomValidity(' + required_field + ')" oninput="setCustomValidity(' + validity + ')" required><div class="col-12" id="show_postal_msg"></div>';
    $('#show_postal_msg').empty();
    $('#zip_code').empty();
    $('#zip_code').append(zip_input);
    if (option.id == 00000 || option.id == NULL) {
      $('#show_postal_msg').empty();
      $('#zip_code').empty();
    }
  }

  function selectProvince() {
    var base_url = '<?= $base_url ?>';
    var select = document.getElementById('state_province_id');
    var option = select.options[select.selectedIndex];
    var id = option.value;

    $.ajax({
      url: base_url + '/cities/' + id,
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
        } else {
          var o = new Option(option.text, 0);
          $("#city_id").append(o);
        }
      }
    });
  }

  function validateForm() {
    var phone_code = document.getElementById('country_code');
    var phone = document.getElementById('phone');
    var phone_number = phone.value;
    var phone_placeholder = phone.placeholder;
    var phone_msg = '<span class="cl-white">Phone number is incomplete!</span>';
    var selected_flag = document.querySelector('.iti__selected-flag');
    var get_code = selected_flag.getAttribute('aria-activedescendant');
    var country_code = '';
    const myArray = get_code.split("-");
    var word = myArray[1];
    var word_length = myArray.length;
    var word_index = word_length - 1;
    var selected_status = 0;

    if (myArray[word_index] == 'preferred') {
      country_code = myArray[--word_index];
    } else {
      country_code = myArray[word_index];
    }
    phone_code.value = country_code;

    const check_alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    for (var i = 0; i < phone_number.length; i++) {
      if (check_alpha.includes(phone_number[i])) {
        $('#show_phone_msg').empty();
        $("#show_phone_msg").append('<span class="cl-white">Phone number is not valid!</span>');
        return false;
      }
    }
    if (phone_number.length != phone_placeholder.length) {
      $('#show_phone_msg').empty();
      $("#show_phone_msg").append(phone_msg);
      return false;
    }
    $('#show_phone_msg').empty();

    var postal_code_format = document.getElementById('postal_code_format').value;
    if (postal_code_format != 00000 || postal_code_format != NULL) {
      var zip_postal_code = document.getElementById('zip_postal_code').value;
      var postal_msg = '<span class="cl-white">Format not matched! required format is ' + postal_code_format + '</span>';
      if (postal_code_format.length == zip_postal_code.length) {
        for (var i = 0; i < zip_postal_code.length; i++) {
          var check_number_postal = parseInt(zip_postal_code[i]);
          var check_postal_format = parseInt(postal_code_format[i]);
          const check_integer = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
          const alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
          if (check_integer.includes(check_postal_format)) {
            if (!(check_integer.includes(check_number_postal))) {
              $('#show_postal_msg').empty();
              $("#show_postal_msg").append(postal_msg);
              return false;
            }
          } else if (alphabet.includes(postal_code_format[i])) {
            if (!(alphabet.includes(zip_postal_code[i]))) {
              $('#show_postal_msg').empty();
              $("#show_postal_msg").append(postal_msg);
              return false;
            }
          } else if (!(check_integer.includes(check_postal_format)) && !(alphabet.includes(postal_code_format[i]))) {
            if (zip_postal_code[i] != postal_code_format[i]) {
              $('#show_postal_msg').empty();
              $("#show_postal_msg").append(postal_msg);
              return false;
            }
          }
        }
        $('#show_postal_msg').empty();
      } else {
        $('#show_postal_msg').empty();
        $("#show_postal_msg").append(postal_msg);
        return false;
      }
    }
    return true;
  }
</script>

@endsection