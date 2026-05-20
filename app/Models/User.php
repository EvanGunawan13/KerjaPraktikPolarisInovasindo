<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function isKepala(): bool
    {
        return $this->role === 'kepala_cabang';
    }

    public function isGudang(): bool
    {
        return $this->role === 'gudang';
    }

    public function isPembukuan(): bool
    {
        return $this->role === 'pembukuan';
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'kepala_cabang' => 'Kepala Cabang',
            'gudang'        => 'Bagian Gudang',
            'pembukuan'     => 'Bagian Pembukuan',
            default         => 'Unknown',
        };
    }
}