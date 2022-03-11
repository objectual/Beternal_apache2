@extends("admin.layouts.layout")
@section("title","Admin Add New City")

  @section('content_header')
  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New City</h1>
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
                  <h3 class="card-title">Add New City</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.cities.add-update') }}"  enctype="multipart/form-data">
                @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="country">Country</label>
                      <select id="country_id" name="country_id" class="form-control select2" style="width: 100%;" onChange="selectCountry()" required>
                        <option value="">Select Country</option>
                        @if(isset($countries))
                        @foreach($countries as $key => $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                        @endif
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="state_province">State / Province</label>
                      <select name="state_province_id" id="state_province_id" class="form-control select2" style="width: 100%;" required>
                        <option value="">Select State / Province</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="city_name">City Name</label>
                      <input type="text" class="form-control" id="city_name" name="city_name" placeholder="Enter City Name" required>
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control select2" style="width: 100%;">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

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
        if(response != null){
          len = response.length;
        }
        if(len > 0){
          var default_province = new Option("Select State / Province", "");
          $("#state_province_id").append(default_province);
          for(var i=0; i<len; i++){
            var id = response[i].id;
            var name = response[i].name;
            var o = new Option(name, id);
            $("#state_province_id").append(o);
          }
        } else {
          var default_province = new Option("Select State / Province", "");
          $("#state_province_id").append(default_province);
        }
      }
    });
	}
</script>
@endsection