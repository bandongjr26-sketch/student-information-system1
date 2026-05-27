<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\UserController;

Route::resource('degrees', DegreeController::class);


Route::get('/greetings',[StudentController::class, 'displayHomePage']);

     Route::get('/homePage',[StudentController::class, 'displayHomePage']);
Route::get('/studentpage',[StudentController::class, 'displayStudentPage']);
     Route::get('/aboutUs',[StudentController::class, 'displayAboutUs']);

    

Route::match(['get', 'post'], '/', [UserController::class, 'login'])->Middleware('maintenance');

Route::middleware('sessionUserMW')->group(function () {
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/student/dashboard', [UserController::class, 'studentDashboard'])->middleware('sessionUserMW:student')->name('student.dashboard');
    Route::get('/teacher/dashboard', [UserController::class, 'teacherDashboard'])->middleware('sessionUserMW:teacher')->name('teacher.dashboard');

    Route::middleware('sessionUserMW:admin')->group(function () {
        Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::resource('students', StudentController::class);
        Route::get('/teachers/create', [UserController::class, 'createTeacher'])->name('teachers.create');
        Route::post('/teachers', [UserController::class, 'store'])->name('teachers.store');
    });
});


// 
    //  Route::get('/greetings', function () {
    //   return view('welcome');
    // });

    // Route::get('/about',[pagesController::class, 'about'] );

    

    Route::middleware('groupMiddleware')->group(function(){
  Route::get('/user_profile',[PagesController::class, 'userProfile'] );
    Route::get('/user_posts',[PagesController::class, 'userPosts'] );
    Route::get('/student_courses',[PagesController::class, 'studentCourses'] );
    });


    // Route::get('/add',[CalculatorController::class, 'add'] );
    // Route::get('/subtract',[CalculatorController::class, 'subtract'] );
    // Route::get('/divide',[CalculatorController::class, 'divide'] );
    // Route::get('/multi',[CalculatorController::class, 'multi'] );
    // Route::get('/modulo',[CalculatorController::class, 'modulo'] );




    // Logout: clear session so back button can't restore protected pages
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        $request->session()->flush();
        return redirect('/');
    })->name('logout');


Route::get('/maintenance',[PagesController::class, 'maintenance'] );

    
// 
    // Route::get('/modulo',[CalculatorController::class, 'modulo'] );

    // Route::get('/welcome',[PSUController::class, 'welcome'] )->name("welcome");
    // Route::get('/mission',[PSUController::class, 'mission'] )->name("mission");
    // Route::get('/vision',[PSUController::class, 'vision'] )->name("vision");
    // Route::get('/oems',[PSUController::class, 'oems'] )->name("oems");

    // Route::get('/students/{name}/{course}',[PSUController::class, 'students'] )->name("students");

    // Route::resource('/students',StudentController::class);
    
    
