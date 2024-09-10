@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="{{ route('dashboard_admin.index') }}" class="btn btn-outline-primary mb-3">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
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
                                    @foreach($inactives as $inactive )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$inactive->name}}</td>
                                            <td>{{$inactive->email}}</td>
                                            <td>
                                            <form action="{{ route('dashboard_inactive.activate', $inactive->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="d-block btn btn-warning w-100 mb-2">
                                            <i class="bi bi-pencil"></i>
                                            Set Active
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

                    
