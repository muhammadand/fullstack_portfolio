---
name: auto-register-migration-deploy
description: Mandatory rule to register every newly created database migration to the secret deploy trigger route in routes/web.php (/secret-deploy-trigger-12345).
category: backend
---

# Rule: Register Every Migration to Secret Deploy Trigger

## Core Requirement
Whenever any new database migration is added to this repository:
1. You **MUST** register the migration in [routes/web.php](file:///Users/muhammadandi/Project%20web/fullstack_portfolio/routes/web.php) inside the `Route::get('/secret-deploy-trigger-12345', ...)` closure.
2. The endpoint executes individual migrations with `--path` and `--force => true` for deployment on shared/cPanel hosting where SSH terminal is unavailable.

## Syntax
```php
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/<MIGRATION_FILENAME>.php',
            '--force' => true
        ]);
```

Never skip this step, otherwise the remote production database will not have the new tables/columns upon deployment.
