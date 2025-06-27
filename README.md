# CMS Terbuka - Eksploitasi Panel Admin Tersembunyi

> Web CTF Challenge | by [ctflabs-id](https://github.com/ctflabs-id)


---

## 📖 Scenario

Sebuah CMS lokal memiliki panel admin yang tidak terproteksi dengan baik. Peserta harus menemukan panel tersembunyi, melakukan brute force login, dan memanfaatkan XSS untuk mendapatkan akses penuh.

---

## 🎯 Challenge Overview
**Target:** `http://bank-palsu.local:5000`<br>
**Vulnerability:** Hidden Admin Panel (Information Disclosure), Weak Credentials (Brute Force), XSS Stored di Fitur Komentar<br>
**Objective:** Temukan panel admin tersembunyi, brute force login, dan eksekusi XSS untuk mendapatkan flag<br>
**Difficulty:** ⭐⭐⭐⭐☆ (Advanced)

---
## 🛠️ Setup Instructions

Prerequisites:

    PHP 7.4+ (xampp)
    Apache
    MySQL
    
Langkah-langkah:

  1. Clone repository ini
```bash
git clone https://github.com/ctflabs-id/CMS-Terbuka.git
cd CMS-Terbuka.git
```
  2. Start XAMPP
  5. Server akan berjalan di http://localhost/CMS-Terbuka-CTF

---

## 💡 Hints
    🔍 Perhatikan file robots.txt dan komentar HTML
    🛑 Panel admin memiliki credentials default
    💉 Fitur komentar tidak melakukan sanitasi input
    📂 Backup file mungkin berguna
    🚩 Flag ada di halaman admin setelah login

---

## 🎓 Tujuan Tantangan Ini
  1. Information gathering dari file publik
  2. Brute force login sederhana
  3. Eksploitasi XSS stored
  4. Analisis kode sumber untuk menemukan rahasia

---

## ⚠️ Disclaimer

Challenge ini dibuat hanya untuk edukasi dan simulasi keamanan siber. Jangan gunakan teknik serupa terhadap sistem yang tidak kamu miliki atau tidak diizinkan.

---
<details><summary><h2>🏆 Solusi yang Diharapkan - (Spoiler Allert)</h2></summary>

Peserta harus:
Langkah 1: Temukan Panel Admin
    1. Cek robots.txt menemukan /admin/
    2. Atau temukan hint di komentar HTML tentang backup

Langkah 2: Brute Force Login
    1. Coba credential default:
    2. Username: admin
    3. Password: s3cret4dmin!!

Langkah 3: Eksploitasi XSS
    1. Post komentar dengan payload XSS:
    ```html
    <script>alert(document.cookie)</script>
    ```
    2. Admin akan melihat komentar dan menjalankan script
Langkah 4: Dapatkan Flag

    Setelah login ke /admin/, flag ditampilkan

> Flag: CTF_FLAG{H1dd3n_Adm1n_XSS_Combo}

    
</details>

---

## 🤝 Kontribusi Pull request & issue welcome via: ctflabs-id/EBook-Premium-CTF
## 🧠 Maintained by:
```
GitHub: @ctflabs-id
Website: ctflabsid.my.id
```
