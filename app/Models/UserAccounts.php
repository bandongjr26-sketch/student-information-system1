<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // 👈 extend Authenticatable for login
use Illuminate\Notifications\Notifiable;

class UserAccounts extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_accounts'; // 👈 explicitly set table name

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_account_id', 'id');
    }
}
