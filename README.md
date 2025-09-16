<div align="center" style="display:flex; align-items:center; justify-content:center; gap:40px;">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" 
         width="500" alt="Laravel Logo">
  </a>
  <a href="https://smkpesat.sch.id" target="_blank">
    <img src="https://smkpesat.sch.id/wp-content/uploads/2025/07/Logo-SMKPesatITXPRO-scaled.png" 
         width="400" alt="SMK Pesat Logo">
  </a>
</div>

<p align="center">
  <a href="https://github.com/Rendervou/Absensi-smk-pesat/actions">
    <img src="https://img.shields.io/github/actions/workflow/status/Rendervou/Absensi-smk-pesat/laravel.yml?branch=main" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
  </a>
</p>

---

# 📌 Absensi SMK Pesat

Aplikasi absensi berbasis web untuk **SMK Pesat**, dikembangkan dengan framework **Laravel**.  
Project ini bertujuan untuk mempermudah proses pencatatan kehadiran siswa, pengelolaan data siswa, guru, kelas, serta pembuatan laporan absensi bulanan maupun harian.

---

## 🚀 Fitur Utama

- 🔐 **Autentikasi & Role Management**
  - Login multi user (Admin, Guru, Siswa)
  - Hak akses berbeda sesuai role

- 👨‍🏫 **Manajemen Data**
  - CRUD Data Siswa, Guru, Jurusan, Kelas
  - Relasi antar entitas (Siswa ↔ Kelas ↔ Jurusan)

- 📝 **Absensi Siswa**
  - Pencatatan absensi harian
  - Status kehadiran: Hadir, Izin, Sakit, Alpha
  - Absensi dicatat oleh guru

- 📊 **Laporan**
  - Rekap absensi per kelas / per siswa
  - Filter berdasarkan tanggal / bulan
  - Export laporan ke **Excel / PDF**

- 🎨 **Antarmuka**
  - Desain berbasis **TailwindCSS / Flowbite**
  - Responsif (desktop & mobile)

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: [Laravel](https://laravel.com/) 10.x
- **Frontend**: Blade Template + TailwindCSS / Flowbite
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite, npm
- **Deployment Ready**: Apache / Nginx

---

## ⚙️ Instalasi & Konfigurasi

### 1. Clone Repository
```bash
git clone https://github.com/Rendervou/Absensi-smk-pesat.git
cd Absensi-smk-pesat
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup File .env
Salin .env.example menjadi .env:
```bash
cp .env.example .env
```

### 
Lalu sesuaikan konfigurasi database:
```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_smk
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key
```bash
php artisan key:generate
```

### 5. Migrasi Database
```bash
php artisan migrate
```

### 6. Build Asset Frontend
```bash
npm run dev
```

### 7. Jalankan Server
```bash
php artisan serve
```
Akses aplikasi di: http://127.0.0.1:8000

---

## 🧪 Testing

Jalankan unit test & feature test dengan:
```bash
php artisan test
```

---

## 📊 ERD (Entity Relationship Diagram)

```bash
Guru (id, nama, nip, ...)
   │── (Absensi (id, id_guru, id_siswa, tanggal, status)
Siswa (id, nama, nis, id_kelas, id_jurusan, ...)
   │
   └── Kelas (id, nama_kelas, id_jurusan)
Jurusan (id, nama_jurusan)
```

---

## 🤝 Kontribusi

Jika ingin berkontribusi pada project ini:
1. Fork repository ini
2. Buat branch baru (git checkout -b feature/nama-fitur)
3. Lakukan perubahan & commit (git commit -m "Tambah fitur X")
4. Push ke branch (git push origin feature/nama-fitur)
5. Buat Pull Request ke branch main

---

## 📝 License

Project **Absensi SMK Pesat** adalah milik **SMK Informatika Pesat**.  
Kode sumber dan seluruh konten di dalam repository ini **tidak diperbolehkan untuk digunakan, disalin, dimodifikasi, atau didistribusikan** tanpa izin resmi dari pihak sekolah.  

Penggunaan project ini hanya diperuntukkan bagi kebutuhan internal sekolah, sesuai dengan arahan pengembang dan pihak berwenang di SMK Informatika Pesat.  

Jika Anda ingin menggunakan atau mengembangkan project ini, silakan hubungi pihak sekolah atau pengembang terkait untuk mendapatkan izin resmi.

---

## 👥 Kontributor

<table align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" style="padding:12px;">
      <a href="https://github.com/Rendervou" style="text-decoration:none;color:#ffffff;">
        <img src="https://github.com/Rendervou.png" width="96" style="border-radius:50%;display:block;margin:0 auto;border:2px solid rgba(255,255,255,0.12);">
        <div style="margin-top:8px;font-weight:700;font-size:14px;">Rendervou</div>
      </a>
    </td>
    <td align="center" style="padding:12px;">
      <a href="https://github.com/SOoyaaqt12" style="text-decoration:none;color:#ffffff;">
        <img src="https://github.com/SOoyaaqt12.png" width="96" style="border-radius:50%;display:block;margin:0 auto;border:2px solid rgba(255,255,255,0.12);">
        <div style="margin-top:8px;font-weight:700;font-size:14px;">SOoyaaqt12</div>
      </a>
    </td>
    <td align="center" style="padding:12px;">
      <a href="https://github.com/FarrelAlvidi" style="text-decoration:none;color:#ffffff;">
        <img src="https://github.com/FarrelAlvidi.png" width="96" style="border-radius:50%;display:block;margin:0 auto;border:2px solid rgba(255,255,255,0.12);">
        <div style="margin-top:8px;font-weight:700;font-size:14px;">FarrelAlvidi</div>
      </a>
    </td>
  </tr>
</table>

---

