@include('head')
@extends('dashboard.body')
@section('main')
<a href="{{ route('dashboard_category.index') }}" class="btn btn-outline-primary mb-3">
  <i class="bi bi-arrow-left"></i>
  Kembali
</a>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Add Category</h5>
    <form action="{{route('dashboard_category.store')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12 mb-3 mt-4">
          <label for="name" class="form-label">Name Category</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('category') }}" required @required(true)>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</div>
@endsection
@include('footer')