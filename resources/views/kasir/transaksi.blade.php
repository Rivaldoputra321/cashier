<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starbhak Mart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
            color: #fff;
        }
        .navbar-brand {
            color: #fff;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .product-item {
            width: 150px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            padding: 10px;
            background-color: #fff;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            height: 100vh;
        }
        .sidebar .form-control, .sidebar .btn {
            margin-bottom: 10px;
        }
        .summary {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .total-amount {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-payment {
            background-color: #007bff;
            color: #fff;
            position: fixed;
            bottom: 10px;
            right: 10px;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a class="navbar-brand" href="/dashboard">Starbhak Mart</a>
</nav>

<!-- ... Other parts of your HTML ... -->

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <form action="" method="POST"> <!-- Example route for handling member code -->
                @csrf
                <div class="form-group">
                    <label for="member_code">Kode Member</label>
                    <input type="text" id="member_code" name="member_code" class="form-control" placeholder="Masukkan kode member">
                </div>
            </form>

            <!-- Cart Items Section -->
            <div class="cart-items mt-4">
                <h5>Cart Items</h5>
                <ul id="cart-items-list" class="list-group">
                    @forelse($sale->detailSales as $detail)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $detail->product->name }}</strong><br>
                                    {{ $detail->jumlah_product }} x <span class="price">@currency($detail->product->harga)</span><br>
                                    Subtotal: <span class="price">@currency($detail->subtotal)</span>
                                </div>
                                <form action="{{ route('delete', $detail->product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE') <!-- Add this line to override the method to DELETE -->
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                <form action="{{ route('minus', $detail->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Kurang</button>
                                </form>
                                <form action="{{ route('plus', $detail->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Plus</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">Keranjang belanja Anda kosong.</li>
                    @endforelse

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="received_amount">Uang Diterima</label>
                            <input type="text" class="form-control" id="received_amount" name="received_amount" placeholder="Masukan Uang" required>
                        </div>
                    
                    </form>
                </ul>
            </div>

            <!-- Summary Section -->
            <div class="summary mt-4">
                <p>Discount: Rp. <span id="discount">0</span></p>
                <p>Tax: Rp. <span id="tax">0</span></p>
                <p class="total-amount">Total Amount:  <span id="total-amount">{{ number_format($sale->total_harga, 0, ',', '.') }}</span></p>
                <p class="total-amount">Kembali Rp. <span id="change-amount"></span></p>
            </div>
        </div>

        <!-- Product List -->
        <div class="col-md-9">
            <h4>Item List</h4>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="product-list" id="product-list">
                @foreach($products as $product)
                    <div class="product-item" data-id="{{ $product->id }}" data-price="{{ $product->harga }}">
                        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/100' }}" alt="" class="img-thumbnail">
                        <p>{{ $product->name }}</p>
                        <p class="price">@currency($product->harga)</p>
                        <p class="price">stock: {{$product->stok}}</p>

                        <!-- Add-to-Cart Form -->
                        <form action="{{ route('add-to-cart', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" {{ $product->stok == 0 ? 'disabled' : '' }}>Add to Cart</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Payment Button -->
<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <button class="btn btn-payment" id="payment-button">Payment (CTRL + P)</button>
</form>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Function to format numbers as Rupiah currency
function formatRupiah(angka) {
    const format = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    return format.format(angka);
}

$(document).ready(function(){
    // Update total amount and change amount
    let totalAmount = {{ $sale->total_harga }};
    $('#total-amount').text(formatRupiah(totalAmount));
    
    $('#received_amount').on('input', function(){
        let receivedAmount = parseFloat($(this).val().replace(/[^0-9.-]+/g,""));
        if (isNaN(receivedAmount)) receivedAmount = 0;
        let changeAmount = receivedAmount - totalAmount;
        $('#change-amount').text(formatRupiah(changeAmount));
    });
});

</script>

</body>
</html>
