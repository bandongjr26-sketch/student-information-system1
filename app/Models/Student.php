<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contactno',
        'degree_id',
        'user_account_id',

    ];




    public function courses(){
        return $this->belongsToMany(Course::class, 'course__students', 'student_id', 'course_id');
    }

    // RELATIONSHIP
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
    public function userAccount(){
        return $this->belongsTo(UserAccounts::class,'user_account_id');
    }
}
