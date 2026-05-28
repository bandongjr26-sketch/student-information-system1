<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\UserAccounts;
use App\Models\Degree;
use Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function displayHomePage() {
        return view('homePage');
    }

    public function displayStudentPage() {
        $studentN = [
            ['name' => 'Juan dela Cruz', 'age' => 19, 'course' => 'BSIT'],
            ['name' => 'Finning Garcia', 'age' => 21, 'course' => 'BSIT'],
            ['name' => 'Ron Razon', 'age' => 27, 'course' => 'BSIT'],
        ];

        return view('studentpage', compact('studentN'));
    }

    public function displayAboutUs() {
        return view('aboutUs');
    }

    public function index()
    {
        $students = Student::with(['userAccount', 'degree'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        $user = session('logged_user');

        return view('student')->with('students', $students)->with('user', $user);
    }

    public function accountIndex()
    {
        $studentAccountsQuery = UserAccounts::with(['student.degree'])
            ->where('role', 'student')
            ->orderBy('id', 'desc');

        $studentAccounts = $studentAccountsQuery->paginate(5);
        $studentsByEmail = Student::with('degree')
            ->whereIn('email', $studentAccounts->pluck('email')->filter())
            ->get()
            ->keyBy('email');
        $user = session('logged_user');

        return view('studentAccounts')
            ->with('studentAccounts', $studentAccounts)
            ->with('studentsByEmail', $studentsByEmail)
            ->with('user', $user);
    }

    public function showAccount(UserAccounts $studentAccount)
    {
        abort_unless(strtolower($studentAccount->role) === 'student', 404);

        return view('showStudentAccount')->with([
            'studentAccount' => $studentAccount,
            'student' => $this->studentForAccount($studentAccount),
        ]);
    }

    public function editAccount(UserAccounts $studentAccount)
    {
        abort_unless(strtolower($studentAccount->role) === 'student', 404);

        return view('editStudentAccount')->with([
            'studentAccount' => $studentAccount,
            'student' => $this->studentForAccount($studentAccount),
        ]);
    }

    public function updateAccount(Request $request, UserAccounts $studentAccount)
    {
        abort_unless(strtolower($studentAccount->role) === 'student', 404);

        $validated = $request->validate([
            'username' => 'required|min:8|unique:user_accounts,username,' . $studentAccount->id,
            'email' => 'required|email|unique:user_accounts,email,' . $studentAccount->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        $student = $this->studentForAccount($studentAccount);

        DB::transaction(function () use ($validated, $studentAccount, $student) {
            $studentAccount->username = $validated['username'];
            $studentAccount->email = $validated['email'];

            if (!empty($validated['password'])) {
                $studentAccount->password = Hash::make($validated['password']);
            }

            $studentAccount->save();

            if ($student) {
                $student->email = $validated['email'];
                $student->user_account_id = $studentAccount->id;
                $student->save();
            }
        });

        return redirect()->route('student-accounts.index');
    }

    public function destroyAccount(UserAccounts $studentAccount)
    {
        abort_unless(strtolower($studentAccount->role) === 'student', 404);

        $student = $this->studentForAccount($studentAccount);

        DB::transaction(function () use ($studentAccount, $student) {
            if ($student) {
                $student->delete();
            }

            $studentAccount->delete();
        });

        return redirect()->route('student-accounts.index');
    }

    public function create()
    {
         $degrees = Degree::all();
    return view('addStudentForm', compact('degrees'));
    }

    public function store(Request $request)
    {   
    $validated = $request->validate([
         'fname' => 'required|min:2',
         'mname' => 'nullable|string|max:255',
         'lname' => 'required|min:2',
         'email' => 'required|email|unique:user_accounts,email',
         'contactno' => 'required|digits:11',
         'degree_id' => 'required|exists:degrees,id',
         'username' => 'required|min:8',
         'password' => 'required|confirmed|min:8',
    ], [
        'contactno.required' => 'Contact number is required.',
        'contactno.digits' => 'Contact number must be exactly 11 digits.',
    ]);

    DB::transaction(function () use ($validated) {
        $user = UserAccounts::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'must_change_password' => true,
        ]);

        Student::create([
            'user_account_id' => $user->id,
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? null,
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'contactno' => $validated['contactno'],
            'degree_id' => $validated['degree_id']
        ]);
    });
    
    $msg = "Student is Added";
    Log::info($msg);
    Log::notice($msg);
    Log::alert($msg);
    Log::emergency($msg);
    Log::critical($msg);
    Log::error($msg);
    Log::warning($msg);

    if ($request->ajax()) {
        return response()->json([
            'message' => 'Student is Added'
        ], 201);
    }

    return redirect()->route('students.index');
    }

    public function show(string $id)
    {
        $student = Student::with(['userAccount', 'degree'])->findOrFail($id);
        return view('showStudent')->with("student",$student);
    }

    public function edit(string $id)
    {
         $student = Student::findOrFail($id);
         $degrees = Degree::all(); // get all degrees for the dropdown

        return view('editStudent', compact('student', 'degrees'));
    }

    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $rules = [
            'fname' => 'required|min:2',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|min:2',
            'email' => ['required','email','unique:user_accounts,email,' . $student->userAccount->id],
            'contactno' => 'required|digits:11',
            'degree_id' => 'required|exists:degrees,id'
        ];

        $passwordRules = [
            'current_password' => 'required_with:new_password',
            'new_password' => 'required_with:current_password|min:8|confirmed',
        ];

        $rules = array_merge($rules, $passwordRules);

        $validated = $request->validate($rules, [
            'current_password.required_with' => 'Current password is required when changing password.',
            'new_password.confirmed' => 'New passwords do not match.',
            'email.unique' => 'Email already exists.',
            'contactno.required' => 'Contact number is required.',
            'contactno.digits' => 'Contact number must be exactly 11 digits.'
        ]);

        // Update student details
        $student->fname = $validated['fname'];
        $student->mname = $request->filled('mname') ? $validated['mname'] : null;
        $student->lname = $validated['lname'];
        $student->email = $validated['email'];
        $student->contactno = $validated['contactno'];
        $student->degree_id = $validated['degree_id'];
        $student->save();
        $student->userAccount->update([
            'email' => $validated['email'],
        ]);

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $student->userAccount->password)) {
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => [
                            'current_password' => ['Current password is incorrect.']
                        ]
                    ], 422);
                }

                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $student->userAccount->update([
                'password' => Hash::make($validated['new_password'])
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Student updated successfully!'
            ]);
        }

        return redirect()->route('students.index');
    }

    public function destroy(string $id)
    {
        $student = Student::with('userAccount')->findOrFail($id);

        DB::transaction(function () use ($student) {
            $userAccount = $student->userAccount;

            $student->delete();

            if ($userAccount) {
                $userAccount->delete();
            }
        });

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Student deleted successfully!'
            ]);
        }

        return redirect()->route('students.index');
    }

    private function studentForAccount(UserAccounts $studentAccount): ?Student
    {
        return $studentAccount->student()
            ->with('degree')
            ->first()
            ?: Student::with('degree')->where('email', $studentAccount->email)->first();
    }

}
