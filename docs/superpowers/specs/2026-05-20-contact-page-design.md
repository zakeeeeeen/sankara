# Spesifikasi: Halaman Kontak + Map + Admin Settings

## Tujuan

Membuat halaman publik `/kontak` dengan layout seperti referensi (info kontak + form), dilengkapi map Google (embed), dan seluruh isinya bisa diatur dari admin. Pengiriman pesan kontak mendukung:

- A) Simpan ke database
- B) Kirim email ke inbox admin (email tujuan bisa diubah via admin)
- C) Arahkan user untuk lanjut chat via WhatsApp (nomor bisa diubah via admin)

## Ruang Lingkup

### Frontend (Publik)

- Halaman baru: `/kontak`
- Layout:
  - Kolom kiri: judul + deskripsi singkat + daftar informasi (alamat, email, phone/WA, jam operasional)
  - Kolom kanan: form kirim pesan (Nama, Email, No Telp, Pesan)
  - Di bawah: iframe map (Google Maps embed)
- Setelah submit sukses:
  - tampil notifikasi sukses
  - tersedia tombol “Lanjut via WhatsApp” (buka `wa.me` dengan pesan auto-fill)

### Backend

- Penyimpanan pesan ke DB: tabel `contact_messages`
- Email: kirim ke inbox email yang diatur admin
- Admin dashboard:
  - pengaturan kontak tambahan:
    - `contact[inbox_email]` (default awal: `zakinbesar@gmail.com`)
    - `contact[map_embed_url]` (Google Maps embed URL)
  - menu “Pesan Kontak” (list, detail, hapus)

## Data Model

### Site Settings (`site_settings`)

Tetap memakai tabel key-value existing `site_settings`, dengan key:

- `contact` (JSON)
  - `email` (email publik yang tampil)
  - `whatsapp` (nomor WA publik; default awal: `0859183931050`)
  - `address` (alamat kantor)
  - `hours` (jam operasional)
  - `inbox_email` (tujuan email dari form)
  - `map_embed_url` (google maps embed url)

### Contact Messages (`contact_messages`)

Kolom minimal:

- `id`
- `name` (string)
- `email` (string)
- `phone` (string, nullable)
- `message` (text)
- `ip_address` (string, nullable)
- `user_agent` (text, nullable)
- `created_at`, `updated_at`

## Routing

- Publik:
  - `GET /kontak` → `ContactController@show` (render halaman)
  - `POST /kontak` → `ContactController@store` (proses submit)
- Admin:
  - `GET /admin/contact-messages` → list pesan
  - `GET /admin/contact-messages/{message}` → detail pesan
  - `DELETE /admin/contact-messages/{message}` → hapus pesan

## Validasi

### Form Kontak

- `name`: required, string, max 255
- `email`: required, email, max 255
- `phone`: nullable, string, max 32 (disanitasi ringan: trim)
- `message`: required, string

### Map Embed URL (Admin)

- `contact[map_embed_url]`: nullable, URL
- Restriksi keamanan: hanya mengizinkan host/path untuk embed Google Maps:
  - host harus `www.google.com`
  - path harus diawali `/maps/embed`

## Perilaku Email

- Menggunakan Laravel Mail (`Mail::to(...)->send(...)`)
- Jika kirim email gagal:
  - pesan tetap tersimpan di DB
  - user tetap mendapat status sukses (tanpa stack trace/teknis)

## WhatsApp Deep Link

- Nomor sumber: `site_settings.contact.whatsapp`
- Normalisasi nomor untuk `wa.me`:
  - hapus spasi dan simbol non-digit
  - jika mulai `0`, ubah jadi `62` (Indonesia)
- Pesan auto-fill:
  - format ringkas: nama, email, telp (jika ada), dan ringkasan pesan

## Tampilan Admin

### Home Settings (kontak)

Tambahkan input:

- Inbox Email (tujuan email pesan masuk)
- Google Maps Embed URL

### Pesan Kontak

- Tabel list pesan: nama, email, telp, tanggal
- Halaman detail: tampilkan semua field + tombol hapus

## Seeder Default

Tambahkan default:

- `contact[inbox_email] = zakinbesar@gmail.com`
- `contact[whatsapp] = 0859183931050` (jika belum ada)

## Kriteria Selesai

- `/kontak` tampil sesuai layout referensi + map embed
- Pengaturan (info kontak, inbox email, map embed url, WA) bisa diubah via admin
- Submit form:
  - tersimpan di DB
  - email terkirim ke inbox email admin
  - user dapat tombol lanjut WA yang berfungsi

