<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccounts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:8|unique:user_accounts,username',
            'email' => 'required|email|unique:user_accounts,email',
            'password' => 'required|confirmed|min:8',
        ]);

        UserAccounts::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'is_active' => 1,
            'must_change_password' => true,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Teacher account is added.'
            ], 201);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Teacher account is added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function login(Request $request){
        if ($request->isMethod('get')) {
            if (Session::has('user')) {
                return redirect()->route('dashboard');
            }

            return view("loginPage");
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user_name = $request->input('username');
        $pass_word = $request->input('password');
        
        $user = UserAccounts::where('username', $user_name)->first();
        if($user && Hash::check($pass_word,$user->password)){
            session([
                'logged_id'=> $user->id,
                'logged_user'=> $user->username,
                'logged_role'=> strtolower($user->role),
                'must_change_password' => (bool) $user->must_change_password,
                ]);
            $request->session()->put('user', $user);

            if ($user->must_change_password && in_array(strtolower($user->role), ['student', 'teacher'])) {
                return redirect()->route('password.change');
            }

            return redirect()->route('dashboard');
        }
        else{
            // Clear login session so student page won't show previous username
            Session::forget('logged_id');
            Session::forget('logged_user');
            Session::forget('logged_role');
            Session::forget('must_change_password');
            Session::forget('user');

            return back()->withErrors(['username' => 'Wrong credentials. Try again.']);
        }
        }

    public function dashboard()
    {
        if (session('must_change_password')) {
            return redirect()->route('password.change');
        }

        return match (session('logged_role')) {
            'student' => redirect()->route('student.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect('/'),
        };
    }

    public function studentDashboard()
    {
        return view('dashboards.student', ['user' => session('logged_user')]);
    }

    public function teacherDashboard()
    {
        return view('dashboards.teacher', ['user' => session('logged_user')]);
    }

    public function adminDashboard()
    {
        return view('dashboards.admin', ['user' => session('logged_user')]);
    }

    public function createTeacher()
    {
        return view('addTeacherForm');
    }

    public function showChangePasswordForm()
    {
        return view('changePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = UserAccounts::find(session('logged_id'));

        if (! $user) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'User session was not found.'
                ], 404);
            }

            return redirect('/');
        }

        if (! Hash::check($request->current_password, $user->password)) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => [
                        'current_password' => ['Current password is incorrect.']
                    ]
                ], 422);
            }

            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'must_change_password' => false,
        ]);

        session(['must_change_password' => false]);
        $request->session()->put('user', $user->fresh());

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Password changed successfully.',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
    }

}
