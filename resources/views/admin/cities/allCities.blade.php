@extends("admin.layouts.layout")
@section("title","Admin All Cities")

@section('content_header')
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">All Cities</h1>
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
        <section class="col-lg-12 connectedSortable">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Cities</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>City</th>
                    <th>State / Province</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cities as $city)
                  <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ ucfirst($city->city_name)}}</td>
                    <td>{{ ucfirst($city->name)}}</td>
                    <td>{{ ucfirst($city->country_name)}}</td>
                    <td>
                      @if($city->status == 1)Active
                      @elseif($city->status == 0)Deactive
                      @endif
                    </td>
                    <td>
                      <a href="{{ url('admin/cities/show/'.$city->id) }}">
                        <i class="fas fa-edit"></i>
                      </a>
                      <!-- <a href="#">
                        X
                      </a> -->
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>City</th>
                    <th>State / Province</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
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
@endsection