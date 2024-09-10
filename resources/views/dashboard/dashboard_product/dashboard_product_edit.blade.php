@include('head')
@extends('dashboard.body')
@section('main')
<a href="{{ route('dashboard_product.index') }}" class="btn btn-outline-primary mb-3">
  <i class="bi bi-arrow-left"></i>
  Kembali
</a>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Edit Product</h5>
    <form action="{{route('dashboard_product.update', $product->slug)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-12 mb-3 mt-4">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror " placeholder="Name" value= "{{old('name')??$product->name }}" required  autofocus>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
          <select class="form-control @error('category') is-invalid @enderror" aria-label="Select category" id="category_id" name="categories" value="" required @required(true)>
            <option value="">--Choose Category--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ optional($product->categories()->get()->first())->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

          <label for="alamat" class="form-label">Price</label>
          <input type="number" name="harga" class="form-control" placeholder="Price" value= "{{$product->harga }}" required autofocus>
          <label for="password" class="form-label">Stock</label>
          <input type="number" name="stok" class="form-control" placeholder="Stock" value= "{{ $product->stok }}" required  autofocus>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Edit</button>
    </form>
  </div>
</div>
@endsection

@include('footer')