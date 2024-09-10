@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="dashboard_member/create" class="btn btn-primary py-2">
                                <i class="bi bi-plus"></i>
                                Tambah Member
                    </a>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Member</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Member</th>
                                            <th>Name</th>
                                            <th>Alamat</th>
                                            <th>No-Telpon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($members as $member )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$member->kd_member}}</td>
                                            <td>{{$member->name}}</td>
                                            <td>{{$member->alamat}}</td>
                                            <td>{{$member->no_telp}}</td>
                                            <td>
                                                <a href="/dashboard_member/{{ $member->name }}/edit" class="d-block btn btn-warning w-100 mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('dashboard_member.destroy', $member->id) }}" method="POST">
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

                    
