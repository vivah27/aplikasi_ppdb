<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'provider',
        'provider_id',
        'is_verified',
        'otp_code',
        'otp_expires_at',
        'nip',
        'no_hp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peran()
    {
        return $this->belongsToMany(Peran::class, 'peran_pengguna', 'pengguna_id', 'peran_id');
    }

    public function peranPengguna()
    {
        return $this->hasMany(PeRanPengguna::class, 'pengguna_id');
    }

    public function dokumenDibuat()
    {
        return $this->hasMany(Dokumen::class, 'dibuat_oleh');
    }

    public function dokumenDiperbaruiOleh()
    {
        return $this->hasMany(Dokumen::class, 'diperbarui_oleh');
    }

    public function verifikasiDibuat()
    {
        return $this->hasMany(Verifikasi::class, 'admin_id');
    }

    public function berkasCetakDibuat()
    {
        return $this->hasMany(BerkasCetak::class, 'dibuat_oleh');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'pengguna_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'pengguna_id');
    }

    /**
     * Check if user has a specific role.
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        return in_array($this->role, $roles);
    }
}
