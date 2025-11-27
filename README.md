## Pertanyaan & Jawaban

### Jelaskan apa itu REST API?

REST API (Representational State Transfer API) adalah arsitektur layanan web yang menggunakan protokol HTTP untuk melakukan komunikasi antara client dan server dengan format respons biasanya JSON. REST API bersifat stateless, artinya setiap request harus mengirimkan semua informasi yang dibutuhkan tanpa bergantung pada request sebelumnya.

### Apa itu CORS dan bagaimana cara menanganinya di backend?

CORS (Cross-Origin Resource Sharing) adalah mekanisme keamanan browser yang membatasi akses resource dari domain berbeda. Jika frontend dan backend berada di domain yang berbeda, backend harus memberikan izin melalui header `Access-Control-Allow-Origin`.
Di Laravel, penanganan CORS bisa melalui middleware bawaan di file:

* `app/Http/Middleware/HandleCors.php`
* dan konfigurasi di `config/cors.php`

### Jelaskan perbedaan antara SQL dan NoSQL database

| SQL                                   | NoSQL                                                                 |
| ------------------------------------- | --------------------------------------------------------------------- |
| Menggunakan struktur tabel relasional | Menggunakan model data fleksibel (document, key-value, graph, column) |
| Cocok untuk data terstruktur          | Cocok untuk data tidak terstruktur atau sering berubah                |
| Mendukung relasi kompleks             | Biasanya tidak fokus pada relasi                                      |
| Query menggunakan bahasa SQL          | Query tergantung database (misal MongoDB Query)                       |
| Menjamin konsistensi yang kuat (ACID) | Biasanya fokus pada scalability (BASE)                                |

Contoh SQL: MySQL, PostgreSQL

Contoh NoSQL: MongoDB, Redis

### Apa yang anda ketahui tentang middleware?

Middleware adalah lapisan logika yang berjalan sebelum atau sesudah sebuah request diproses oleh controller. Digunakan untuk:

* Autentikasi & otorisasi (JWT, auth)
* Logging request
* Handling CORS
* Validasi token

Di Laravel middleware didefinisikan di:

* `app/Http/Middleware/`
* dan dapat diterapkan di route atau global

---

## 📦 Postman Collection

Untuk mempermudah testing API, gunakan Postman Collection berikut:

Postman Collection: (import ke Postman)

```
https://www.postman.com/zeeidev/public-jundi-hm/collection/2jc1zjm/nagaexchange-cipta-koin-digita
```

---

## Bisa dijalankan Online dan Lokal
API base URL ONLINE:

```
https://nagaexchange.jundi.hm/api
```

API base URL:

```
http://localhost:8000/api
```

---

# Todos API - Laravel 12 + JWT Authentication

Dokumentasi untuk REST API Todo menggunakan Laravel 12 dan JWT Authentication.

---

## ✨ Fitur

* Register dan Login User (JWT Authentication)
* CRUD Todos berdasarkan user yang login
* Database MySQL
* Hanya user yang memiliki akses dapat CRUD datanya sendiri

---

## 🛠 Teknologi

* Laravel 12
* MySQL
* JWT Auth (tymon/jwt-auth)
* PHP 8+

---

## 📌 Instalasi Project

### Clone Repository & Install Dependencies

```bash
git clone <repository>
cd todos-api
composer install
```

### Copy file environment

```bash
cp .env.example .env
```

### Generate App Key

```bash
php artisan key:generate
```

### Setup Database

Edit `.env` bagian database:

```
DB_DATABASE=todos_db
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migration:

```bash
php artisan migrate
```

### Install JWT Auth

```bash
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

Set guard API di `config/auth.php`:

```php
'api' => [
    'driver' => 'jwt',
    'provider' => 'users',
],
```

---

## 🚀 Menjalankan Server

```bash
php artisan serve
```

API base URL:

```
http://localhost:8000/api
```

---

## 🔐 Authentication Endpoints

| Method | Endpoint  | Deskripsi                          |
| ------ | --------- | ---------------------------------- |
| POST   | /register | Register user baru                 |
| POST   | /login    | Login user & mendapatkan token JWT |
| GET    | /me       | Mendapatkan data user login        |

### Contoh Body Register

```json
{
  "name": "tes",
  "email": "tes@example.com",
  "password": "123456"
}
```

### Contoh Body Login

```json
{
  "email": "tes@example.com",
  "password": "123456"
}
```

---

## 📝 Todos Endpoints (Protected - Wajib Token)

Kirim Authorization Header:

```
Bearer <token_dari_login>
```

| Method | Endpoint    | Body                        | Deskripsi                          |
| ------ | ----------- | --------------------------- | ---------------------------------- |
| GET    | /todos      | -                           | Mendapatkan semua todos milik user |
| POST   | /todos      | title, description          | Buat todo baru                     |
| PUT    | /todos/{id} | title, description, is_done | Update todo                        |
| DELETE | /todos/{id} | -                           | Hapus todo                         |

Contoh Body Create TODO:

```json
{
  "title": "Belajar Laravel",
  "description": "Mengerjakan tugas REST API"
}
```

Contoh Body Update TODO:

```json
{
  "title": "Belajar Laravel Update",
  "description": "Sudah selesai",
  "is_done": true
}
```

---

## 🧪 Testing

Gunakan Postman / Thunder Client / Insomnia

Urutan test:

1. Register User
2. Login User
3. Copy token → Gunakan di Authorization
4. CRUD Todos

---

## 👨‍💻 Author

Todos API dibuat sebagai tugas REST API Laravel + JWT.

---





