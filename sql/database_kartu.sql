-- Jobsheet 8: skema database game (PostgreSQL)
-- Jalankan di database Anda (lokal: psql -d game_database -f sql/database_kartu.sql;
-- cloud: tempel di SQL Editor Neon/Supabase).


CREATE TABLE IF NOT EXISTS senjata (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi VARCHAR(255) NOT NULL,
    kerusakan INTEGER NOT NULL DEFAULT 0,
    durabilitas INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS karakter (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nyawa INTEGER NOT NULL DEFAULT 0,
    perlindungan INTEGER NOT NULL DEFAULT 0
);
