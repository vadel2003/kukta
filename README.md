# Kukta

Receptmegosztó webalkalmazás Laravelben. A felhasználók recepteket tölthetnek fel, kereshetnek és szűrhetnek, kedvencnek jelölhetik és értékelhetik őket, a Kukta asszisztens pedig lépésről lépésre végigvezet a főzésen.

## Követelmények

- PHP 8.3+
- Composer
- MySQL (pl. XAMPP)

## Telepítés

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

Előtte hozd létre a `kukta` adatbázist a MySQL-ben.

## Teszt felhasználók

A seeder által létrehozott fiókok jelszava: `jelszo123`.

- Szuperadmin: `admin@kukta.hu`
- Felhasználó: pl. `nagy.anna@gmail.com`
