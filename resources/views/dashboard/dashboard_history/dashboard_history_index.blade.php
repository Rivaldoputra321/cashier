@include ('head')
@extends ('dashboard.body')
@section('main')
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables History</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Total Item</th>
                                            <th>Total Price</th>
                                            <th>Received</th>
                                            <th>Returned</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($sales as $sale )
                                    <tbody>
                                        <tr>
                                            <td>{{$sale->tgl_penjualan->format('d M Y')}}</td>
                                            <td>{{$sale->total_item}}</td>
                                            <td>@currency($sale->total_harga)</td>
                                            <td>@currency($sale->diterima)</td>
                                            <td>@currency($sale->kembali)</td>
                                            <td>
                            
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

                    
