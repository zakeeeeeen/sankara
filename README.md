<p align="center">
  <img src="public/logo.png" width="120" height="120" alt="Sankara Tech Logo">
</p>

<h1 align="center">Sankara Tech — Digital Agency & Software House CMS</h1>

<p align="center">
  Platform website agensi digital modern berkinerja tinggi, dibangun dengan <strong>Laravel 13</strong>, <strong>Livewire 4</strong>, <strong>Tailwind CSS v4</strong>, arsitektur <strong>Domain Service Layer</strong>, dan optimasi <strong>Google PageSpeed Insights > 95</strong>.
</p>

<p align="center">
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.4%20%7C%208.5-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version"></a>
  <a href="https://livewire.laravel.com"><img src="https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire Version"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://docker.com"><img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Ready"></a>
  <a href="#"><img src="https://img.shields.io/badge/Tests-27%20Passed%20(100%25)-success?style=for-the-badge&logo=phpunit&logoColor=white" alt="Tests Passed"></a>
  <a href="#"><img src="https://img.shields.io/badge/PageSpeed-95%2B%20Ready-34A853?style=for-the-badge&logo=google&logoColor=white" alt="Google PageSpeed"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="License"></a>
</p>

---

## 📑 Daftar Isi

- [✨ Fitur Utama](#-fitur-utama)
- [🏛️ Arsitektur Sistem](#️-arsitektur-sistem)
- [⚡ Optimasi Performa & Keamanan](#-optimasi-performa--keamanan)
- [💻 Panduan Instalasi Lokal](#-panduan-instalasi-lokal)
- [🚀 Panduan Deployment Siap Produksi](#-panduan-deployment-siap-produksi)
  - [1. Deploy dengan Docker & Docker Compose](#1-deploy-dengan-docker--docker-compose)
  - [2. Deploy di Coolify (PaaS / VPS)](#2-deploy-di-coolify-paas--vps)
  - [3. Deploy di Native Linux VPS (Nginx + PHP-FPM + Supervisor)](#3-deploy-di-native-linux-vps-nginx--php-fpm--supervisor)
  - [4. Deploy di Shared Hosting (cPanel / DirectAdmin)](#4-deploy-di-shared-hosting-cpanel--directadmin)
  - [5. Deploy di Cloud Hosting (Render, Railway, Fly.io, Laravel Cloud)](#5-deploy-di-cloud-hosting)
- [🧪 Testing & Standarisasi Kode](#-testing--standarisasi-kode)
- [🔐 Akun Default Administrator](#-akun-default-administrator)

---

## ✨ Fitur Utama

- ⚡ **Full Livewire Single-Page Experience:** Navigasi secepat kilat dengan `wire:navigate`, reactive state, real-time validation, dan tanpa reload halaman.
- 🏢 **Domain Service Layer:** Seluruh business logic & database query terisolasi rapi pada Service Classes terpisah (`ContactService`, `HomeService`, `PortfolioService`, `ServiceService`, `SiteSettingService`, dll).
- 🗂️ **Admin Management Workspace:**
  - **Dashboard Analytics & Quick Actions**
  - **Homepage Content Manager** (Hero, Stats counter, Who we are, Keunggulan, CTA)
  - **Services CRUD** (Fitur dinamis, slug, ilustrasi, relasi kategori portofolio)
  - **Portfolios Showcase CRUD** (Filter kategori dinamis, section fitur, multiple upload mockup)
  - **Portfolio Categories CRUD** (Modal interaktif tanpa refresh)
  - **Pricing Plans & Benefit Tiers** (Tag populer, checklist fitur dinamis)
  - **About Page Editor** (Hero, profil perusahaan, gambar)
  - **Global Site Settings, SEO & GA4** (Logo, favicon, meta tags, Google Analytics 4, sitemap generator)
  - **Contact Messages Inbox** (Pesan masuk, status, balas langsung via WhatsApp / Email)
- 🔍 **Dynamic SEO & XML Sitemap Engine:**
  - Generator sitemap XML otomatis menggunakan `spatie/laravel-sitemap`
  - Tombol **Generate Sitemap Manual** di panel admin + scheduler cronjob otomatis harian
  - Schema.org JSON-LD structured data (`Organization`, `WebSite`, `Service`, `CreativeWork`, `BreadcrumbList`)
  - Dynamic OpenGraph & Twitter Cards
- 🛡️ **Hardened Security Baseline:**
  - Middleware `SecurityHeaders` (X-Frame-Options, X-Content-Type-Options: nosniff, CSP, HSTS, Permissions-Policy)
  - Form honeypot anti-spam bot + IP-based Rate Limiting (5 submit/menit)
  - Deep string & tag sanitization

---

## 🏛️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                 Browser Client (UI / UX)                    │
│     Blade Components • Tailwind CSS v4 • Font Bunny         │
└──────────────────────────────┬──────────────────────────────┘
                               │ Livewire wire:navigate / AJAX
                               ▼
┌─────────────────────────────────────────────────────────────┐
│               Full-Page Livewire Components                 │
│   App\Livewire\Pages\*  &  App\Livewire\Admin\*             │
└──────────────────────────────┬──────────────────────────────┘
                               │ Dependency Injection
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                    Domain Services Layer                    │
│   HomeService • PortfolioService • ServiceService           │
│   SiteSettingService • ContactService • SeoService          │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│             Eloquent ORM & Performance Engine               │
│  • Memory-Backed Settings Cache (0 SQL query on hit)        │
│  • Database Composite & Single Indexes                      │
│  • Spatie Sitemap Generator                                 │
└─────────────────────────────────────────────────────────────┘
```

---

## ⚡ Optimasi Performa & Keamanan

| Kategori | Optimasi yang Diterapkan |
|---|---|
| **Database & Cache** | Memory-backed cache `SiteSetting` (`Cache::rememberForever`), composite indexes pada tabel CMS, eager loading `with()` bebas N+1 |
| **Core Web Vitals** | `fetchpriority="high"` untuk LCP hero/logo, `loading="lazy"` & `decoding="async"`, dimensi eksplisit pencegah CLS |
| **SEO Score > 95** | XML Sitemap Spatie, Robots.txt, Meta tags dinamis per entitas, JSON-LD Schema.org, OpenGraph, GA4 async |
| **Keamanan** | Security Headers CSP, anti-spambot honeypot, IP rate limiting, input sanitization, admin middleware guards |

---

## 💻 Panduan Instalasi Lokal

### Prasyarat:
- PHP >= 8.2 (Direkomendasikan PHP 8.4+)
- Composer >= 2.x
- Node.js >= 20.x & npm / pnpm
- Database (PostgreSQL, MySQL, atau SQLite)

```bash
# 1. Clone repository
git clone https://github.com/your-username/sankara.git
cd sankara

# 2. Install dependency PHP & Node
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env, kemudian jalankan migrasi & seeder
php artisan migrate --seed

# 5. Buat storage symlink
php artisan storage:link

# 6. Generate XML Sitemap pertama kali
php artisan sitemap:generate

# 7. Jalankan server lokal & asset watcher
npm run dev
# Di terminal kedua:
php artisan serve
```

Akses website di browser: `http://localhost:8000`  
Akses admin dashboard: `http://localhost:8000/admin`

---

## 🚀 Panduan Deployment Siap Produksi

Proyek ini telah dikonfigurasi secara lengkap untuk dapat di-deploy dengan mudah di berbagai platform:

```
┌────────────────────────────────────────────────────────────────────────────┐
│                    PILIHAN DEPLOYMENT READY-PRODUCTION                     │
├───────────────────┬───────────────────┬───────────────────┬────────────────┤
│ 1. Docker Compose │ 2. Coolify (PaaS) │ 3. Native VPS     │ 4. cPanel /    │
│    (Multi-stage)  │    (Git Push)     │    (Nginx+FPM)    │    Shared Host │
└───────────────────┴───────────────────┴───────────────────┴────────────────┘
```

---

### 1. Deploy dengan Docker & Docker Compose

Proyek ini dilengkapi dengan multi-stage production [`Dockerfile`](Dockerfile) dan [`docker-compose.yml`](docker-compose.yml) (terintegrasi Nginx, PHP-FPM 8.4, PostgreSQL 16, Redis 7, dan Supervisor).

```bash
# 1. Konfigurasi file environment
cp .env.example .env
# Edit .env dan sesuaikan APP_KEY, APP_URL, dan password database

# 2. Build dan jalankan seluruh container
docker compose up -d --build

# 3. Jalankan migrasi & seeder awal di dalam container
docker compose exec app php artisan migrate --seed --force
docker compose exec app php artisan storage:link
docker compose exec app php artisan sitemap:generate
```

Aplikasi langsung online di port `8080` (atau port yang Anda tentukan di `APP_PORT`).

---

### 2. Deploy di Coolify (PaaS / VPS)

[Coolify](https://coolify.io) adalah self-hosted Heroku/Netlify alternatif open-source terbaik.

1. Buka dashboard **Coolify** Anda.
2. Tambahkan **New Resource** -> **Public/Private Git Repository** -> masukkan URL repo proyek ini.
3. Pilih **Build Pack: Dockerfile** (Coolify akan otomatis mendeteksi [`Dockerfile`](Dockerfile) di root proyek).
4. Tambahkan Environment Variables di Coolify:
   - `APP_NAME`: `Sankara Tech`
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_KEY`: `base64:...` *(generate via `php artisan key:generate --show`)*
   - `APP_URL`: `https://domain-anda.com`
   - `DB_CONNECTION`: `pgsql` / `mysql`
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - `AUTO_MIGRATE`: `true`
   - `AUTO_GENERATE_SITEMAP`: `true`
5. Klik **Deploy**. Coolify akan otomatis mengompilasi asset Vite, menyiapkan PHP-FPM & Nginx, menjalankan migrasi, dan menyalakan SSL otomatis Let's Encrypt!

---

### 3. Deploy di Native Linux VPS (Nginx + PHP-FPM + Supervisor)

Gunakan skrip dan konfigurasi yang sudah disiapkan di folder [`deploy/`](deploy/):

#### A. Konfigurasi Nginx
```bash
# Salin konfigurasi Nginx
sudo cp deploy/nginx/sankara.conf /etc/nginx/sites-available/sankara.conf
# Edit domain Anda
sudo nano /etc/nginx/sites-available/sankara.conf

# Aktifkan virtual host & reload Nginx
sudo ln -s /etc/nginx/sites-available/sankara.conf /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# Pasang SSL gratis via Certbot
sudo certbot --nginx -d domain-anda.com -d www.domain-anda.com
```

#### B. Konfigurasi Supervisor (Queue Worker & Background Tasks)
```bash
sudo cp deploy/supervisor/laravel-worker.conf /etc/supervisor/conf.d/
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

#### C. Konfigurasi Cronjob Laravel (Auto Sitemap & Schedule)
Tambahkan ke crontab server (`crontab -e`):
```bash
* * * * * cd /var/www/sankara && php artisan schedule:run >> /dev/null 2>&1
```

#### D. 1-Click Zero-Downtime Deploy Script
Setiap kali ada update code / git push:
```bash
./deploy/deploy.sh
```

---

### 4. Deploy di Shared Hosting (cPanel / DirectAdmin)

Proyek ini sudah dilengkapi [`.htaccess` root](.htaccess) khusus untuk Shared Hosting yang otomatis mengarahkan visitor ke `/public` secara aman tanpa mengekspos file `.env`.

1. **Upload File:**
   - Kompres seluruh isi folder proyek (kecuali `node_modules`) menjadi `sankara.zip`.
   - Upload dan ekstrak di root hosting Anda (misal `/home/username/public_html` atau `/home/username/sankara`).
2. **Setup PHP Version:**
   - Masuk menu **Select PHP Version** di cPanel -> pilih **PHP 8.3** atau **PHP 8.4**.
   - Aktifkan ekstensi: `pdo_mysql`, `gd`, `zip`, `intl`, `bcmath`, `fileinfo`, `opcache`.
3. **Database & .env:**
   - Buat database MySQL di **MySQL Databases** cPanel.
   - Edit `.env` sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, dan `APP_URL`.
4. **Jalankan Terminal / SSH (atau via cPanel Cron Job sekali jalan):**
   ```bash
   php artisan migrate --seed --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan sitemap:generate
   ```
5. **Setup Cron Job Otomatis (Sitemap & Maintenance):**
   - Buka menu **Cron Jobs** di cPanel.
   - Tambahkan jadwal **Once Per Minute (* * * * *)**:
     ```bash
     /usr/local/bin/php /home/USERNAME/public_html/artisan schedule:run >> /dev/null 2>&1
     ```

---

### 5. Deploy di Cloud Hosting (Laravel Cloud / Render / Railway / Fly.io)

1. Hubungkan repository GitHub Anda ke penyedia cloud pilihan Anda.
2. **Build Command:**
   ```bash
   composer install --no-dev --optimize-autoloader && npm install && npm run build
   ```
3. **Start Command:**
   ```bash
   php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
4. Tambahkan environment variables (`APP_KEY`, `APP_ENV=production`, `DB_*`, dll).

---

## 🧪 Testing & Standarisasi Kode

Aplikasi diuji secara komprehensif mencakup seluruh fitur autentikasi, CRUD admin, SEO, sitemap XML, keamanan rate limiting, honeypot, dan caching.

```bash
# Menjalankan seluruh test suite PHPUnit (27 tests, 121 assertions)
php artisan test

# Format dan rapikan kode dengan Laravel Pint
./vendor/bin/pint
```

Hasil status pengujian:
```
   PASS   Tests\Feature\LivewireAdminTest
  ✓ admin can login via livewire
  ✓ admin dashboard renders metrics
  ✓ admin home settings saves content
  ✓ admin pages about saves content
  ✓ admin can create service via livewire
  ✓ admin can toggle and delete service
  ✓ admin can create portfolio via livewire
  ✓ admin can create pricing plan via livewire
  ✓ admin site settings saves and generates sitemap

   PASS   Tests\Feature\LivewirePublicPagesTest
  ✓ public pages render successfully
  ✓ contact form livewire submission

   PASS   Tests\Feature\PerformanceAndCacheTest
  ✓ site setting is cached in memory
  ✓ site setting invalidates cache on set value
  ✓ landing page executes efficiently

   PASS   Tests\Feature\SecurityAndRateLimitTest
  ✓ security headers are present on all responses
  ✓ contact form honeypot silently drops spambots
  ✓ contact form validates and stores clean message
  ✓ contact form rate limiting

   PASS   Tests\Feature\SeoAndSitemapTest
  ✓ sitemap command generates xml file
  ✓ sitemap xml route returns valid xml
  ✓ robots txt route returns sitemap reference
  ✓ homepage renders dynamic seo and json ld
  ✓ service show page renders service schema
  ✓ portfolio show page renders creative work schema
  ✓ admin can trigger manual sitemap generation

  Tests:    27 passed (121 assertions)
  Duration: 2.03s
```

---

## 🔐 Akun Default Administrator

Setelah menjalankan seeder (`php artisan db:seed` atau `php artisan migrate --seed`), gunakan kredensial berikut untuk login ke admin panel:

- **URL Login:** `https://your-domain.com/admin/login`
- **Email:** `admin@sankaratech.test`
- **Password:** `password`

*(Segera ganti password Anda setelah pertama kali login melalui panel admin atau database).*

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi [MIT License](LICENSE).
Dikembangkan untuk menghadirkan pengalaman digital agensi terbaik dengan performa dan keandalan tingkat enterprise.
