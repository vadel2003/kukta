<?php

/*
|--------------------------------------------------------------------------
| Magyar validációs üzenetek
|--------------------------------------------------------------------------
|
| A Laravel beépített angol üzeneteinek (vendor/laravel/framework/src/
| Illuminate/Translation/lang/en/validation.php) magyar fordítása, ugyanazokkal
| a kulcsokkal. Az APP_LOCALE=hu (.env) miatt a Laravel automatikusan ezt a
| fájlt használja. A :attribute helyére a lenti 'attributes' tömbből kerül a
| mező magyar neve (pl. "email" -> "email cím").
|
| "A(z)": a névelőt nem tudjuk előre (a vagy az), mert a mező neve változik.
|
*/

return [

    'accepted' => 'A(z) :attribute elfogadása kötelező.',
    'accepted_if' => 'A(z) :attribute elfogadása kötelező, ha a(z) :other értéke :value.',
    'active_url' => 'A(z) :attribute nem érvényes URL.',
    'after' => 'A(z) :attribute csak :date utáni dátum lehet.',
    'after_or_equal' => 'A(z) :attribute csak :date vagy annál későbbi dátum lehet.',
    'alpha' => 'A(z) :attribute csak betűket tartalmazhat.',
    'alpha_dash' => 'A(z) :attribute csak betűket, számokat, kötőjelet és alulvonást tartalmazhat.',
    'alpha_num' => 'A(z) :attribute csak betűket és számokat tartalmazhat.',
    'any_of' => 'A(z) :attribute érvénytelen.',
    'array' => 'A(z) :attribute csak lista lehet.',
    'ascii' => 'A(z) :attribute csak egybájtos betűket, számokat és jeleket tartalmazhat.',
    'before' => 'A(z) :attribute csak :date előtti dátum lehet.',
    'before_or_equal' => 'A(z) :attribute csak :date vagy annál korábbi dátum lehet.',
    'between' => [
        'array' => 'A(z) :attribute :min és :max közötti elemet tartalmazhat.',
        'file' => 'A(z) :attribute mérete :min és :max kilobájt között lehet.',
        'numeric' => 'A(z) :attribute értéke :min és :max között lehet.',
        'string' => 'A(z) :attribute hossza :min és :max karakter között lehet.',
    ],
    'boolean' => 'A(z) :attribute értéke csak igaz vagy hamis lehet.',
    'can' => 'A(z) :attribute nem engedélyezett értéket tartalmaz.',
    'confirmed' => 'A(z) :attribute megerősítése nem egyezik.',
    'contains' => 'A(z) :attribute egy kötelező értéket nem tartalmaz.',
    'current_password' => 'A jelszó nem megfelelő.',
    'date' => 'A(z) :attribute nem érvényes dátum.',
    'date_equals' => 'A(z) :attribute csak :date dátum lehet.',
    'date_format' => 'A(z) :attribute nem felel meg a(z) :format formátumnak.',
    'decimal' => 'A(z) :attribute értékének :decimal tizedesjegyet kell tartalmaznia.',
    'declined' => 'A(z) :attribute elutasítása kötelező.',
    'declined_if' => 'A(z) :attribute elutasítása kötelező, ha a(z) :other értéke :value.',
    'different' => 'A(z) :attribute és a(z) :other nem lehet azonos.',
    'digits' => 'A(z) :attribute :digits számjegyből kell álljon.',
    'digits_between' => 'A(z) :attribute :min és :max közötti számjegyből kell álljon.',
    'dimensions' => 'A(z) :attribute képmérete nem megfelelő.',
    'distinct' => 'A(z) :attribute értéke ismétlődik.',
    'doesnt_contain' => 'A(z) :attribute nem tartalmazhatja a következőket: :values.',
    'doesnt_end_with' => 'A(z) :attribute nem végződhet a következők egyikével: :values.',
    'doesnt_start_with' => 'A(z) :attribute nem kezdődhet a következők egyikével: :values.',
    'email' => 'A(z) :attribute nem érvényes email cím.',
    'encoding' => 'A(z) :attribute kódolása csak :encoding lehet.',
    'ends_with' => 'A(z) :attribute a következők egyikével kell végződjön: :values.',
    'enum' => 'A kiválasztott :attribute érvénytelen.',
    'exists' => 'A kiválasztott :attribute érvénytelen.',
    'extensions' => 'A(z) :attribute kiterjesztése a következők egyike kell legyen: :values.',
    'file' => 'A(z) :attribute csak fájl lehet.',
    'filled' => 'A(z) :attribute nem lehet üres.',
    'gt' => [
        'array' => 'A(z) :attribute több mint :value elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute mérete nagyobb kell legyen, mint :value kilobájt.',
        'numeric' => 'A(z) :attribute értéke nagyobb kell legyen, mint :value.',
        'string' => 'A(z) :attribute hosszabb kell legyen, mint :value karakter.',
    ],
    'gte' => [
        'array' => 'A(z) :attribute legalább :value elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute mérete legalább :value kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute értéke legalább :value kell legyen.',
        'string' => 'A(z) :attribute legalább :value karakter hosszú kell legyen.',
    ],
    'hex_color' => 'A(z) :attribute nem érvényes hexadecimális szín.',
    'image' => 'A(z) :attribute csak kép lehet.',
    'in' => 'A kiválasztott :attribute érvénytelen.',
    'in_array' => 'A(z) :attribute értéke nem szerepel a következőben: :other.',
    'in_array_keys' => 'A(z) :attribute a következő kulcsok közül legalább egyet tartalmazzon: :values.',
    'integer' => 'A(z) :attribute csak egész szám lehet.',
    'ip' => 'A(z) :attribute nem érvényes IP-cím.',
    'ipv4' => 'A(z) :attribute nem érvényes IPv4-cím.',
    'ipv6' => 'A(z) :attribute nem érvényes IPv6-cím.',
    'json' => 'A(z) :attribute nem érvényes JSON szöveg.',
    'list' => 'A(z) :attribute csak lista lehet.',
    'lowercase' => 'A(z) :attribute csak kisbetűs lehet.',
    'lt' => [
        'array' => 'A(z) :attribute kevesebb mint :value elemet tartalmazhat.',
        'file' => 'A(z) :attribute mérete kisebb kell legyen, mint :value kilobájt.',
        'numeric' => 'A(z) :attribute értéke kisebb kell legyen, mint :value.',
        'string' => 'A(z) :attribute rövidebb kell legyen, mint :value karakter.',
    ],
    'lte' => [
        'array' => 'A(z) :attribute legfeljebb :value elemet tartalmazhat.',
        'file' => 'A(z) :attribute mérete legfeljebb :value kilobájt lehet.',
        'numeric' => 'A(z) :attribute értéke legfeljebb :value lehet.',
        'string' => 'A(z) :attribute legfeljebb :value karakter hosszú lehet.',
    ],
    'mac_address' => 'A(z) :attribute nem érvényes MAC-cím.',
    'max' => [
        'array' => 'A(z) :attribute legfeljebb :max elemet tartalmazhat.',
        'file' => 'A(z) :attribute mérete legfeljebb :max kilobájt lehet.',
        'numeric' => 'A(z) :attribute értéke legfeljebb :max lehet.',
        'string' => 'A(z) :attribute legfeljebb :max karakter hosszú lehet.',
    ],
    'max_digits' => 'A(z) :attribute legfeljebb :max számjegyből állhat.',
    'mimes' => 'A(z) :attribute csak a következő típusú fájl lehet: :values.',
    'mimetypes' => 'A(z) :attribute csak a következő típusú fájl lehet: :values.',
    'min' => [
        'array' => 'A(z) :attribute legalább :min elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute mérete legalább :min kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute értéke legalább :min kell legyen.',
        'string' => 'A(z) :attribute legalább :min karakter hosszú kell legyen.',
    ],
    'min_digits' => 'A(z) :attribute legalább :min számjegyből kell álljon.',
    'missing' => 'A(z) :attribute nem szerepelhet.',
    'missing_if' => 'A(z) :attribute nem szerepelhet, ha a(z) :other értéke :value.',
    'missing_unless' => 'A(z) :attribute nem szerepelhet, kivéve ha a(z) :other értéke :value.',
    'missing_with' => 'A(z) :attribute nem szerepelhet, ha a(z) :values meg van adva.',
    'missing_with_all' => 'A(z) :attribute nem szerepelhet, ha a(z) :values meg vannak adva.',
    'multiple_of' => 'A(z) :attribute értéke :value többszöröse kell legyen.',
    'not_in' => 'A kiválasztott :attribute érvénytelen.',
    'not_regex' => 'A(z) :attribute formátuma érvénytelen.',
    'numeric' => 'A(z) :attribute csak szám lehet.',
    'password' => [
        'letters' => 'A(z) :attribute legalább egy betűt kell tartalmazzon.',
        'mixed' => 'A(z) :attribute legalább egy kis- és egy nagybetűt kell tartalmazzon.',
        'numbers' => 'A(z) :attribute legalább egy számot kell tartalmazzon.',
        'symbols' => 'A(z) :attribute legalább egy speciális karaktert kell tartalmazzon.',
        'uncompromised' => 'A megadott :attribute szerepelt egy adatszivárgásban. Kérjük, válassz másikat.',
    ],
    'present' => 'A(z) :attribute mezőnek szerepelnie kell.',
    'present_if' => 'A(z) :attribute mezőnek szerepelnie kell, ha a(z) :other értéke :value.',
    'present_unless' => 'A(z) :attribute mezőnek szerepelnie kell, kivéve ha a(z) :other értéke :value.',
    'present_with' => 'A(z) :attribute mezőnek szerepelnie kell, ha a(z) :values meg van adva.',
    'present_with_all' => 'A(z) :attribute mezőnek szerepelnie kell, ha a(z) :values meg vannak adva.',
    'prohibited' => 'A(z) :attribute nem adható meg.',
    'prohibited_if' => 'A(z) :attribute nem adható meg, ha a(z) :other értéke :value.',
    'prohibited_if_accepted' => 'A(z) :attribute nem adható meg, ha a(z) :other el van fogadva.',
    'prohibited_if_declined' => 'A(z) :attribute nem adható meg, ha a(z) :other el van utasítva.',
    'prohibited_unless' => 'A(z) :attribute nem adható meg, kivéve ha a(z) :other értéke: :values.',
    'prohibits' => 'Ha a(z) :attribute meg van adva, a(z) :other nem adható meg.',
    'regex' => 'A(z) :attribute formátuma érvénytelen.',
    'required' => 'A(z) :attribute megadása kötelező.',
    'required_array_keys' => 'A(z) :attribute a következőket kell tartalmazza: :values.',
    'required_if' => 'A(z) :attribute megadása kötelező, ha a(z) :other értéke :value.',
    'required_if_accepted' => 'A(z) :attribute megadása kötelező, ha a(z) :other el van fogadva.',
    'required_if_declined' => 'A(z) :attribute megadása kötelező, ha a(z) :other el van utasítva.',
    'required_unless' => 'A(z) :attribute megadása kötelező, kivéve ha a(z) :other értéke: :values.',
    'required_with' => 'A(z) :attribute megadása kötelező, ha a(z) :values meg van adva.',
    'required_with_all' => 'A(z) :attribute megadása kötelező, ha a(z) :values meg vannak adva.',
    'required_without' => 'A(z) :attribute megadása kötelező, ha a(z) :values nincs megadva.',
    'required_without_all' => 'A(z) :attribute megadása kötelező, ha a(z) :values egyike sincs megadva.',
    'same' => 'A(z) :attribute és a(z) :other egyezzen meg.',
    'size' => [
        'array' => 'A(z) :attribute pontosan :size elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute mérete pontosan :size kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute értéke pontosan :size kell legyen.',
        'string' => 'A(z) :attribute pontosan :size karakter hosszú kell legyen.',
    ],
    'starts_with' => 'A(z) :attribute a következők egyikével kell kezdődjön: :values.',
    'string' => 'A(z) :attribute csak szöveg lehet.',
    'timezone' => 'A(z) :attribute nem érvényes időzóna.',
    'unique' => 'Ez a(z) :attribute már foglalt.',
    'uploaded' => 'A(z) :attribute feltöltése nem sikerült.',
    'uppercase' => 'A(z) :attribute csak nagybetűs lehet.',
    'url' => 'A(z) :attribute nem érvényes URL.',
    'ulid' => 'A(z) :attribute nem érvényes ULID.',
    'uuid' => 'A(z) :attribute nem érvényes UUID.',

    /*
    | Egyedi üzenetek adott mező + szabály párosra ("mezőnév.szabály")
    */

    'custom' => [
        'terms' => [
            'required' => 'A regisztrációhoz el kell fogadnod az Adatkezelési tájékoztatót és az ÁSZF-et.',
            'accepted' => 'A regisztrációhoz el kell fogadnod az Adatkezelési tájékoztatót és az ÁSZF-et.',
        ],
    ],

    /*
    | A mezők (input name-ek) magyar neve - ez kerül a :attribute helyére.
    | A "*" bármelyik sorszámot jelenti (pl. steps.0.description, steps.1.description).
    */

    'attributes' => [
        // Regisztráció, bejelentkezés, profil
        'name' => 'felhasználónév',
        'email' => 'email cím',
        'password' => 'jelszó',
        'password_confirmation' => 'jelszó megerősítése',
        'current_password' => 'jelenlegi jelszó',
        'new_password' => 'új jelszó',
        'avatar' => 'profilkép',
        'terms' => 'feltételek',

        // Recept űrlap
        'title' => 'recept címe',
        'description' => 'leírás',
        'prep_time' => 'elkészítési idő',
        'difficulty' => 'nehézség',
        'servings' => 'adag',
        'thumbnail_image' => 'kép',
        'default_image' => 'alapkép',
        'steps' => 'lépések',
        'steps.*.description' => 'lépés leírása',
        'steps.*.step_category_id' => 'lépés kategóriája',
        'ingredients' => 'alapanyagok',
        'ingredients.*.name' => 'alapanyag neve',
        'ingredients.*.quantity' => 'mennyiség',
        'ingredients.*.unit' => 'mértékegység',
        'meal_times' => 'étkezés',
        'meal_times.*' => 'étkezés',
        'food_types' => 'ételtípus',
        'food_types.*' => 'ételtípus',
        'diet' => 'diéta',
        'allergen_free' => 'mentesség',
        'allergen_free.*' => 'mentesség',
        'cuisines' => 'konyha',
        'cuisines.*' => 'konyha',

        // Admin: alapanyagok
        'calories' => 'kalória',
        'carbohydrate' => 'szénhidrát',
        'protein' => 'fehérje',
        'fat' => 'zsír',
        'ids' => 'kijelölt elemek',
    ],

];
