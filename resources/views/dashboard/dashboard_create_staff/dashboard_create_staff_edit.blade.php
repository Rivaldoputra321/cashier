@include('head')
@extends('dashboard.body')

@section('main')
<a href="{{ route('dashboard_staff.index') }}" class="btn btn-outline-primary mb-3">
  <i class="bi bi-arrow-left"></i>
  Kembali
</a>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Edit Staff</h5>
    <form action="{{ route('dashboard_staff.update', $staff->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-12 mb-3 mt-4">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required value="{{ old('name') ?? $staff->name }}" autofocus>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
          <label for="password" class="form-label mt-3">Password</label>
          <div class="input-group">
              <input name="password" id="password" type="password" class="form-control form-control-user" placeholder="Password" required>
              <div class="input-group-append">
                <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                  <i class="bi bi-eye-fill" id="toggle-icon"></i>
                </span>
              </div>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Edit</button>
    </form>
  </div>
</div>
@endsection

@include('footer')
