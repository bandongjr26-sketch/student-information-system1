# TODO: Fix Email Column Error in Students

## Steps:
- [x] 1. Edit app/Http/Controllers/StudentController.php: Update email validation to use user_accounts table, fix typo, remove unnecessary assignments.
- [x] 2. Run `php artisan config:clear && php artisan cache:clear`
- [x] 3. Run `php artisan migrate` to complete pending migrations.
- [x] 4. Test student create/update forms with duplicate/new emails.
- [x] 5. Mark complete and cleanup TODO.
