@include('head')
@extends('dashboard.body')

@section('main')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Report</h6>
    </div>
    <br>
    <!-- Month Filter Form -->
    <form action="{{ route('laporan') }}" method="GET">
        <label for="month">Select Month:</label>
        <input type="text" id="monthPicker" name="month" value="{{ $selectedMonth }}">
        <button type="submit" class="btn-primary" style="border-radius: 10px;">Filter</button>
    </form>
    <br>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Total Item</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dates as $date)
                        @php
                            // Fetch sales for the current date, if any
                            $daySales = $sales->get($date, collect());
        
                            // Sum the fields for the day (or set to 0 if no sales)
                            $totalItems = $daySales->sum('total_item') ?: 0;
                            $totalPrice = $daySales->sum('total_harga') ?: 0;
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                            <td>
                                @if($daySales->isNotEmpty())
                                    {{ $daySales->first()->user->name }} <!-- Assum ing `name` is the user field -->
                                @else
                                    <p>No User</p>
                                @endif
                            </td>
                            <td>{{ $totalItems }} </td>
                            <td>@currency($totalPrice)</td>
                            
                        </tr>
                        
                    @endforeach
                    <tr>
                        <td colspan="2">Total Pendapatan Bulan Ini:</td>
                        <td>@currency($totalKeuntunganBulanIni)</td>
                      </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Datepicker CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Datepicker Initialization -->
<script>
    $(function() {
        $('#monthPicker').datepicker({
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        });
    });
</script>
@endsection

@include('footer')
