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
            <form method="POST" action="{{ route('admin.users.update') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user[0]->id }}">
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
                  <div class="form-group phone-area col-lg-6">
                    <label for="phone_number">Phone </label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user[0]->phone_number }}" placeholder="Enter Phone Number" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="country">Country</label>
                    <select id="country_id" name="country_id" class="form-control select2" style="width: 100%;" onChange="selectCountry()" required>
                      @if(isset($countries))
                      @foreach($countries as $key => $country)
                      @if($country->id == $user[0]->country_id)
                      <option value="{{ $country->id }}" selected>
                        {{ $country->country_name }}
                      </option>
                      @else
                      <option value="{{ $country->id }}">
                        {{ $country->country_name }}
                      </option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="state_province">State / Province</label>
                    <select name="state_province_id" id="state_province_id" class="form-control select2" style="width: 100%;" onChange="selectProvince()" required>
                      @if(isset($provinces))
                      @foreach($provinces as $key => $province)
                      @if($province->id == $user[0]->state_province_id)
                      <option value="{{ $province->id }}" selected>
                        {{ $province->name }}
                      </option>
                      @else
                      <option value="{{ $province->id }}">
                        {{ $province->name }}
                      </option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="city_id">City</label>
                    <select name="city_id" id="city_id" class="form-control select2" style="width: 100%;" required>
                      @if(isset($cities))
                      @foreach($cities as $key => $city)
                      @if($city->id == $user[0]->city_id)
                      <option value="{{ $city->id }}" selected>
                        {{ $city->city_name }}
                      </option>
                      @else
                      <option value="{{ $city->id }}">
                        {{ $city->city_name }}
                      </option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="plan_id">Plan / Membership Title</label>
                    <select name="plan_id" id="plan_id" class="form-control select2" style="width: 100%;" required>
                      @if(isset($plans))
                      @foreach($plans as $key => $plan)
                      @if($plan->id == $user[0]->plan_id)
                      <option value="{{ $plan->id }}" selected>
                        {{ $plan->title }}
                      </option>
                      @else
                      <option value="{{ $plan->id }}">
                        {{ $plan->title }}
                      </option>
                      @endif
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="zip_postal_code">Zip / Postal Code</label>
                    <input type="text" class="form-control" id="zip_postal_code" name="zip_postal_code" value="{{ $user[0]->zip_postal_code }}" placeholder="Enter Zip / Postal Code" required>
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
                  <div class="form-group col-lg-12">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user[0]->address }}" placeholder="Enter Address" required>
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
  function selectCountry() {
    var select = document.getElementById('country_id');
    var option = select.options[select.selectedIndex];
    var country_id = option.value;
    var all_provinces = JSON.parse('<?php echo json_encode($all_provinces) ?>');
    var default_province = new Option("Select State / Province", "");
    var default_city = new Option("Select City", "");
    $('#state_province_id').empty();
    $('#city_id').empty();
    $("#state_province_id").append(default_province);
    $("#city_id").append(default_city);
    if (all_provinces.length > 0) {
      for (var i = 0; i < all_provinces.length; i++) {
        if (country_id == all_provinces[i].country_id) {
          var id = all_provinces[i].id;
          var name = all_provinces[i].name;
          var o = new Option(name, id);
          $("#state_province_id").append(o);
        }
      }
    }
  }

  function selectProvince() {
    var select = document.getElementById('state_province_id');
    var option = select.options[select.selectedIndex];
    var state_province_id = option.value;
    var all_cities = JSON.parse('<?php echo json_encode($all_cities) ?>');
    $('#city_id').empty();

    if (all_cities.length > 0) {
      var o = new Option("Select City", "");
      $("#city_id").append(o);
      for (var i = 0; i < all_cities.length; i++) {
        if (state_province_id == all_cities[i].state_province_id) {
          var id = all_cities[i].id;
          var city_name = all_cities[i].city_name;
          var o = new Option(city_name, id);
          $("#city_id").append(o);
        }
      }
    }
  }
</script>

@endsection