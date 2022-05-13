@extends("admin.layouts.layout")
@section("title","Admin Edit Role")

@section('content_header')
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Role</h1>
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
              <h3 class="card-title">Edit Role</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.roles.add-update') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="role_id" value="{{ $user_role->id }}">
              <div class="card-body">
                <div class="form-group">
                  <label for="role_title">Role Title</label>
                  <input type="text" class="form-control" id="role_title" name="role_title" value="{{ $user_role->role_name }}" placeholder="Enter Role Title" required>
                </div>
                <div class="form-group">
                  <label for="description">Role Description</label>
                  <textarea class="form-control" id="description" name="description" placeholder="Enter Role Description" required>{{ $user_role->description }}</textarea>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control select2" style="width: 100%;">
                    @if($user_role->status == 1)
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