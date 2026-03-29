<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## FitTracker — Project README

This repository contains FitTracker, a small Laravel app for tracking calories, creating workouts and workout plans.

Status summary (mapped to your rubric):
- Functionality: core features implemented — authentication, calorie CRUD, workouts CRUD, browse/search, copy plans, in-page delete modal, custom exercise names.
- Code quality: structured and validated; controllers include validation rules; some UI polish and cleanup done.
- Missing / to improve: automated tests (Pest/PHPUnit), seeders/sample data, presentation slides and speaker notes, final dark-mode color polish, accessibility review, README (this file added), basic demo data and CI.

Quick run guide
1. Install dependencies:

```powershell
composer install
npm install
```

2. Configure environment:

```powershell
copy .env.example .env
php artisan key:generate
```

3. Database migrate (+ optional seeders once added):

```powershell
php artisan migrate
# php artisan db:seed
```

4. Start dev server and assets:

```powershell
php artisan serve
npm run dev
```

Helpful commands
- Clear compiled views: `php artisan view:clear`
- Clear cache/config: `php artisan cache:clear && php artisan config:clear`
- Run tests (not added yet): `./vendor/bin/pest`

Next suggested tasks (I can implement):
- Add sample seeders (`users`, `exercises`, `workouts`) so demo data is ready.
- Add basic Pest tests for core flows (auth, create workout, add calorie log).
- Finish dark-mode polish (tune card/input colors across views).
- Prepare presentation slides and speaker notes (I can generate a starter slide deck in Markdown or PowerPoint).
- Remove temporary debug scripts from `resources/views/layouts/app.blade.php`.

Tell me which of the suggested tasks you want me to start with and I will implement it.
