<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authentication
{
    use HasFactory;

    // sanctum
    use HasApiTokens;

    // permissions
    use HasRoles;

    protected $hidden = [
        'password',
    ];

    protected $guarded = [
        'id',
        'uuid',
        'password'
    ];

    /**
     * Password field
     *
     * @return Attribute
     */
    public function password(): Attribute
    {
        return new Attribute(
            set: fn($value) => Hash::make($value),
        );
    }
}
