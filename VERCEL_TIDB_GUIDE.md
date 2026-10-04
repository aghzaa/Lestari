# Panduan Deployment: LESTARI ke Vercel dengan TiDB Cloud Serverless

Panduan ini merangkum langkah demi langkah untuk memublikasikan platform **LESTARI - Jovian Health Care** ke platform serverless **Vercel** menggunakan basis data cloud **TiDB Serverless**.

---

## 1. Menyiapkan Basis Data Cloud (TiDB Serverless)

TiDB Serverless menyediakan kapasitas database MySQL-compatible gratis (Free Tier) yang ideal untuk arsitektur serverless.

1. Buka dan daftar akun di [tidbcloud.com](https://tidbcloud.com/).
2. Buat cluster baru:
   - Pilih tipe: **Serverless** (Free).
   - Tentukan nama cluster (contoh: `lestari-jovian-db`).
   - Pilih region terdekat (disarankan: **AWS / Singapore `ap-southeast-1`** untuk latensi tercepat ke Indonesia).
3. Setelah cluster aktif, klik tombol **Connect**:
   - Pilih tab **Connect with: General / MySQL CLI**.
   - Catat informasi berikut:
     - **Host**: Contoh `gateway01.ap-southeast-1.prod.aws.tidbcloud.com`
     - **Port**: `4000`
     - **User**: Contoh `xxxxxx.root`
     - **Password**: Kata sandi yang digenerate saat pembuatan cluster
     - **Database**: `lestari_jovian` (atau `test`)

### Migrasi & Seeding ke TiDB dari Komputer Lokal
Sebelum deploy ke Vercel, jalankan migrasi dan seeder awal dari komputer lokal Anda ke TiDB Cloud:

1. Ubah sementara konfigurasi di berkas `.env` lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=gateway01.ap-southeast-1.prod.aws.tidbcloud.com
   DB_PORT=4000
   DB_DATABASE=test
   DB_USERNAME=xxxxxx.root
   DB_PASSWORD=xxxxxx
   MYSQL_ATTR_SSL_CA=
   MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=false
   ```
2. Jalankan migrasi dan seeder di terminal:
   ```bash
   php artisan migrate --seed
   ```
3. Setelah selesai dan data berhasil masuk, kembalikan `.env` lokal Anda ke konfigurasi Laragon semula (`127.0.0.1:3306`).

---

## 2. Struktur Berkas Vercel yang Telah Disiapkan

Proyek ini telah dikonfigurasi secara otomatis dengan berkas pendukung Vercel:

| Berkas | Fungsi Utama |
| :--- | :--- |
| [`vercel.json`](file:///c:/laragon/www/Lestari-Jovian/vercel.json) | Menentukan runtime serverless `vercel-php@0.7.3`, routing aset statis, rewrite request ke `api/index.php`, dan default env. |
| [`api/index.php`](file:///c:/laragon/www/Lestari-Jovian/api/index.php) | Serverless entry point yang menyiapkan direktori writable di `/tmp/storage` sebelum mengeksekusi kernel Laravel. |
| [`bootstrap/app.php`](file:///c:/laragon/www/Lestari-Jovian/bootstrap/app.php) | Pengalihan `useStoragePath('/tmp/storage')` otomatis saat variabel `VERCEL` terdeteksi. |
| [`.vercelignore`](file:///c:/laragon/www/Lestari-Jovian/.vercelignore) | Mengabaikan direktori pengujian dan berkas development lokal agar ukuran deployment ringan. |
| [`config/database.php`](file:///c:/laragon/www/Lestari-Jovian/config/database.php) | Dukungan penuh opsi SSL PDO untuk TiDB Cloud (`MYSQL_ATTR_SSL_CA` dan `MYSQL_ATTR_SSL_VERIFY_SERVER_CERT`). |

---

## 3. Langkah Deployment ke Vercel

### Opsi A: Melalui Integrasi GitHub (Sangat Disarankan)

1. **Inisialisasi Git dan Push ke GitHub**:
   Buka terminal di direktori proyek dan jalankan:
   ```bash
   git init
   git add .
   git commit -m "feat: complete LESTARI Jovian platform ready for Vercel"
   git branch -M main
   git remote add origin https://github.com/USERNAME/Lestari-Jovian.git
   git push -u origin main
   ```
2. **Import ke Vercel**:
   - Buka [vercel.com](https://vercel.com/) dan login.
   - Klik tombol **"Add New..." &rarr; "Project"**.
   - Pilih repository **Lestari-Jovian** dari daftar GitHub Anda.
3. **Atur Environment Variables di Vercel Dashboard**:
   Sebelum menekan tombol Deploy, buka bagian **Environment Variables** dan tambahkan:

   | Variabel | Nilai Contoh |
   | :--- | :--- |
   | `APP_NAME` | `LESTARI - Jovian Health Care` |
   | `APP_ENV` | `production` |
   | `APP_DEBUG` | `false` |
   | `APP_KEY` | `base64:BGHXekx4ydnFMrl0rqOSdPDS7hef0mWDO9MQtdoFY2c=` |
   | `APP_URL` | `https://nama-proyek-anda.vercel.app` |
   | `DB_CONNECTION` | `mysql` |
   | `DB_HOST` | *(Host TiDB Serverless Anda)* |
   | `DB_PORT` | `4000` |
   | `DB_DATABASE` | *(Nama database TiDB Anda)* |
   | `DB_USERNAME` | *(Username TiDB Anda)* |
   | `DB_PASSWORD` | *(Password TiDB Anda)* |
   | `MYSQL_ATTR_SSL_CA` | `/etc/pki/tls/certs/ca-bundle.crt` |
   | `MYSQL_ATTR_SSL_VERIFY_SERVER_CERT` | `true` |
   | `SESSION_DRIVER` | `cookie` |
   | `CACHE_DRIVER` | `array` |
   | `LOG_CHANNEL` | `stderr` |
   | `VERCEL` | `1` |

4. Klik **Deploy** dan tunggu proses build selesai (sekitar 1-2 menit).

---

### Opsi B: Melalui Vercel CLI

Jika Anda memiliki Vercel CLI terpasang di komputer:
```bash
npm install -g vercel
vercel login
vercel
```
Ikuti instruksi di terminal dan tambahkan environment variables di atas pada dashboard Vercel.

---

## 4. Verifikasi Pasca Deployment

1. Buka tautan URL aplikasi Anda di `https://nama-proyek-anda.vercel.app`.
2. Lakukan uji pengiriman curahan hati pada Ruang Cerita (Halaman 1 & Halaman 2).
3. Pastikan partikel, audio relaksasi 174 Hz, dan tombol OPEN berjalan mulus.
4. Buka `https://nama-proyek-anda.vercel.app/login` dan masuk dengan kredensial:
   - **Email**: `admin@lestari.com`
   - **Password**: `password`
5. Periksa apakah cerita yang baru saja Anda masukkan muncul di Dashboard Admin dan grafik analitik.
