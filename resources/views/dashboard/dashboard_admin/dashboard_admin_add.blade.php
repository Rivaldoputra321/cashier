@include('head')
@extends('dashboard.body')
@section('main')
<a href="{{ route('dashboard_admin.index') }}" class="btn btn-outline-primary mb-3">
  <i class="bi bi-arrow-left"></i>
  Kembali
</a>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Add Admin</h5>
    <form action="{{route('dashboard_admin.store')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12 mb-3 mt-4">
          <label for="name" class="form-label">Name</label>
          <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required value="{{ old('name') }}"  autofocus>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required value="{{ old('email') }}" autofocus>
          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
          <label for="password" class="form-label">Password</label>
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
      <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
  </div>
</div>
@endsection

@include('footer')