# Sistem-Informasi-IT-Helpdesk
 Sistem Informasi IT Helpdesk Berbasis Web - By Rifky Yusuf Mahfuz

 Untuk Layanan IT Helpdesk:
1. Pegawai
   Mengajukan:
 - Permintaan Instalasi Software
 - Permintaan Pengecekan Hardware

2. Admin
   Menindaklanjuti permintaan:
 - Menerima Permintaan Instalasi Software
 - Menerima Permintaan Pengecekan Hardware
  
 - Meminta persetujuan atau izin Manager untuk permintaan instalasi software
 - Meminta validasi rekomendasi hasil pengecekan hardware ke Manager

 - Membuat Berita Acara Serah Terima (BAST) Barang
   
3. Manager
 - Menyetujui, menolak, atau mengajukan revisi permintaan instalasi software
 - Validasi rekomendasi hasil pengecekan hardware

4. Superadmin 
 - Kelola data master dan data transaksi keseluruhan data di sistem.
 
Fitur Utama:
- Tanda tangan digital menggunakan SignaturePad
- Cetak Dokumen : Formulir Permintaan, BAST
- Notifikasi Realtime Setiap ada tindakan penting (perubahan status permintaan, akun, dll.)
- Reset Password via Email
- Notifikasi Penting via Email (Permintaan diterima, ditolak, permintaan selesai, dll.)


Specs:
- PHP 8.1.17
- Laravel 10

Account for Login: check on seeder

- Rename .env_example to .env
- Setup email (app password) sebelum menggunakan fitur notifikasi email SMTP
