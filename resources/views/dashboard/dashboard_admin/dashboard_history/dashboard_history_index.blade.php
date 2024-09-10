@include ('head')
@extends ('dashboard.body')
@section('main')
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="dashboard_product/create" class="btn btn-primary py-2">
                                <i class="bi bi-plus"></i>
                                Tambah Product
                    </a>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Product</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Product</th>
                                            <th>Name Product</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($products as $product )
                                    <tbody>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$product->kd_product}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>@foreach($product->categories as $category)
                                                    {{ $category->name }}
                                                @endforeach
                                            </td>
                                            <td>@currency($product->harga)</td>
                                            <td>{{$product->stok}}</td>
                                            <td>
                                                <a href="/dashboard_product/{{ $product->slug }}/edit" class="d-block btn btn-warning w-100 mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('dashboard_product.destroy', $product->id) }}" method="POST">
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

                    
