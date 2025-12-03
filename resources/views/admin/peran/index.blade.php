@extends('layouts.master')

@section('page_title', 'Manajemen Peran')

@section('content')
<div style="max-width: 100%;">
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0; color: #1f2937; font-weight: 700;">Manajemen Peran (Role)</h3>
            <p style="margin: 8px 0 0 0; color: #6b7280; font-size: 14px;">Kelola peran dan hak akses pengguna sistem</p>
        </div>
        <a href="{{ route('admin.peran.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;">
            <i class="fas fa-plus"></i>Tambah Peran
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
            <div>
                <strong style="color: #10b981;">Berhasil!</strong>
                <p style="margin: 3px 0 0 0; font-size: 14px; color: #10b981;">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 18px;"></i>
            <div>
                <strong style="color: #ef4444;">Tidak Dapat Dihapus!</strong>
                <p style="margin: 3px 0 0 0; font-size: 14px; color: #ef4444;">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- List Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">No</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Nama Peran</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Deskripsi</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Pengguna</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Dibuat</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peran as $item)
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                            <td style="padding: 15px; color: #1f2937;">{{ $loop->iteration + ($peran->currentPage() - 1) * $peran->perPage() }}</td>
                            <td style="padding: 15px; color: #1f2937; font-weight: 600;">{{ $item->nama }}</td>
                            <td style="padding: 15px; color: #6b7280; font-size: 14px;">
                                @if ($item->deskripsi)
                                    {{ substr($item->deskripsi, 0, 50) }}{{ strlen($item->deskripsi) > 50 ? '...' : '' }}
                                @else
                                    <span style="color: #d1d5db;">-</span>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                <span style="display: inline-block; padding: 8px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: rgba(14, 165, 233, 0.15); color: #0ea5e9;">
                                    {{ $item->pengguna()->count() }} pengguna
                                </span>
                            </td>
                            <td style="padding: 15px; color: #6b7280; font-size: 14px;">{{ $item->created_at->format('d M Y') }}</td>
                            <td style="padding: 15px;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.peran.show', $item->id) }}" style="padding: 8px 12px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.peran.edit', $item->id) }}" style="padding: 8px 12px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-delete-swal" data-action="{{ route('admin.peran.destroy', $item->id) }}" data-csrf="{{ csrf_token() }}" style="padding: 8px 12px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
                                <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                                <p style="margin: 10px 0 0 0;">Belum ada peran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $peran->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<style>
    a:hover, button:hover {
        opacity: 0.9;
    }
</style>
@endsection
