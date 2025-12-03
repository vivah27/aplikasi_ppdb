@extends('layouts.master')

@section('page_title', 'Verifikasi Dokumen')

@section('content')
<div style="max-width: 100%;">
    <!-- Page Header -->
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">Verifikasi Dokumen</h1>
        <p style="color: #6b7280; font-size: 15px; margin: 0;">Kelola dan verifikasi dokumen dari calon siswa</p>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; border-radius: 10px; color: #059669; padding: 14px 16px; margin-bottom: 20px;">
            <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="color: #10b981; opacity: 0.7;"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; border-radius: 10px; color: #dc2626; padding: 14px 16px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle me-2" style="color: #ef4444;"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="color: #ef4444; opacity: 0.7;"></button>
        </div>
    @endif

    <!-- Siswa List Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); color: white;">
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">No</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Siswa</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">NISN</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Dokumen</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Status Verifikasi</th>
                        <th style="padding: 15px; text-align: left; color: white; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $item)
                        @php
                            $totalDokumen = $item->dokumen->count();
                            $terverifikasi = $item->dokumen->where('statusVerifikasi.kode', 'verified')->count();
                            $ditolak = $item->dokumen->where('statusVerifikasi.kode', 'rejected')->count();
                            $menunggu = $totalDokumen - $terverifikasi - $ditolak;
                            $persentase = $totalDokumen > 0 ? ($terverifikasi / $totalDokumen) * 100 : 0;
                        @endphp
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                            <td style="padding: 15px; color: #1f2937;">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                            <td style="padding: 15px;">
                                <div style="color: #1f2937; font-weight: 600;">{{ $item->nama_lengkap }}</div>
                            </td>
                            <td style="padding: 15px; color: #1f2937;">{{ $item->nisn }}</td>
                            <td style="padding: 15px; color: #1f2937;">
                                <span style="display: inline-block; padding: 6px 12px; background: rgba(99, 102, 241, 0.15); color: #6366f1; border-radius: 6px; font-weight: 600; font-size: 12px;">
                                    {{ $totalDokumen }} Dokumen
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    <div style="font-size: 12px; color: #6b7280;">
                                        <span style="color: #10b981; font-weight: 600;">✓ {{ $terverifikasi }}</span> | 
                                        <span style="color: #ef4444; font-weight: 600;">✗ {{ $ditolak }}</span> | 
                                        <span style="color: #f59e0b; font-weight: 600;">⏳ {{ $menunggu }}</span>
                                    </div>
                                    <div style="width: 100px; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ $persentase }}%; height: 100%; background: linear-gradient(90deg, #10b981, #34d399); transition: width 0.3s;"></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px;">
                                <a href="{{ route('admin.verifikasi.siswa', $item->id) }}" style="padding: 8px 16px; background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(99, 102, 241, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                    <i class="fas fa-folder-open"></i> Lihat Dokumen
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
                                <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                                <p style="margin: 10px 0 0 0;">Tidak ada siswa dengan dokumen untuk diverifikasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $siswa->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
