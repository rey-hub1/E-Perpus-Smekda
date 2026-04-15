# Analisis Kekurangan Project E-Perpus (Berdasarkan Prioritas)

Berdasarkan audit kode, rute, controller, dan struktur database saat ini, berikut adalah daftar kekurangan dalam project ini yang perlu diperbaiki, diurutkan dari skala prioritas tertinggi (Kritis) hingga rendah (Peningkatan/Kosmetik):

## 🚨 Prioritas Tinggi (Critical & Inti Logika)

Kekurangan di level ini dapat memicu bug, kerentanan, atau inkonsistensi data yang berakibat fatal pada fungsi utama sistem perpustakaan.

### 1. Duplikasi Sistem "Simpan Buku" (Redundansi Fitur)
**Masalah**: Ada dua sistem yang berjalan bersamaan untuk menyimpan buku.
- `BookController@favorite` yang menyimpan buku ke relasi `favoriteBooks`.
- `LibraryController@store` yang menyimpan buku ke dalam `UserLibrary` dengan status `reading`, `saved`, dan `finished`.
**Dampak**: Membingungkan *user* (Siswa) karena ada tombol/fitur "Favorite" (suka) dan "Saved" di My Library yang memiliki fungsi hampir sama tetapi disimpan di database yang berbeda.
**Solusi**: Gabungkan keduanya. Hapus rute favorite dan gunakan satu sistem My Library untuk melacak status keterikatan siswa dengan buku.

### 2. Inkonsistensi Perhitungan *Due Date* (Batas Waktu Pinjam)
**Masalah**: Logika perhitungan batas waktu sangat tidak konsisten.
- Di `TransactionController@pinjam` (oleh Siswa), buku dipinjam dengan tempo **10 hari** sejak tanggal ambil.
- Di `TransactionController@adminPinjam` (oleh Admin), tempo tiba-tiba disetel **7 hari** dihitung dari hari ini (`Carbon::now()->addDays(7)`).
**Dampak**: Siswa bisa jadi merasa dirugikan atau kebingungan karena regulasi peminjaman perpustakaan terlihat berubah-ubah tanpa pemberitahuan.
**Solusi**: Buat satu variabel *Global Settings* di database atau config file untuk jumlah hari maksimum peminjaman, sehingga satu aturan berlaku untuk seluruh platform.

### 3. Logika Denda (Fines) Kurang Real-Time
**Masalah**: Denda (`fine`) saat ini bersifat statis. Denda Rp. 1000/hari hanya dihitung **tepat pada saat buku dikembalikan** (`$hari_telat = $tanggal_kembali->diffInDays($transaction->due_date)`).
**Dampak**: Di halaman *dashboard* Siswa, mereka tidak bisa melihat *running-denda* (denda yang berjalan) jika telambat mengembalikan, karena angkanya masih 0 hingga divalidasi oleh Admin.
**Solusi**: Buat *Accessor* pada model `Transaction` e.g., `getDendaBerjalanAttribute()` agar denda dihitung otomatis secara visual ketika hari H sudah lewat, sebelum proses pengembalian dilakukan.

---

## ⚠️ Prioritas Menengah (UX, Validasi & Keamanan Level Admin)

### 4. Tidak Ada Proteksi Role Berlapis di Route Student
**Masalah**: Rute untuk student seperti `/student/home` atau `/library` hanya diproteksi oleh middleware `auth` biasa di `routes/web.php`.
**Dampak**: Akun Admin bisa mengakses halaman Siswa yang kadang memakai komponen/variable yang tidak relevan dengan relasi table admin, yang bisa mengakibatkan Error 500 jika tidak hati-hati.
**Solusi**: Buat *Middleware* khusus `is_student` (atau modifikasi pengelecekan role) agar Admin tidak bisa mengakses dashboard student, sama seperti Siswa dicegah mengakses menu Admin oleh middleware `admin`.

### 5. Validasi "Bolong" di Fitur Bulk Create (Upload Buku Massal)
**Masalah**: Di fungsi `BookController@bulkStore`, kita hanya mengambil `$request->input('books')` dan menyimpannya di foreach-loop **tanpa** validasi tipe data atau form input (Request validation) yang ketat.
**Dampak**: Admin (atau user usil) berpotensi memasukkan data yang rusak, tipe data string ke kolom integer (seperti `stok`), yang dapat merusak database.
**Solusi**: Terapkan Form Request Validation untuk array input seperti `'books.*.judul' => 'required|string'`, `'books.*.stok' => 'required|integer'`.

### 6. Potensi Penumpukan Gambar Sampah (*Orphaned Files*)
**Masalah**: Pada saat *Update* atau *Destroy* buku, logika penghapusan gambar masih memeriksa 2 lokasi yang berbeda (`Storage::disk('public')->exists()` dan `file_exists(public_path('images/...'))`). Selain itu, jika *bulk-upload* gagal di pertengahan (*unhandled exception*), gambar yang terlanjur terpotong akan menumpuk di server dan memakan storage.
**Dampak**: Hosting akan cepat penuh oleh sampah foto sampul buku yang terputus dari database.
**Solusi**: Selalu bungkus aksi penyimpanan ke database di `DB::transaction(...)`. Jika create/update gagal, hapus gambar yang baru saja dibuat sebelum melempar error.

---

## 🔧 Prioritas Rendah (Polish, Fitur Lanjutan, dan SEO)

### 7. Pengalaman Registrasi Profil yang "Terpotong"
**Masalah**: User baru bisa daftar tanpa mengisi **NISN, Kelas, dan Nomor HP** karena itu tidak wajib di auth/register. Tapi saat mau pinjam buku, aplikasi tiba-tiba menolak (`showJadwal()`) dan memaksa user pindah halaman untuk ganti profil.
**Solusi**: Masukkan saja kolom NISN, Kelas, dan No Telp di `/login` & `/register` form agar siklusnya rampung sejak awal, dan tidak memutus antusiasme peminjaman siswa di tengah jalan.

### 8. Analytics Admin yang Sangat Basic
**Masalah**: Dashboard admin saat ini hanya menampilkan angka mentah (Total buku, Total siswa, Total transaksi).
**Solusi**: Tambahkan *Chart* interaktif (contoh: Grafik Peminjaman Buku per Bulan) dan tabel data statistik lanjutan (seperti: "Siswa dengan denda tertinggi", atau "Buku paling populer bulan ini").

### 9. Notifikasi Pengingat (*Reminder*) Belum Ada
**Masalah**: Tidak ada pengingat ketika H-1 masa pinjam buku habis.
**Solusi**: Integrasikan email notifikasi otomatis atau In-App Notif kepada Siswa jika masa tenggat akan segera tiba untuk menghindari terjadinya lonjakan denda.

### 10. Optimasi SEO di Halaman Katalog Publik
**Masalah**: Halaman informasi detail buku (`/book/{slug}`) belum mempunyai meta-tag interaktif layaknya e-commerce atau perpustakaan modern.
**Solusi**: Tambahkan Open Graph (OG Meta Tags) agar ketika buku tersebut di-*share* ke WhatsApp atau Twitter, foto sampul buku dan sinopsis akan muncul.
