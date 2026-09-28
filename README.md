# Jobsheet 8 — Koneksi PostgreSQL (siap deploy ke Vercel)

Aplikasi PHP + PostgreSQL untuk mengelola data **senjata** dan **karakter**.

## Struktur
```
api/index.php      Front controller (satu-satunya fungsi serverless Vercel)
app/               Halaman PHP (index, senjata/, karakter/, includes/)
public/assets/     CSS & JS (dilayani statis oleh Vercel)
sql/               Skema database
vercel.json        Konfigurasi runtime PHP (vercel-php)
```

## Deploy ke Vercel
Vercel tidak punya PHP bawaan, jadi dipakai runtime komunitas `vercel-php`. Vercel juga tidak
menyediakan PostgreSQL lokal, jadi butuh database cloud (Neon, Supabase, dsb).

1. Buat database PostgreSQL gratis (mis. di neon.tech atau supabase.com), lalu salin connection string-nya.
2. Buka SQL Editor database tersebut dan jalankan isi `sql/database_kartu.sql`.
3. Push folder ini ke GitHub, lalu **Import Project** di Vercel (Framework Preset: *Other*, build command dikosongkan).
4. Di **Settings > Environment Variables** tambahkan:
   `DATABASE_URL = postgresql://USER:PASSWORD@HOST:5432/DBNAME?sslmode=require`
5. Deploy. Atau lewat CLI: `npm i -g vercel && vercel --prod`.

## Jalankan lokal
1. Pastikan PostgreSQL berjalan dan ekstensi `pdo_pgsql` aktif.
2. `createdb game_database` lalu `psql -d game_database -f sql/database_kartu.sql`
3. Jalankan:
   ```bash
   php -S localhost:8000 -t public api/index.php
   ```
   Tanpa `DATABASE_URL`, dipakai default `postgres:postgres@localhost:5432/game_database`
   (ubah di `app/includes/koneksi.php` bila perlu), atau set `DATABASE_URL` seperti di atas.

## Perubahan agar cocok untuk Vercel
- Aset dipindah ke `public/assets/`, halaman ke `app/`, dan semua request dirutekan lewat `api/index.php`
  (URL tetap sama: `/senjata/list.php`, atau tanpa `.php`).
- `koneksi.php` membaca `DATABASE_URL` (SSL otomatis untuk host non-lokal); pesan error tidak lagi membocorkan detail koneksi.
- Flash message pindah dari `$_SESSION` ke cookie singkat (`app/includes/helpers.php`), karena session file tidak
  bertahan antar-instance serverless.
- Output dibungkus `e()` (`htmlspecialchars`) agar input tidak bisa menyisipkan HTML/JS.
- Path CSS/JS kini absolut dari root domain (`/assets/...`).

## Catatan
- Query memakai prepared statement (`:nama_parameter`).
- Pilih region database yang dekat dengan region fungsi Vercel agar tidak lambat.
