@extends("admin.layouts.layout")
@section("title","Admin All Users")

@section('content_header')
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">All Users</h1>
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
  @php $base_url = url(''); @endphp
  @if(session()->has('message'))
  <div class="modal-dialog logout-modal">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-10 text-center offset-lg-1">
            <p class="">{{ session()->get('message') }}</p>
            <div class="text-center mb-4">
              <a href="{{ route('admin.users') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
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
              <h3 class="card-title">All Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Profile Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Membership</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $serial = 1;
                  @endphp
                  @foreach($users as $user)
                  <tr>
                    <td>{{ $serial }}</td>
                    <td><img src="{{ asset($user->profile_image) }}" style="width:60px; border-radius:100%;" alt=""></td>
                    <td>{{ ucfirst($user->name)}} {{ ucfirst($user->last_name) }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role->role_name) }}</td>
                    <td>{{ ucfirst($user->title) }}</td>
                    <td>
                      @if(Auth::user()->id != $user->id)
                      <a href="{{ url('admin/users/show/'.$user->id) }}">
                        <i class="fas fa-edit"></i>
                      </a> &nbsp;
                      <a class="delete-user" id="{{ $user->id }}" data-bs-target="#delete" onclick="deleteUser(this)">
                      <i class="fas fa-trash"></i>
                      </a>
                      @endif
                    </td>
                  </tr>
                  @php
                  $serial++;
                  @endphp
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Profile Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Membership</th>
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

<div class="modal fade delete-recipent" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 text-center offset-lg-3">
            <p class="">
              Are you sure you want to delete user ?
            </p>
            <div class="text-center mb-4">
              <a href="" class="mx-1" id="delete_user"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
              <a class="mx-1 close-cancel close" data-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style> 
  .delete-user {
    cursor: pointer;
}
.close-cancel {
    cursor: pointer;
}
</style>
@endif
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

  function deleteUser(current) {
    var base_url = '<?= $base_url ?>';
    var set_path = base_url + '/admin/users/delete/' + current.id;
    var element = document.getElementById('delete_user');
    element.href = set_path;
    $("#delete").modal("show");
  }
</script>
@endsection