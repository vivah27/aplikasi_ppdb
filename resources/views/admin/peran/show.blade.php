@extends('layouts.master')

@section('page_title', 'Detail Peran')

@section('content')
<div style="max-width: 100%;">
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0; color: #1f2937; font-weight: 700;">{{ $peran->nama }}</h3>
            <p style="margin: 8px 0 0 0; color: #6b7280; font-size: 14px;">{{ $peran->deskripsi ?? 'Tanpa deskripsi' }}</p>
        </div>
        <a href="{{ route('admin.peran.edit', $peran->id) }}" style="padding: 12px 24px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>

    <!-- Info Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="padding: 15px; background: #f9fafb; border-radius: 8px; border-left: 4px solid #4f46e5;">
                <p style="margin: 0; color: #6b7280; font-size: 13px; text-transform: uppercase; font-weight: 600;">Dibuat</p>
                <p style="margin: 8px 0 0 0; color: #1f2937; font-weight: 600;">{{ $peran->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div style="padding: 15px; background: #f9fafb; border-radius: 8px; border-left: 4px solid #10b981;">
                <p style="margin: 0; color: #6b7280; font-size: 13px; text-transform: uppercase; font-weight: 600;">Diupdate</p>
                <p style="margin: 8px 0 0 0; color: #1f2937; font-weight: 600;">{{ $peran->updated_at->format('d M Y, H:i') }}</p>
            </div>
            <div style="padding: 15px; background: #f9fafb; border-radius: 8px; border-left: 4px solid #0ea5e9;">
                <p style="margin: 0; color: #6b7280; font-size: 13px; text-transform: uppercase; font-weight: 600;">Total Pengguna</p>
                <p style="margin: 8px 0 0 0; color: #1f2937; font-weight: 600; font-size: 24px;">{{ $peran->pengguna()->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Pengguna dengan Peran Section -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
            <h4 style="margin: 0; color: #1f2937; font-weight: 700;">Pengguna dengan Peran {{ $peran->nama }}</h4>
        </div>
        <div style="overflow-x: auto;">
            @if ($peran->pengguna->count() > 0)
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">No</th>
                            <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Nama</th>
                            <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Email</th>
                            <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">NIP</th>
                            <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peran->pengguna as $user)
                            <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                                <td style="padding: 15px; color: #1f2937;">{{ $loop->iteration }}</td>
                                <td style="padding: 15px; color: #1f2937; font-weight: 600;">{{ $user->name }}</td>
                                <td style="padding: 15px; color: #6b7280;">{{ $user->email }}</td>
                                <td style="padding: 15px; color: #6b7280;">{{ $user->nip ?? '-' }}</td>
                                <td style="padding: 15px; color: #6b7280; font-size: 14px;">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 40px; text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 15px; opacity: 0.3;">👥</div>
                    <p style="color: #6b7280; margin: 0;">Belum ada pengguna dengan peran ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div style="margin-top: 30px;">
        <a href="{{ route('admin.peran.index') }}" style="padding: 12px 24px; background: #6b7280; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
