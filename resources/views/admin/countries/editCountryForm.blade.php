@extends("admin.layouts.layout")
@section("title","Admin Edit Country")

  @section('content_header')
  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Country</h1>
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
                  <h3 class="card-title">Edit Country</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.countries.add-update') }}"  enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="country_name">Country Name</label>
                      <input type="text" class="form-control" id="country_name" name="country_name" value="{{ $country->country_name }}" placeholder="Enter Country Name" required>
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control select2" style="width: 100%;">
                        @if($country->status == 1)
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                        @else
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
