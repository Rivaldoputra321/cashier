@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="dashboard_admin/create" class="btn btn-primary py-2">
                                <i class="bi bi-plus"></i>
                                Add Admin
                    </a>

                    <a href="{{route('dashboard_inactive')}}" class="btn btn-primary py-2">
                                See Admins Account Not Active
                    </a>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Admin</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($admins as $admin )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$admin->name}}</td>
                                            <td>{{$admin->email}}</td>
                                            <td>
                                                <a href="/dashboard_admin/{{ $admin->name }}/edit" class="d-block btn btn-warning w-100 mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('dashboard_admin.destroy', $admin->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100">
                                                    <i class="bi bi-trash"></i>
                                                    Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

@endsection
@include('footer')

                    
