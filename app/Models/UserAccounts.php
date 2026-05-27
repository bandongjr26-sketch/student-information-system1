<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccounts extends Model
{
    //
    protected $fillable = [
'username',
'email',
'password',
'role',
'is_active',
'must_change_password',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'user_account_id','id');
    }
}
