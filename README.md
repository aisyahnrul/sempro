# SIPOLAR

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="220" alt="Laravel Logo">
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Project-Tugas%20Magang%20-blue?style=for-the-badge" alt="Tugas Magang"></a>
  <a href="#"><img src="https://img.shields.io/badge/Framework-Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/Status-Development-orange?style=for-the-badge" alt="Status"></a>
</p>

---

##  Deskripsi Project
Sistem Pengajuan Proposal Seminar Proposal(SEMPRO) ini dikembangkan sebagai pemenuhan tugas selama masa magang dengan studi dan kebutuhan analisis yang diberikan oleh mentor magang. Aplikasi ini berfokus pada pengajuan proposal sempro untuk meningkatkan efisiensi proses operasional.

---

##  Fitur Utama
-  **Hak Akses & Fitur Multi-Role:**

    Sistem **SIPOLAR** (Sistem Pengajuan Proposal SEMPRO) menyediakan tampilan dashboard dan hak akses khusus untuk 3             pengguna:
    
    ### 1. Role Admin / Prodi (Pengelola Sistem)
    * **Dashboard Overview:** Ringkasan pusat untuk memantau alur pengajuan proposal, beban bimbingan dosen, serta status            penjadwalan seminar.
    * **Fitur Utama:**
      * **Monitoring Pengajuan:** Memantau status seluruh proposal mahasiswa yang masuk secara *real-time*.
      * **Manajemen Dosen Pembimbing:** Menentukan dosen pembimbing bagi mahasiswa dan memantau kuota/beban bimbingan.
      * **Pengajuan Ganti Dosen:** Memproses dan memvalidasi permohonan pergantian dosen pembimbing dari mahasiswa.
      * **Kelola Data Master:** Mengatur master data Mahasiswa dan Dosen.
      * **Penjadwalan Sempro:** Menetapkan jadwal pelaksanaan Seminar Proposal bagi proposal yang telah disetujui.
    
    ---
    
    ### 2. Role Dosen Pembimbing
    * **Dashboard Overview:** Tampilan ringkas berisi daftar mahasiswa bimbingan yang ditugaskan beserta status progress            proposal masing-masing.
    * **Fitur Utama:**
      * **Monitoring Bimbingan:** Melihat detail profil, NIM, dan judul proposal mahasiswa bimbingan.
      * **Review Proposal:** Memantau dan meninjau berkas proposal mahasiswa pada setiap tahapan proses pengajuan.
    
    ---
    
    ### 3. Role Mahasiswa
    * **Dashboard Overview:** Pusat informasi mandiri untuk memantau alur pengajuan proposal, catatan revisi, hingga jadwal         seminar.
    * **Fitur Utama:**
      * **Ajukan Proposal:** Mengunggah dan mengajukan draf proposal sempro baru.
      * **Status Pengajuan:** Memantau posisi dan perkembangan proposal secara transparan.
      * **Komentar & Revisi:** Melihat catatan perbaikan dari dosen serta mengunggah kembali hasil revisi.
      * **Jadwal Sempro:** Melihat detail informasi waktu dan tempat pelaksanaan Seminar Proposal setelah ditetapkan prodi.
      * **Ganti Dosen Pembimbing:** Mengajukan permohonan pergantian dosen pembimbing jika diperlukan.

---

##  Tech Stack
* **Framework:** Laravel
* **Language:** PHP
* **Database:** MySQL
* **Frontend:** Blade, CSS
* **Tools:** Git, Composer, VS Code

---

##  Cara Menjalankan Project (Local Development)

Pastikan kamu sudah menginstal **PHP**, **Composer**, dan **MySQL** (XAMPP/Laragon).

1. **Clone repository ini:**
   ```bash
   git clone [https://github.com/aisyahnrul/sempro.git](https://github.com/aisyahnrul/sempro.git)
   cd sempro
