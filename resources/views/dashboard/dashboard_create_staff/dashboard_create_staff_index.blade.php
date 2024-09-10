@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="dashboard_staff/create" class="btn btn-primary py-2">
                                <i class="bi bi-plus"></i>
                                Tambah Staff
                    </a>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Staff</h6>
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
                                    @foreach($staffs as $staff )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$staff->name}}</td>
                                            <td>{{$staff->email}}</td>
                                            <td>
                                                <a href="/dashboard_staff/{{ $staff->name }}/edit" class="d-block btn btn-warning w-100 mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('dashboard_staff.destroy', $staff->id) }}" method="POST">
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

                    
