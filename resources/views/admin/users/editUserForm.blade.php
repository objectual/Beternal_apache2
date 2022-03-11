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
                <form method="POST" action="{{ route('admin.users.update') }}"  enctype="multipart/form-data">
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
                        <div class="form-group col-lg-6">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user[0]->phone_number }}" placeholder="Enter Phone Number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country_id" name="country_id" value="{{ $user[0]->country_name }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="state_province">State / Province</label>
                            <input type="text" class="form-control" id="state_province_id" name="state_province_id" value="{{ $user[0]->province_name }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city_id" name="city_id" value="{{ $user[0]->city_name }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="plan">Plan / Membership Title</label>
                            <input type="text" class="form-control" id="plan" name="plan" value="{{ $user[0]->title }}" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="zip_postal_code">Zip / Postal Code</label>
                            <input type="text" class="form-control" id="zip_postal_code" name="zip_postal_code" value="{{ $user[0]->zip_postal_code }}" placeholder="Enter Zip / Postal Code" required>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

@endsection