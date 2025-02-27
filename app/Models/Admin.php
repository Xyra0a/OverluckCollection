<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin'; // Pastikan tabelnya benar

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Gunakan canAccessPanel(), bukan canAccessFilament()
    public function canAccessPanel(): bool
    {
        return true; // Ubah sesuai logika akses admin
    }
}
