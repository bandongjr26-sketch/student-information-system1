<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function userProfile(){
        $user= User::find(1);
        echo $user->name." - ".$user->profile->bio;
    }

    public function userPosts(){
        $user = User::find(1);
        foreach($user->posts as $post){
            echo "$user->name: $post->title".$post->content."<br>";
        }
    }

    public function studentCourses(){
        $student = Student::find(1);
        foreach($student->courses as $course){
            echo "$student->fname $student->lname is enrolled in: $course->course_name<br>";
        }
    }

    public function maintenance(){
        return view('maintenance');
    }
}
