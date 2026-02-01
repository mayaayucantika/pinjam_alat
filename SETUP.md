# Setup Aplikasi Peminjaman Alat

## Persyaratan
- PHP 8.2+
- MySQL
- Composer
- Node.js & NPM

## Langkah Setup

1. **Konfigurasi Database**
   - Buat database MySQL dengan nama `pinjamku`
   - Update file `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=pinjamku
     DB_USERNAME=root
     DB_PASSWORD=
     ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   php artisan key:generate
   ```

4. **Jalankan Migrations**
   ```bash
   php artisan migrate
   ```

5. **Seed Database**
   ```bash
   php artisan db:seed
   ```

6. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## Data Login Default

**Admin:**
- Email: admin@pinjamku.com
- Password: password

**Peminjam:**
- Email: budi@example.com / siti@example.com / ahmad@example.com
- Password: password

## Fitur

- ✅ Multi-role (Admin & Peminjam)
- ✅ CRUD Alat dengan foto
- ✅ CRUD Kategori
- ✅ Sistem Peminjaman dengan validasi stok
- ✅ Sistem Pengembalian dengan update stok otomatis
- ✅ Dashboard dengan statistik
- ✅ UI modern dengan Tailwind CSS
