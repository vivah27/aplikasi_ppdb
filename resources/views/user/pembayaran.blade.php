@extends('layouts.master')

@section('page_title', 'Pembayaran')

@section('content')
<div class="pagetitle">
  <h1>Form Pembayaran</h1>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Isi Data Pembayaran</h5>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form action="{{ route('user.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
          <input type="text" name="jenis_pembayaran" class="form-control" placeholder="Contoh: Uang Pendaftaran" required>
        </div>

        <div class="mb-3">
          <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
          <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="metode_id" class="form-label">Metode Pembayaran</label>
          <select name="metode_id" class="form-control" required>
            <option value="">-- Pilih Metode --</option>
            @foreach($metode as $m)
              <option value="{{ $m->id }}">{{ $m->label }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="bukti" class="form-label">Upload Bukti Pembayaran</label>
          <input type="file" name="bukti" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
      </form>

      @if($pembayaran)
        <hr>
        <h5 class="mt-4">Status Pembayaran Terakhir</h5>
        <ul>
          <li>Jenis: {{ $pembayaran->jenis_pembayaran }}</li>
          <li>Jumlah: Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</li>
          <li>Metode: {{ $pembayaran->metode->label ?? '-' }}</li>
          <li>Status: <strong>{{ $pembayaran->status->label ?? 'Menunggu' }}</strong></li>
          <li>Tanggal: {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i') }}</li>
        </ul>
        @if($pembayaran->bukti_path)
          <a href="{{ asset('storage/' . $pembayaran->bukti_path) }}" target="_blank" class="btn btn-outline-info btn-sm">
            Lihat Bukti
          </a>
        @endif
      @endif
    </div>
  </div>
</section>
@endsection
