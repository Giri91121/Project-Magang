# Software Requirements Specification (SRS)

## Sistem Notifikasi Otomatis Srikandi–WhatsApp berbasis n8n dan Landing Page SIGAP BRIDA

Disusun oleh: Giri Kencana Jati (D121231089) dan Muh. Ilham Yusal (D121231065), Teknik Informatika Instansi: Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar Periode Kerja Praktik: 28 September 2026 – 28 Desember 2026 Dosen Pembimbing: Dr. Muhammad Abdillah Rahmat, S.T., M.T. Versi: 0.2 (Draf, mencakup jobdesc kedua mahasiswa) – 2 November 2026

## 1. Pendahuluan

### 1.1 Tujuan Dokumen

Dokumen ini menetapkan kebutuhan perangkat lunak untuk proyek SIGAP BRIDA yang dikerjakan bersama oleh Giri Kencana Jati (data, n8n, notifikasi, dan landing page) dan Muh. Ilham Yusal (infrastruktur, jaringan, deployment, dan pengujian kinerja), sebagaimana tertuang dalam Surat Kesepahaman Job Description Mahasiswa selama Kerja Praktik tertanggal 23 September 2026. Dokumen menjadi acuan perancangan, implementasi, pengujian, dan serah terima bagi mahasiswa, dosen pembimbing, serta tim IT BRIDA Kota Makassar.

### 1.2 Ruang Lingkup Produk

Produk terdiri dari tiga komponen utama:

1. **Alur otomasi notifikasi dokumen** (Giri): mengambil atribut teks dokumen/surat dari Srikandi, mengolahnya di n8n (filtering, formatting, pemetaan variabel), lalu mengirim notifikasi ke pegawai melalui WhatsApp Gateway berdasarkan status dokumen (surat baru, disposisi, verifikasi).
2. **Landing page SIGAP BRIDA** (Giri): situs informasi instansi berbasis Laravel yang menjelaskan layanan SIGAP BRIDA, cara kerja notifikasi, dan menyediakan panduan pengguna.
3. **Infrastruktur dan integrasi** (Ilham): analisis kebutuhan hosting dan server, lingkungan runtime n8n yang aktif berkelanjutan, konfigurasi jaringan, routing endpoint API, dan environment variables yang menghubungkan Srikandi dengan WhatsApp Gateway melalui n8n, deployment landing page Laravel ke server instansi, serta pengujian keandalan, latency, dan stabilitas.

**Pembagian tanggung jawab**: Giri Kencana Jati memiliki komponen 1 dan 2 (kode FR-SRK, FR-N8N, FR-WA, FR-WEB, FR-DOC). Muh. Ilham Yusal memiliki komponen 3 (kode FR-HOS, FR-RUN, FR-NET, FR-DEP, FR-ITS, FR-IDC). Kedua bagian saling bergantung: alur n8n dan landing page tidak dapat diuji ujung ke ujung tanpa infrastruktur, dan infrastruktur tidak bermakna tanpa alur yang berjalan di atasnya. Titik temu keduanya dirinci pada bagian 3 dan bagian 4.9.

### 1.3 Definisi, Akronim, dan Singkatan

| Istilah | Penjelasan |
| --- | --- |
| SIGAP BRIDA | Nama sistem/inisiatif yang dikembangkan di BRIDA Kota Makassar |
| Srikandi | Aplikasi umum kearsipan dinamis terintegrasi yang dipakai instansi untuk naskah dinas |
| n8n | Platform otomasi alur kerja (workflow automation) berbasis node |
| WhatsApp Gateway | Layanan/perantara yang memungkinkan sistem mengirim pesan WhatsApp melalui API (contoh: WAHA) |
| Webhook | Panggilan HTTP otomatis dari satu sistem ke sistem lain saat suatu peristiwa terjadi |
| Endpoint API | Alamat (URL) tempat suatu layanan menerima atau memberi data melalui HTTP |
| Environment variable | Nilai konfigurasi (URL, kunci API, kredensial) yang disimpan di luar kode |
| Runtime/environment | Lingkungan perangkat lunak tempat aplikasi berjalan (OS, Docker, PHP, Node.js, dan sejenisnya) |
| Reverse proxy / web server | Perangkat lunak (misalnya Nginx) yang menerima permintaan web dan meneruskannya ke aplikasi |
| Deployment | Proses memasang dan mengaktifkan aplikasi di server tujuan |
| Latency | Selang waktu antara pemicu (webhook) diterima dan hasilnya (permintaan atau pesan terkirim) selesai |
| Disposisi | Instruksi/arahan pimpinan terhadap surat masuk |
| Template pesan | Kerangka teks notifikasi dengan variabel yang diisi data dokumen |
| SRS | Software Requirements Specification |
| BRIDA | Badan Riset dan Inovasi Daerah |

### 1.4 Referensi

- Surat Kesepahaman Job Description Mahasiswa selama Kerja Praktik (Giri Kencana Jati, D121231089, dan Muh. Ilham Yusal, D121231065), 23 September 2026.
- IEEE Std 830-1998 / ISO/IEC/IEEE 29148:2018 (panduan struktur SRS).
- Dokumentasi resmi n8n, WhatsApp Gateway yang dipilih, dan Laravel.
- UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi.

### 1.5 Konvensi Penulisan

Kebutuhan diberi kode unik. FR = kebutuhan fungsional, NFR = non-fungsional, IF = antarmuka, DR = data. Prioritas memakai MoSCoW: **M** (Must), **S** (Should), **C** (Could). Hal yang belum pasti ditandai **\[Perlu konfirmasi\]**.

## 2. Deskripsi Umum

### 2.1 Perspektif Produk

Produk bukan sistem berdiri sendiri, melainkan lapisan integrasi di antara sistem yang sudah ada:

```
Srikandi --(webhook / polling)--> n8n --(HTTP API)--> WhatsApp Gateway --> WhatsApp pegawai
                                   |
                                   +-- pemetaan data, filter, template pesan (Giri)

Server instansi (Ilham): n8n + WhatsApp Gateway + web server + jaringan/HTTPS

Pengunjung --(HTTPS)--> Landing page SIGAP BRIDA (Laravel: dibangun Giri, di-deploy Ilham)
```

n8n bertindak sebagai orkestrator: menerima/menarik data dari Srikandi, menyaring dan memformat atribut teks, memilih template berdasarkan status dokumen, lalu memanggil API WhatsApp Gateway. Landing page berfungsi sebagai media informasi dan tidak wajib terhubung langsung ke alur n8n.

Seluruh komponen berjalan di atas infrastruktur server instansi yang disiapkan Ilham: server menjalankan n8n, WhatsApp Gateway, dan web server landing page, sedangkan jaringan menghubungkannya dengan Srikandi dan internet sesuai kebijakan instansi.

### 2.2 Fungsi Utama Produk

- Menganalisis dan memetakan atribut teks dokumen Srikandi ke variabel data terstruktur.
- Memproses data (filter, normalisasi, format) di n8n menjadi variabel pesan siap kirim.
- Mengirim notifikasi WhatsApp otomatis berdasarkan status dokumen: surat baru, disposisi, verifikasi.
- Menyajikan landing page SIGAP BRIDA yang responsif dan informatif.
- Menyiapkan server dan runtime n8n agar webhook aktif berkelanjutan.
- Menghubungkan Srikandi dengan WhatsApp Gateway melalui n8n (jaringan, routing endpoint, environment variables).
- Memasang dan men-deploy landing page Laravel ke server instansi.
- Menguji keandalan koneksi API, latency webhook, dan stabilitas server.
- Menyediakan dokumentasi teknis (kode, pemetaan data, server, arsitektur integrasi), buku panduan pengguna, dan serah terima ke tim IT BRIDA.

### 2.3 Karakteristik Pengguna

| Pengguna | Peran | Kebutuhan utama |
| --- | --- | --- |
| Pegawai/penerima notifikasi | Menerima pesan WhatsApp | Pesan singkat, jelas, akurat, tidak spam |
| Pimpinan/pejabat | Memberi disposisi | Mengetahui surat masuk dan disposisi tepat waktu |
| Admin/operator Srikandi | Mengelola surat | Alur otomatis tidak mengganggu pekerjaan Srikandi |
| Tim IT BRIDA | Pengelola sistem | Dokumentasi jelas, konfigurasi mudah dipelihara |
| Pengunjung landing page | Publik/pegawai | Informasi layanan SIGAP BRIDA dan panduan |
| Mahasiswa pengembang (Giri: aplikasi dan data; Ilham: infrastruktur) | Membangun dan menguji | Spesifikasi terukur dan dapat diuji |

### 2.4 Batasan

- Periode pengerjaan dibatasi 28 September – 28 Desember 2026.
- Landing page wajib berbasis framework Laravel; pemrosesan data wajib melalui n8n.
- Infrastruktur server, deployment, dan konfigurasi jaringan dikerjakan oleh Muh. Ilham Yusal bersama tim IT BRIDA, dalam batas kebijakan jaringan dan keamanan instansi.
- Pengiriman WhatsApp mengikuti kebijakan WhatsApp; risiko pemblokiran nomor harus diperhatikan jika memakai gateway tidak resmi.
- Akses ke Srikandi bergantung pada izin dan mekanisme yang diberikan instansi.

### 2.5 Asumsi dan Ketergantungan

1. Tersedia cara programatik untuk memperoleh data dokumen Srikandi (API, ekspor data, notifikasi surel, atau mekanisme lain). **\[Perlu konfirmasi\]**
2. WhatsApp Gateway yang dipakai bebas dipilih (supervisor tidak menetapkan produk tertentu). Asumsi awal: WAHA yang dijalankan sendiri via Docker, dapat diganti tanpa mengubah logika pemetaan.
3. n8n berjalan stabil dan dapat menerima webhook, disiapkan oleh Muh. Ilham Yusal (lihat bagian 4.6).
4. Daftar penerima (pegawai) dan nomor WhatsApp-nya diberikan oleh BRIDA dengan persetujuan yang sesuai.
5. Konten landing page (profil, logo, teks) diberikan atau disetujui BRIDA.

## 3. Persyaratan Antarmuka Eksternal

| Kode | Antarmuka | Spesifikasi |
| --- | --- | --- |
| IF-01 | Srikandi → n8n | Data atribut dokumen diterima lewat webhook atau pengambilan terjadwal (polling). Format dan metode final ditetapkan setelah analisis (FR-SRK-01); jalur jaringan dan izin akses disiapkan melalui FR-NET-01. |
| IF-02 | n8n → WhatsApp Gateway | Permintaan HTTP ke endpoint kirim pesan teks dengan nomor tujuan berformat internasional (62…) dan isi pesan hasil template. URL dan kunci API disimpan sebagai environment variables (FR-NET-03). |
| IF-03 | Pengguna → landing page | Antarmuka web responsif melalui peramban modern (Chrome, Edge, Firefox, Safari versi terbaru) di desktop dan seluler, disajikan lewat web server instansi dengan HTTPS (FR-DEP-03). |
| IF-04 | Landing page → n8n (opsional) | Tidak wajib. Jika ada formulir kontak/umpan balik, dikirim lewat webhook n8n. |
| IF-05 | Operator → n8n | Antarmuka editor n8n untuk mengelola alur dan variabel; akses dibatasi akun berwenang. |
| IF-06 | Server instansi ↔ jaringan | Aturan firewall, port, domain/subdomain, dan sertifikat HTTPS untuk n8n dan landing page (FR-NET-01, FR-NET-02, FR-DEP-03). |
| IF-07 | WhatsApp Gateway → n8n (opsional) | Webhook balik berisi status pengiriman atau pesan masuk bila gateway mendukungnya; dilindungi token (FR-NET-04). |
| IF-08 | Administrator → server | Akses administrasi (SSH atau panel) terbatas pada akun berwenang milik Ilham dan tim IT BRIDA. |

## 4. Persyaratan Fungsional

### 4.1 Modul A – Analisis dan Pemetaan Data Srikandi (Jobdesc Giri 1)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-SRK-01 | Sistem/pengembang mengidentifikasi mekanisme perolehan data Srikandi (API, ekspor, notifikasi) dan mendokumentasikan pilihan beserta alasannya. | M |
| FR-SRK-02 | Pengembang menginventarisasi atribut teks dokumen/surat yang tersedia (misalnya nomor surat, tanggal, asal/pengirim, perihal, sifat, tujuan, status, catatan disposisi). | M |
| FR-SRK-03 | Pengembang menyusun tabel pemetaan: atribut Srikandi → nama variabel n8n → variabel template pesan, termasuk tipe data dan aturan pembersihan. | M |
| FR-SRK-04 | Pengembang menentukan atribut yang boleh dan tidak boleh dikirim melalui WhatsApp (prinsip minimisasi data). | M |
| FR-SRK-05 | Pengembang mendefinisikan contoh data sampel (dianonimkan) untuk keperluan pengujian. | S |

### 4.2 Modul B – Pemrosesan Data di n8n (Jobdesc Giri 3)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-N8N-01 | Alur n8n menerima data dokumen dari Srikandi sesuai IF-01 dan memvalidasi kelengkapan atribut wajib. | M |
| FR-N8N-02 | Alur menyaring (filter) dokumen berdasarkan kriteria: status dokumen, jenis kejadian (surat baru/disposisi/verifikasi), dan penerima. | M |
| FR-N8N-03 | Alur membersihkan dan memformat teks: memangkas spasi berlebih, menormalkan huruf, memformat tanggal ke format Indonesia (contoh: 2 November 2026), dan memotong perihal yang terlalu panjang dengan elipsis. | M |
| FR-N8N-04 | Alur membentuk objek variabel pesan terstruktur (misalnya nomor\_surat, asal, perihal, tanggal, status, tujuan) sesuai tabel pemetaan FR-SRK-03. | M |
| FR-N8N-05 | Alur menangani data tidak lengkap atau tidak valid: menandai, mencatat log, dan tidak mengirim pesan berisi variabel kosong. | M |
| FR-N8N-06 | Alur mencegah pengiriman ganda untuk dokumen dan status yang sama (deduplikasi berdasarkan kunci unik, misalnya nomor surat + status). | S |
| FR-N8N-07 | Alur memetakan penerima ke nomor WhatsApp melalui tabel referensi yang mudah diperbarui tanpa mengubah logika alur. | S |
| FR-N8N-08 | Alur mencatat log setiap eksekusi (berhasil/gagal, waktu, jenis notifikasi) tanpa menyimpan isi surat lengkap. | S |
| FR-N8N-09 | Alur memberi notifikasi galat kepada admin bila pengiriman gagal setelah percobaan ulang. | C |

### 4.3 Modul C – Template Notifikasi WhatsApp Berbasis Status (Jobdesc Giri 4)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-WA-01 | Sistem menyediakan template **Surat Baru** yang dikirim saat surat masuk baru tercatat untuk penerima terkait. | M |
| FR-WA-02 | Sistem menyediakan template **Disposisi** yang dikirim saat ada disposisi baru, memuat pemberi disposisi dan inti instruksi singkat. | M |
| FR-WA-03 | Sistem menyediakan template **Verifikasi** yang dikirim saat dokumen membutuhkan atau telah melewati verifikasi. | M |
| FR-WA-04 | Pemilihan template dilakukan otomatis oleh logika percabangan (switch/if) berdasarkan status dokumen; status tak dikenal ditangani dengan jalur cadangan (fallback) tanpa mengirim pesan salah. | M |
| FR-WA-05 | Setiap pesan memuat identitas pengirim sistem (SIGAP BRIDA) dan tidak memuat isi surat lengkap atau lampiran. | M |
| FR-WA-06 | Setiap template memakai variabel dari FR-N8N-04 dan dapat diubah teksnya tanpa mengubah logika percabangan. | S |
| FR-WA-07 | Pengiriman ke banyak penerima diberi jeda antarpesan untuk menghindari pembatasan dari WhatsApp. | S |
| FR-WA-08 | Template tambahan untuk status lain (misalnya pengingat surat belum ditindaklanjuti) dapat ditambahkan. | C |

Contoh draf template (final disepakati dengan BRIDA):

```
[SIGAP BRIDA] Surat Baru
No. Surat : {{nomor_surat}}
Dari      : {{asal}}
Perihal   : {{perihal}}
Tanggal   : {{tanggal}}
Silakan cek di Srikandi.
```

### 4.4 Modul D – Landing Page SIGAP BRIDA berbasis Laravel (Jobdesc Giri 2)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-WEB-01 | Pengembang merancang UI/UX (wireframe dan mockup) halaman landing, disetujui BRIDA sebelum implementasi penuh. | M |
| FR-WEB-02 | Landing page memuat bagian: Beranda (hero dan ajakan tindakan), Tentang SIGAP BRIDA, Fitur/Layanan, Cara Kerja Notifikasi, Panduan Pengguna, FAQ, dan Kontak/Profil Instansi. | M |
| FR-WEB-03 | Halaman memakai identitas visual BRIDA Kota Makassar (logo, warna, tipografi) yang konsisten. | M |
| FR-WEB-04 | Halaman responsif pada layar desktop, tablet, dan ponsel. | M |
| FR-WEB-05 | Navigasi dan tautan antarbagian berfungsi; terdapat tautan unduh buku panduan pengguna (PDF). | M |
| FR-WEB-06 | Struktur kode mengikuti konvensi Laravel (routes, controller, Blade view, aset terkompilasi) agar mudah dipelihara tim IT. | M |
| FR-WEB-07 | Konten teks dikelola terpusat (berkas Blade/konfigurasi atau basis data sederhana) agar mudah diubah. | S |
| FR-WEB-08 | Formulir kontak/umpan balik dengan validasi sisi server dan perlindungan CSRF. | C |
| FR-WEB-09 | Meta SEO dasar (judul, deskripsi, tag Open Graph). | C |

Catatan: pemasangan web server dan deployment ke server instansi dikerjakan Muh. Ilham Yusal (lihat FR-DEP-01 s.d. FR-DEP-05); modul ini bertanggung jawab atas kode yang siap dideploy dan berkas instruksi build.

### 4.5 Modul E – Dokumentasi dan Serah Terima (Jobdesc Giri 6)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-DOC-01 | Dokumentasi source code Laravel: struktur proyek, cara instalasi lokal, variabel lingkungan (.env.example), perintah build dan migrasi, serta komentar kode pada bagian penting. | M |
| FR-DOC-02 | Panduan pemetaan data n8n: diagram alur, tabel pemetaan atribut Srikandi → variabel, penjelasan setiap node penting, dan cara menambah template/status baru. | M |
| FR-DOC-03 | Buku panduan pengguna untuk pegawai/operator: apa itu notifikasi, jenis pesan, apa yang dilakukan bila pesan salah/tidak datang. | M |
| FR-DOC-04 | Ekspor alur n8n (berkas JSON) disertakan dalam serah terima, tanpa kredensial. | M |
| FR-DOC-05 | Sesi serah terima kepada tim IT BRIDA disertai berita acara. | M |
| FR-DOC-06 | Panduan pemecahan masalah umum (troubleshooting). | S |

### 4.6 Modul F – Infrastruktur, Runtime n8n, Jaringan, dan Deployment (Jobdesc Ilham 1–4)

Modul ini dimiliki Muh. Ilham Yusal dan menjadi fondasi bagi seluruh modul Giri: tanpa server, runtime, dan jaringan yang siap, alur n8n dan landing page tidak dapat berjalan di instansi.

| Kode | Kebutuhan | Prioritas | Jobdesc |
| --- | --- | --- | --- |
| FR-HOS-01 | Menganalisis kebutuhan sumber daya (CPU, RAM, penyimpanan, bandwidth) untuk n8n, WhatsApp Gateway, dan landing page Laravel; hasilnya kriteria server minimum dan rekomendasi. | M | 1 |
| FR-HOS-02 | Membandingkan opsi hosting (server instansi, VPS, hosting bersama) menurut kebutuhan, biaya, keamanan, dan kebijakan instansi, lalu memilih satu opsi bersama BRIDA. | M | 1 |
| FR-HOS-03 | Mendaftar perangkat lunak server yang dibutuhkan: sistem operasi, Docker/Docker Compose (atau Node.js), PHP beserta ekstensi Laravel, Composer, web server (Nginx/Apache), dan basis data bila perlu. | M | 1 |
| FR-RUN-01 | Memasang dan mengonfigurasi n8n di server (disarankan Docker Compose) dengan penyimpanan data yang persisten. | M | 2 |
| FR-RUN-02 | n8n dan WhatsApp Gateway hidup kembali otomatis setelah server restart atau proses gagal (restart policy atau service manager). | M | 2 |
| FR-RUN-03 | Webhook n8n dapat dijangkau terus-menerus pada URL produksi yang tetap (bukan URL mode uji). | M | 2 |
| FR-RUN-04 | Lingkungan produksi dipisahkan dari lingkungan pengembangan Giri; alur dipindahkan lewat impor/ekspor berkas JSON. | S | 2 |
| FR-RUN-05 | Zona waktu server dan n8n diatur ke Asia/Makassar (WITA) agar tanggal dan jam pada notifikasi benar. | S | 2 |
| FR-RUN-06 | Data dan konfigurasi n8n dicadangkan berkala, dan pemulihannya diuji sekali sebelum serah terima. | S | 2 |
| FR-NET-01 | Menyiapkan jalur jaringan, izin akses, dan aturan firewall bersama tim IT BRIDA agar n8n menerima/mengambil data Srikandi sesuai IF-01. | M | 3 |
| FR-NET-02 | Menetapkan dan mendokumentasikan routing endpoint API: URL webhook n8n, endpoint gateway, reverse proxy, dan sertifikat HTTPS. | M | 3 |
| FR-NET-03 | Mengelola environment variables (URL, token/kunci API, nomor pengirim, kredensial) di luar kode; disediakan contoh berkas tanpa nilai rahasia. | M | 3 |
| FR-NET-04 | Mengamankan endpoint webhook (token atau header rahasia, pembatasan IP bila memungkinkan) agar hanya sumber sah yang dapat memicu alur. | M | 3 |
| FR-NET-05 | Menyerahkan kontrak endpoint (URL, metode, header, contoh payload) kepada Giri sebelum alur n8n diimplementasikan (INT-01). | M | 3 |
| FR-DEP-01 | Memasang dan mengonfigurasi web server dengan PHP dan ekstensi yang dibutuhkan Laravel. | M | 4 |
| FR-DEP-02 | Men-deploy landing page hasil Giri: ambil kode, composer install, build aset, .env produksi, application key, mode debug nonaktif, izin berkas, cache konfigurasi dan rute. | M | 4 |
| FR-DEP-03 | Mengaktifkan HTTPS serta mengatur domain atau subdomain landing page. | M | 4 |
| FR-DEP-04 | Menyediakan prosedur pembaruan (redeploy) dan pemulihan ke versi sebelumnya (rollback) yang sederhana. | S | 4 |
| FR-DEP-05 | Log aplikasi dan web server tersimpan dan dirotasi, tanpa memuat isi surat atau kredensial. | S | 4 |

### 4.7 Modul G – Pengujian Koneksi API, Latency, dan Stabilitas (Jobdesc Ilham 5)

Pengujian ini memastikan jalur Srikandi–n8n–WhatsApp Gateway andal saat memproses data otomatis. Angka beban dan waktu adalah usulan awal dan perlu disepakati dengan BRIDA.

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-ITS-01 | Endpoint testing: webhook n8n, API gateway, dan landing page diuji dengan permintaan sah dan tidak sah (token salah, payload kosong atau rusak, metode salah); hasil dicatat. | M |
| FR-ITS-02 | Evaluasi latency: mengukur waktu webhook diterima hingga permintaan ke gateway selesai, dan dari pemicu hingga pesan tiba di WhatsApp, minimal 50 percobaan; dilaporkan rata-rata, median, persentil 95, dan maksimum. | M |
| FR-ITS-03 | Uji stabilitas beban: 100 dokumen berurutan dan lonjakan 20 dokumen dalam 1 menit, sambil memantau CPU, RAM, disk, dan kegagalan. | M |
| FR-ITS-04 | Uji ketahanan: restart server, gateway dimatikan sementara, dan koneksi diputus; sistem pulih sesuai FR-RUN-02 dan NFR-03. | M |
| FR-ITS-05 | Uji jalan panjang (soak): alur berjalan minimal 72 jam tanpa intervensi. | S |
| FR-ITS-06 | Seluruh hasil dilaporkan beserta rekomendasi penyetelan (konfigurasi, sumber daya, jeda kirim). | M |

### 4.8 Modul H – Dokumentasi Infrastruktur dan Serah Terima (Jobdesc Ilham 6)

| Kode | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-IDC-01 | Dokumentasi teknis konfigurasi server: spesifikasi, versi perangkat lunak, struktur direktori, konfigurasi web server dan reverse proxy, port, aturan firewall, dan jadwal backup. | M |
| FR-IDC-02 | Dokumentasi arsitektur integrasi n8n: diagram arsitektur, alur data Srikandi → n8n → gateway, daftar endpoint, dan daftar environment variables (tanpa nilai rahasia). | M |
| FR-IDC-03 | Panduan operasional: menjalankan/menghentikan/memulai ulang layanan, cek kesehatan, membaca log, backup dan restore, serta pembaruan versi n8n dan gateway. | M |
| FR-IDC-04 | Serah terima ke tim IT BRIDA: sesi serah terima, penyerahan akses dan kredensial lewat kanal aman, dan berita acara (digabung dengan FR-DOC-05, lihat INT-07). | M |
| FR-IDC-05 | Panduan pemecahan masalah infrastruktur (webhook tidak masuk, gateway terputus, landing page galat). | S |

### 4.9 Kebutuhan Integrasi Bersama Giri dan Ilham

Pekerjaan kedua mahasiswa bertemu di delapan titik berikut; setiap titik punya penyedia, penerima, dan keluaran yang jelas.

| Kode | Titik temu | Penyedia → Penerima | Kebutuhan |
| --- | --- | --- | --- |
| INT-01 | Kontrak endpoint webhook | Ilham → Giri | URL, metode, header/token, dan contoh payload diserahkan sebelum alur n8n diimplementasikan. |
| INT-02 | Akses data Srikandi | Ilham dan Giri | Ilham menyiapkan jalur jaringan dan izin; Giri menentukan atribut dan format data (FR-SRK-01). |
| INT-03 | Environment variables | Ilham → Giri | Daftar variabel (URL gateway, kunci API, token webhook) disepakati bersama; Giri memakainya tanpa menulis nilai rahasia di alur. |
| INT-04 | Artefak deployment landing page | Giri → Ilham | Kode, .env.example, instruksi build, dan versi PHP/Node yang dibutuhkan. |
| INT-05 | Ekspor alur n8n | Giri → Ilham | Berkas JSON alur tanpa kredensial untuk diimpor ke n8n produksi. |
| INT-06 | Data uji bersama | Giri → Ilham | Data sampel yang dianonimkan dipakai untuk uji latency dan stabilitas (FR-ITS-02, FR-ITS-03) dan uji validasi data (TC-DATA). |
| INT-07 | Serah terima gabungan | Giri dan Ilham → Tim IT BRIDA | Satu sesi, satu paket dokumentasi (FR-DOC dan FR-IDC), dan satu berita acara. |
| INT-08 | Pengelolaan perubahan | Giri dan Ilham | Perubahan kontrak endpoint, atribut data, atau template diberitahukan ke pihak lain dan dicatat pada versi SRS. |

Urutan kerja yang disarankan:

1. Ilham menetapkan server, menyiapkan n8n, dan menyerahkan kontrak endpoint (FR-HOS, FR-RUN, FR-NET-05).
2. Giri membangun alur n8n, template WhatsApp, dan landing page di lingkungan pengembangan.
3. Ilham menyambungkan jaringan ke Srikandi dan men-deploy landing page (FR-NET-01, FR-DEP).
4. Keduanya menjalankan uji ujung ke ujung: Giri menguji data, template, dan web; Ilham menguji koneksi, latency, dan stabilitas.
5. Keduanya menyusun dokumentasi dan melakukan serah terima bersama.

## 5. Persyaratan Data

### 5.1 Tabel Pemetaan Awal (Draf)

Atribut final bergantung pada hasil FR-SRK-01 dan FR-SRK-02. **\[Perlu konfirmasi\]**

| Atribut Srikandi (asumsi) | Variabel n8n | Dikirim ke WA? | Aturan pemrosesan |
| --- | --- | --- | --- |
| Nomor naskah/surat | nomor\_surat | Ya | Dipertahankan apa adanya, hapus spasi ganda |
| Tanggal naskah | tanggal | Ya | Format tanggal Indonesia |
| Asal/pengirim | asal | Ya | Rapikan huruf kapital |
| Perihal | perihal | Ya | Maksimal ±120 karakter, potong dengan elipsis |
| Tujuan/penerima | penerima | Tidak (dipakai untuk routing) | Dipetakan ke nomor WA |
| Sifat surat (biasa/penting/rahasia) | sifat | Bergantung kebijakan | Surat rahasia tidak menampilkan perihal |
| Status | status | Ya (menentukan template) | Dinormalisasi ke: surat\_baru, disposisi, verifikasi |
| Isi disposisi | isi\_disposisi | Ringkas saja | Maksimal ±100 karakter |
| Lampiran/isi surat lengkap | – | Tidak | Tidak dikirim |

### 5.2 Penyimpanan Data

Sistem tidak menyimpan arsip surat. Data yang disimpan terbatas pada log eksekusi (tanggal/waktu, jenis notifikasi, status kirim, kunci dokumen) dan tabel referensi penerima–nomor WhatsApp.

Konfigurasi infrastruktur (environment variables, kredensial, kunci API) disimpan terpisah dari kode dan tidak dimasukkan ke dokumentasi serah terima; dokumentasi hanya memuat daftar nama variabel dan contoh tanpa nilai rahasia.

## 6. Persyaratan Non-Fungsional

| Kode | Kategori | Kebutuhan | Cara verifikasi |
| --- | --- | --- | --- |
| NFR-01 | Kinerja | Pemrosesan di n8n (dari data diterima hingga permintaan ke gateway selesai) selesai ≤ 10 detik per dokumen pada kondisi normal. Target total hingga pesan terkirim ≤ 60 detik, diukur pada FR-ITS-02. | Pengukuran waktu eksekusi n8n dan uji latency |
| NFR-02 | Kinerja web | Halaman landing termuat penuh ≤ 3 detik pada koneksi broadband; ukuran gambar dioptimalkan. | Uji Lighthouse/PageSpeed |
| NFR-03 | Keandalan | Kegagalan kirim dicoba ulang otomatis hingga 3 kali dengan jeda bertahap; kegagalan akhir dicatat. | Uji skenario gateway mati |
| NFR-04 | Akurasi | 100% variabel pesan sesuai data asli Srikandi pada set uji; tidak ada variabel kosong terkirim. | Uji validasi data (bagian 8) |
| NFR-05 | Keamanan | Kredensial, token API, dan kunci disimpan di environment variables/credential store n8n, tidak di kode atau repositori. | Tinjauan kode |
| NFR-06 | Keamanan web | Akses HTTPS; perlindungan CSRF dan XSS bawaan Laravel aktif; mode debug nonaktif di produksi. | Daftar periksa deployment |
| NFR-07 | Privasi | Pesan WA hanya memuat metadata minimum; nomor pegawai diperlakukan sebagai data pribadi dan akses tabel dibatasi. | Tinjauan data dan akses |
| NFR-08 | Kemudahan pemeliharaan | Template dan tabel penerima dapat diubah tanpa mengubah logika alur; node n8n diberi nama deskriptif. | Tinjauan alur |
| NFR-09 | Portabilitas | Gateway dapat diganti dengan perubahan terbatas pada satu node/konfigurasi. | Uji penggantian konfigurasi |
| NFR-10 | Kegunaan | Pesan WA maksimal ±8 baris, bahasa Indonesia baku, mudah dipindai. | Uji pengguna singkat |
| NFR-11 | Kompatibilitas | Landing page berfungsi di peramban modern dan layar minimal 360 px. | Uji lintas peramban/perangkat |
| NFR-12 | Aksesibilitas | Kontras warna memadai, teks alternatif pada gambar, ukuran huruf terbaca. | Daftar periksa aksesibilitas |
| NFR-13 | Ketersediaan | n8n dan webhook aktif ≥ 99% pada jam kerja (usulan: Senin–Jumat, 08.00–16.00 WITA) selama masa uji. | Pemantauan selama uji stabilitas (FR-ITS-03, FR-ITS-05) |
| NFR-14 | Pemulihan | Setelah server restart, n8n dan gateway aktif kembali otomatis ≤ 5 menit. | TC-INF-04 |
| NFR-15 | Keamanan jaringan | Hanya port yang diperlukan terbuka; endpoint webhook memakai token; akses administrasi terbatas akun berwenang. | Daftar periksa firewall dan endpoint testing |
| NFR-16 | Pencadangan | Data dan konfigurasi n8n dicadangkan minimal mingguan; pemulihan diuji sekali sebelum serah terima. | Bukti backup dan restore |
| NFR-17 | Kapasitas | Sistem memproses lonjakan 20 dokumen per menit tanpa pesan hilang atau ganda. | TC-INF-03 |

## 7. Alur Utama (Skenario)

**Skenario 1 – Surat baru**

1. Surat masuk tercatat di Srikandi dan ditujukan ke pegawai/unit tertentu.
2. Data atribut sampai ke n8n (webhook atau polling).
3. n8n memvalidasi, menyaring, dan memformat atribut menjadi variabel pesan.
4. Logika percabangan memilih template Surat Baru.
5. n8n memetakan penerima ke nomor WhatsApp dan memanggil gateway.
6. Pegawai menerima pesan; hasil dicatat di log.

**Skenario 2 – Disposisi**

Sama seperti Skenario 1, dengan status disposisi: template Disposisi memuat pemberi dan ringkasan instruksi, dikirim ke pihak yang menerima disposisi.

**Skenario 3 – Verifikasi**

Sama seperti Skenario 1, dengan status verifikasi: template Verifikasi dikirim ke pihak yang bertugas memverifikasi.

**Skenario 4 – Data tidak lengkap atau status tak dikenal**

Pesan tidak dikirim; kejadian dicatat dan, bila tersedia, admin diberi tahu (FR-N8N-05, FR-WA-04, FR-N8N-09).

**Skenario 5 – Pengunjung membuka landing page**

Pengunjung membuka halaman, membaca penjelasan SIGAP BRIDA, mengunduh buku panduan, dan menghubungi instansi lewat kontak yang tersedia.

**Skenario 6 – Pemulihan setelah gangguan**

Server restart atau gateway terputus saat dokumen baru masuk. Layanan n8n dan gateway hidup kembali otomatis (FR-RUN-02), pengiriman dicoba ulang (NFR-03), dan tidak ada pesan ganda (FR-N8N-06); kejadian tercatat di log.

## 8. Strategi Pengujian dan Kriteria Penerimaan (Jobdesc Giri 5 dan Jobdesc Ilham 5)

### 8.1 Pengujian Validasi Data Teks

| Kode | Uji | Kriteria lulus |
| --- | --- | --- |
| TC-DATA-01 | Cocokkan setiap variabel pesan WA dengan data asli di Srikandi untuk minimal 30 sampel dokumen (campuran surat baru, disposisi, verifikasi). | Seluruh variabel identik/ekuivalen dengan data asli |
| TC-DATA-02 | Uji data tepi: perihal sangat panjang, karakter khusus, tanpa perihal, tanggal tidak lazim. | Tidak ada galat; pemotongan dan fallback benar |
| TC-DATA-03 | Uji status tak dikenal dan atribut wajib kosong. | Pesan tidak terkirim, log tercatat |
| TC-DATA-04 | Uji deduplikasi: kirim data yang sama dua kali. | Hanya satu pesan terkirim |
| TC-DATA-05 | Uji surat berstatus rahasia. | Perihal tidak ditampilkan sesuai FR-SRK-04 |

### 8.2 Pengujian Template dan Pengiriman

| Kode | Uji | Kriteria lulus |
| --- | --- | --- |
| TC-WA-01..03 | Kirim masing-masing template (surat baru, disposisi, verifikasi) ke nomor uji. | Pesan sesuai template dan terbaca benar di WhatsApp |
| TC-WA-04 | Gateway dimatikan saat pengiriman. | Percobaan ulang berjalan; kegagalan dicatat |
| TC-WA-05 | Kirim ke beberapa penerima sekaligus. | Semua terkirim dengan jeda, tanpa duplikat |

### 8.3 Pengujian Antarmuka Web Laravel

| Kode | Uji | Kriteria lulus |
| --- | --- | --- |
| TC-WEB-01 | Uji fungsional seluruh tautan, navigasi, dan unduhan panduan. | Tidak ada tautan rusak |
| TC-WEB-02 | Uji responsif pada desktop, tablet, ponsel (≥ 360 px). | Tata letak tidak pecah |
| TC-WEB-03 | Uji lintas peramban (Chrome, Edge, Firefox, Safari). | Tampilan dan fungsi konsisten |
| TC-WEB-04 | Uji kinerja dan aksesibilitas dasar (Lighthouse). | Memenuhi NFR-02 dan NFR-12 |
| TC-WEB-05 | Uji penerimaan pengguna (UAT) oleh perwakilan BRIDA. | Disetujui tertulis |

### 8.4 Pengujian Infrastruktur dan Integrasi (Jobdesc Ilham 5)

| Kode | Uji | Kriteria lulus |
| --- | --- | --- |
| TC-INF-01 | Endpoint testing webhook n8n dan API gateway dengan permintaan sah dan tidak sah. | Respons sesuai spesifikasi; permintaan tanpa token ditolak |
| TC-INF-02 | Latency: minimal 50 percobaan dari pemicu hingga pesan terkirim. | Median dan persentil 95 tercatat; pemrosesan n8n ≤ 10 detik dan total ≤ 60 detik (NFR-01) |
| TC-INF-03 | Beban: 100 dokumen berurutan dan lonjakan 20 dokumen dalam 1 menit. | Tidak ada pesan hilang atau ganda; CPU dan RAM di bawah batas yang disepakati (usulan: 80%) |
| TC-INF-04 | Restart server dan restart proses n8n/gateway. | Layanan aktif otomatis dan webhook kembali menerima ≤ 5 menit (NFR-14) |
| TC-INF-05 | Gateway dimatikan lalu dihidupkan saat dokumen masuk. | Pengiriman dicoba ulang; tidak ada duplikat |
| TC-INF-06 | Soak 72 jam tanpa intervensi. | Tidak ada galat berulang; ketersediaan sesuai NFR-13 |
| TC-INF-07 | Daftar periksa deployment landing page. | Terakses lewat HTTPS, mode debug nonaktif, log bersih dari galat |
| TC-INT-01 | Uji ujung ke ujung gabungan: dokumen sampel di Srikandi → pesan WhatsApp di server produksi. | Seluruh jalur berjalan; variabel pesan sesuai data asli |

### 8.5 Kriteria Penerimaan Keseluruhan

Proyek dinyatakan selesai jika: seluruh kebutuhan prioritas M terpenuhi dan lulus uji; tiga template notifikasi bekerja otomatis berdasarkan status; landing page lolos UAT dan terpasang di server instansi; n8n aktif menerima webhook secara berkelanjutan sesuai hasil uji stabilitas (TC-INF); dokumentasi (FR-DOC-01 s.d. FR-DOC-05 dan FR-IDC-01 s.d. FR-IDC-04) diserahkan; dan berita acara serah terima ditandatangani pihak BRIDA.

## 9. Matriks Keterlacakan Jobdesc

| Pemilik | No. | Jobdesc (Surat Kesepahaman) | Kebutuhan terkait |
| --- | --- | --- | --- |
| Giri | 1 | Menganalisis struktur data dan atribut teks Srikandi untuk ekstraksi dan pemetaan otomatis | FR-SRK-01..05, bagian 5 |
| Giri | 2 | Merancang UI/UX dan mengembangkan landing page SIGAP BRIDA berbasis Laravel | FR-WEB-01..09, NFR-02, 06, 11, 12 |
| Giri | 3 | Mengonfigurasi logika pemrosesan data n8n (filter, format, variabel pesan) | FR-N8N-01..09, NFR-01, 04, 08 |
| Giri | 4 | Membangun template logika notifikasi WhatsApp berdasarkan status dokumen | FR-WA-01..08, NFR-09, 10 |
| Giri | 5 | Pengujian validasi data teks dan antarmuka web Laravel | bagian 8.1–8.3 (TC-DATA, TC-WA, TC-WEB) |
| Giri | 6 | Dokumentasi kode Laravel, panduan pemetaan n8n, buku panduan, serah terima | FR-DOC-01..06, INT-07 |
| Ilham | 1 | Menganalisis kebutuhan infrastruktur hosting dan kriteria server untuk n8n dan landing page | FR-HOS-01..03, NFR-13 |
| Ilham | 2 | Mengonfigurasi runtime dan server n8n agar webhook aktif berkelanjutan | FR-RUN-01..06, NFR-13, 14, 16 |
| Ilham | 3 | Mengelola jaringan, routing endpoint API, dan environment variables untuk menghubungkan Srikandi dengan WhatsApp Gateway via n8n | FR-NET-01..05, IF-01, 02, 06, 07, NFR-05, 15, INT-01..03 |
| Ilham | 4 | Instalasi, konfigurasi web server, dan deployment landing page Laravel ke server instansi | FR-DEP-01..05, NFR-06, INT-04 |
| Ilham | 5 | Pengujian keandalan koneksi API, latency webhook, dan stabilitas server | FR-ITS-01..06, bagian 8.4 (TC-INF), NFR-01, 03, 17 |
| Ilham | 6 | Dokumentasi teknis server, arsitektur integrasi n8n, dan serah terima ke tim IT | FR-IDC-01..05, INT-07 |

## 10. Rencana Jadwal (Usulan)

| Fase | Periode | Giri | Ilham |
| --- | --- | --- | --- |
| 1. Analisis dan pembelajaran | 28 Sep – 25 Okt 2026 | Inventarisasi atribut Srikandi; belajar n8n dan gateway; SRS v1.0 | Analisis kebutuhan hosting dan kriteria server; belajar Docker dan n8n |
| 2. Perancangan | 26 Okt – 8 Nov 2026 | Tabel pemetaan, desain alur n8n, wireframe/mockup UI | Pilihan hosting, rancangan jaringan dan endpoint, kontrak endpoint (INT-01) |
| 3. Implementasi | 9 Nov – 6 Des 2026 | Alur n8n dan template WA; landing page Laravel | Server dan n8n produksi, jaringan, environment variables, deployment landing page |
| 4. Pengujian | 7 – 20 Des 2026 | Uji validasi data, template, web, dan UAT | Uji endpoint, latency, stabilitas, ketahanan |
| 5. Dokumentasi dan serah terima | 14 – 28 Des 2026 | Dokumentasi kode, panduan pemetaan n8n, buku panduan | Dokumentasi server dan arsitektur integrasi; serah terima gabungan (INT-07) |

Jadwal disesuaikan dengan kemajuan aktual dan koordinasi antara Giri dan Ilham; titik temu mengikuti INT-01 sampai INT-08.

## 11. Risiko dan Pertanyaan Terbuka

### 11.1 Risiko

| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Akses data Srikandi tidak tersedia atau terbatas | Alur ekstraksi tidak dapat otomatis penuh | Tentukan alternatif sejak dini (ekspor terjadwal, notifikasi surel, input semi-otomatis); gunakan data sampel untuk pengembangan |
| Gateway WhatsApp tidak resmi berisiko pemblokiran nomor | Notifikasi terhenti | Gunakan nomor khusus, jeda kirim, volume rendah; pertimbangkan API resmi bila anggaran ada |
| Kebocoran informasi surat melalui WA | Pelanggaran kerahasiaan | Minimisasi data (FR-SRK-04, NFR-07), aturan khusus surat rahasia |
| Pekerjaan satu pihak terlambat atau terhalang | Keterlambatan pengujian ujung ke ujung | Pengembangan lokal dengan Docker; sinkronisasi rutin; kontrak endpoint lebih dulu (INT-01) |
| Pembelajaran teknologi memakan waktu | Mundurnya implementasi | Prioritaskan prioritas M; tunda prioritas C |
| Server belum tersedia atau spesifikasinya kurang | n8n dan landing page tidak dapat dideploy tepat waktu | Tetapkan opsi hosting pada fase 1; siapkan cadangan (VPS sementara atau Docker lokal) |
| Kebijakan jaringan atau firewall instansi memblokir koneksi ke Srikandi atau gateway | Alur tidak dapat berjalan di produksi | Ajukan izin akses ke tim IT BRIDA sejak awal; sediakan jalur alternatif yang disetujui |
| Webhook tidak aktif setelah server restart | Notifikasi terlewat | Restart policy otomatis (FR-RUN-02), pemantauan, uji FR-ITS-04 |
| Kontrak endpoint, atribut, atau template berubah tanpa pemberitahuan | Alur rusak | Catat perubahan (INT-08); ulangi uji ujung ke ujung |
| Kredensial atau kunci API bocor | Gateway disalahgunakan | Simpan di environment variables, jangan masuk repositori, ganti kunci saat serah terima |

### 11.2 Pertanyaan yang Perlu Dikonfirmasi ke BRIDA/Dosen Pembimbing

1. Dengan cara apa data dokumen dapat diperoleh dari Srikandi (API, ekspor, notifikasi, atau lainnya)?
2. Atribut dokumen apa yang boleh dikirim melalui WhatsApp, dan bagaimana perlakuan surat berklasifikasi rahasia?
3. Siapa penerima tiap jenis notifikasi dan siapa yang menyediakan serta memperbarui daftar nomor WhatsApp?
4. Apakah landing page bersifat publik atau hanya internal, dan apakah perlu halaman administrasi untuk mengubah konten?
5. Apakah terdapat pedoman identitas visual (logo, warna) dan domain/subdomain untuk SIGAP BRIDA?
6. Siapa yang menyetujui UAT dan menandatangani berita acara serah terima?
7. Server mana yang disediakan (milik instansi, VPS, atau lainnya), berapa spesifikasinya, dan siapa pemiliknya?
8. Domain atau subdomain dan sertifikat HTTPS apa yang dipakai untuk n8n dan landing page, dan apakah n8n boleh diakses dari internet publik?
9. Adakah kebijakan firewall atau pembatasan IP yang harus diikuti, dan siapa kontak tim IT yang memberi izin akses ke Srikandi?
10. Siapa yang mengelola server dan backup setelah masa magang berakhir?

## 12. Persetujuan

| Peran | Nama | Tanda tangan / Tanggal |
| --- | --- | --- |
| Mahasiswa (aplikasi dan data) | Giri Kencana Jati |  |
| Mahasiswa (infrastruktur) | Muh. Ilham Yusal |  |
| Dosen Pembimbing | Dr. Muhammad Abdillah Rahmat, S.T., M.T. |  |
| Perwakilan BRIDA Kota Makassar |  |  |
| Tim IT BRIDA Kota Makassar (penerima serah terima) |  |  |
