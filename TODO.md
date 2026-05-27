# Task: Add Password Confirmation to Add/Edit Student Forms

## Steps:
- [ ] 1. Create TODO.md (done)
- [x] 2. Update addStudentForm.blade.php: add reenter_password field and JS validation
- [x] 3. Update StudentController.php store(): add 'password' => 'required|confirmed|min:8'
- [x] 4. Update editStudent.blade.php: add current_password, new_password, reenter_password fields and JS validation
- [x] 5. Update StudentController.php update(): handle optional password change with current validation, hash new if provided
- [x] 6. Add relation to Student model if needed: belongsTo UserAccounts (already present)
- [ ] 7. Test forms

Task completed. Test the forms at /student/create and /student/{id}/edit.
