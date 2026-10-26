---
name: auto-register-migration-deploy
description: Standard workflow and requirement to register every newly created database migration to the secret deploy trigger route in routes/web.php (/secret-deploy-trigger-12345).
category: backend
---

# Auto Register Migration Deploy

In this project, remote production deployment is triggered automatically via GitHub Actions / Webhook without SSH access by hitting the endpoint:
`GET /secret-deploy-trigger-12345` defined in [routes/web.php](file:///Users/muhammadandi/Project%20web/fullstack_portfolio/routes/web.php).

## Mandatory Rule

**EVERY TIME** a new migration is created or generated in `database/migrations/`:
You **MUST** immediately append that migration file path to the list of `Artisan::call('migrate', ...)` calls inside `Route::get('/secret-deploy-trigger-12345', ...)` in [routes/web.php](file:///Users/muhammadandi/Project%20web/fullstack_portfolio/routes/web.php).

## Implementation Pattern

In [routes/web.php](file:///Users/muhammadandi/Project%20web/fullstack_portfolio/routes/web.php), locate the `Route::get('/secret-deploy-trigger-12345', ...)` block (around line 403-515).

Add the new migration right before the `// Jalankan Seeder yang diperlukan` section:

```php
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/<YYYY_MM_DD_HHMMSS_name_of_migration>.php',
            '--force' => true
        ]);
```

### Example

When you create `database/migrations/2026_10_26_133318_create_google_card_visits_table.php`:

```php
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/2026_10_26_133318_create_google_card_visits_table.php',
            '--force' => true
        ]);
```

## Checklist for Every Migration Task
1. [ ] Generate or write migration in `database/migrations/`.
2. [ ] Run `php artisan migrate` locally to test.
3. [ ] Register migration in [routes/web.php](file:///Users/muhammadandi/Project%20web/fullstack_portfolio/routes/web.php) under `/secret-deploy-trigger-12345`.
4. [ ] If the migration requires seeding, register the seeder call in the same endpoint.
