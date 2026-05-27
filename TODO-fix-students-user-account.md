# Fix Students Table - Add user_account_id to 'strudents' table

## Current Status
Migration partially ran but hit migrations table length error.

## Steps:
- [x] 1. \`php artisan migrate\` (partial: mname nullable ran, error on extend_migrations_table)
- [ ] 1b. Fix migrations table length (rename migration file temporarily)
- [ ] 1c. Complete pending migrations (user_accounts created)
- [ ] 2. Create new migration: add_user_account_id_to_strudents_table (target 'strudents')
- [ ] 3. Update app/Models/Student.php (add belongsTo UserAccounts)
- [ ] 4. php artisan migrate
- [ ] 5. Verify schema
- [ ] 6. Complete

## Next Action for Step 1b
Execute: mv database/migrations/2026_04_07_070005_extend_migrations_table.php database/migrations/xxxx_extend_migrations_table.php (short name)
then php artisan migrate

