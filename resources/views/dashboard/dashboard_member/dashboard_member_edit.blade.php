@include('head')
@extends('dashboard.body')
@section('main')
<a href="{{ route('dashboard_member.index') }}" class="btn btn-outline-primary mb-3">
  <i class="bi bi-arrow-left"></i>
  Kembali
</a>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Tambah Member</h5>
    <form action="{{ route('dashboard_member.update', $member->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-12 mb-3 mt-4">
          <label for="name" class="form-label">Name</label>
          <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required value ="{{ old('name') ?? $member->name}}"  autofocus>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
          <label for="Alamat" class="form-label">Alamat</label>
          <input type="text" name="alamat" class="form-control" placeholder="Alamat" required value="{{ $member->alamat}}" autofocus style="height: 5rem;">
          <label for="password" class="form-label">No-Telpon</label>
          <input type="text" name="no_telp" class="form-control @error('name') is-invalid @enderror" placeholder="No Telpon" required value="{{$member->no_telp}}"  autofocus>
          @error('no_telp')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
  </div>
</div>
@endsection

@include('footer')