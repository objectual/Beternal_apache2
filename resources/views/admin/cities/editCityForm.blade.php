@extends("admin.layouts.layout")
@section("title","Admin Edit City")

@section('content_header')
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Edit City</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
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
        <section class="col-lg-6 connectedSortable">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Edit City</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.cities.add-update') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="city_id" value="{{ $city[0]->id }}">
              <div class="card-body">
                <div class="form-group">
                  <label for="country">Country</label>
                  <select id="country_id" name="country_id" class="form-control select2" style="width: 100%;" onChange="selectCountry()" required>
                    @if(isset($countries))
                    @foreach($countries as $key => $country)
                    @if($country->id == $city[0]->country_id)
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
                <div class="form-group">
                  <label for="state_province">State / Province</label>
                  <select name="state_province_id" id="state_province_id" class="form-control select2" style="width: 100%;" required>
                    @if(isset($provinces))
                    @foreach($provinces as $key => $province)
                    @if($province->id == $city[0]->state_province_id)
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
                <div class="form-group">
                  <label for="city_name">City Name</label>
                  <input type="text" class="form-control" id="city_name" name="city_name" value="{{ $city[0]->city_name }}" placeholder="Enter City Name" required>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control select2" style="width: 100%;">
                    @if($city[0]->status == 1)
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                    @elseif($city[0]->status == 0)
                    <option value="0">Deactive</option>
                    <option value="1">Active</option>
                    @endif
                  </select>
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
    $("#state_province_id").append(default_province);
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
</script>
@endsection