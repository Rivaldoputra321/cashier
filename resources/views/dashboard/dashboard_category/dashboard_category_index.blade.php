@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="/dashboard_category/create" class="btn btn-primary py-2">
                                <i class="bi bi-plus"></i>
                                Tambah Category
                    </a>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Category</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($categories as $category )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>
                                            <a href="dashboard_category/{{$category->slug}}/edit" class="d-block btn btn-warning w-100 mb-2">
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </a>
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('dashboard_category.destroy', $category->id) }}" method="POST">
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

                    
