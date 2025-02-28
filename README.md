### **Starter Kits Filament Generator:**
**Starter Kits Filament Resource Generator with Custom Form Builder**

---

### **Deskripsi:**
Proyek ini adalah alat untuk menghasilkan **Filament Resources** secara otomatis, termasuk Model, Migration, dan Form Builder yang dapat disesuaikan secara visual. Starter Kits ini, Anda dapat membuat dan mengelola resources di Laravel Filament tanpa perlu menulis kode berulang. Proyek ini juga mendukung pembuatan form dinamis dengan drag-and-drop, yang memungkinkan pengguna mendesain form sesuai kebutuhan.

---

### **Fitur Utama:**
1. **Automatic Resource Generation**:
   - Membuat Model, Migration, dan Filament Resource secara otomatis berdasarkan input pengguna.
   - Mendukung pembuatan fields dan relationships secara dinamis.

2. **Custom Form Builder**:
   - Pengguna dapat mendesain form secara visual dengan drag-and-drop.
   - Mendukung berbagai tipe field seperti text, number, date, select, toggle, dan lainnya.

3. **Dynamic Migration**:
   - Secara otomatis membuat migration berdasarkan fields yang didesain di form builder.

4. **Dark Mode Support**:
   - Antarmuka yang mendukung light mode dan dark mode untuk kenyamanan pengguna.

5. **Easy Integration**:
   - Mudah diintegrasikan dengan proyek Laravel Filament yang sudah ada.
   - Dilengkapi dengan dokumentasi yang jelas untuk memudahkan penggunaan.

---

### **Cara Menggunakan:**

#### 1. **Instalasi**:
- Clone repositori ini ke dalam proyek Laravel Anda:
  ```bash
  git clone https://github.com/hagiik/Filament-Resource-Generator.git
  ```
- Install dependencies:
  ```bash
  composer install
  npm install
  ```

#### 2. **Buat Role Baru dan Atur Akses**:
- Buka halaman **Roles**.
- Buat role baru, misalnya `Admin`.
- Ceklis seluruh akses yang tersedia untuk role tersebut.
- Simpan perubahan.

#### 3. **Tambahkan Role ke User**:
- Buka halaman **Users**.
- Pilih akun yang ingin diberikan role tersebut.
- Tambahkan role yang sudah dibuat sebelumnya.
- Simpan perubahan.
- Refresh kembali browser.
- Halaman **Resource Generator** akan muncul.

#### 4. **Generate Resource**:
- Buka halaman **Resource Generator** di panel admin Filament.
- Isi nama resource, fields, dan relationships yang diinginkan.
- Klik tombol **Generate** untuk membuat Model, Migration, dan Filament Resource secara otomatis.

#### 5. **Custom Form Builder**:
- Buka halaman **Custom Form Builder**.
- Drag-and-drop fields yang dibutuhkan ke dalam form.
- Simpan konfigurasi form, dan sistem akan secara otomatis membuat migration dan form yang sesuai.

#### 6. **Jalankan Migration**:
- Setelah resource dibuat, jalankan migration:
  ```bash
  php artisan migrate
  ```

#### 7. **Akses Resource**:
- Resource yang telah dibuat dapat diakses melalui menu di panel admin Filament.

---

### **Penanganan Git Remote untuk Proyek Ini**
Jika Anda ingin meng-*clone* proyek ini dan menyimpannya di repository Anda sendiri tanpa mempertahankan *branch* utama dari repo asal, ikuti langkah-langkah berikut:

#### **1. Clone Repository Tanpa Riwayat Git**
```bash
git clone --depth 1 https://github.com/hagiik/Filament-Resource-Generator.git my-project
cd my-project
rm -rf .git  # Menghapus riwayat Git lama
git init     # Inisialisasi ulang Git untuk repo baru
```

#### **2. Tambahkan Repository Baru**
Buat repository kosong di GitHub/GitLab, lalu tambahkan sebagai *remote origin*:
```bash
git remote add origin https://github.com/username/repository-baru.git
git branch -M main
git push -u origin main
```

#### **3. Jika Salah Memasukkan URL Remote**
Cek daftar *remote* yang sudah ditambahkan:
```bash
git remote -v
```
Hapus *remote* yang salah:
```bash
git remote remove origin
```
Tambahkan ulang dengan URL yang benar:
```bash
git remote add origin https://github.com/username/repository-benar.git
git push -u origin main
```

---

### **Contoh Penggunaan:**
1. **Membuat Resource "Product"**:
   - Nama Resource: `Product`
   - Fields: `name` (string), `price` (decimal), `description` (text)
   - Relationships: `belongsTo` Category

2. **Membuat Custom Form**:
   - Buat form dengan fields: `name`, `price`, dan `description`.
   - Simpan form, dan sistem akan membuat migration dan form yang sesuai.

---

### **Teknologi yang Digunakan:**
- **Laravel**: Sebagai framework backend.
- **Filament**: Sebagai admin panel.
- **Tailwind CSS**: Untuk styling dan dukungan dark mode.
- **Livewire**: Untuk interaktivitas di frontend.

---

### **Kontribusi:**
Kami sangat terbuka terhadap kontribusi! Jika Kamu ingin berkontribusi, silakan:
1. Fork repositori ini.
2. Buat branch baru (`git checkout -b fitur-baru`).
3. Commit perubahan Anda (`git commit -m 'Tambahkan fitur baru'`).
4. Push ke branch (`git push origin fitur-baru`).
5. Buat Pull Request.

---

### **Lisensi:**
Proyek ini dilisensikan di bawah **MIT License**. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

### **Penghargaan:**
- Terima kasih kepada [Filament](https://filamentphp.com/) untuk admin panel yang luar biasa.
- Terima kasih kepada [Tailwind CSS](https://tailwindcss.com/) untuk utility-first CSS framework.

---

### **Tautan Berguna:**
- [Dokumentasi Filament](https://filamentphp.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---

### **Catatan:**
Proyek ini masih dalam pengembangan aktif. Jika Anda menemukan bug atau memiliki saran, silakan buka [issue](https://github.com/hagiik/Filament-Resource-Generator/issues).

