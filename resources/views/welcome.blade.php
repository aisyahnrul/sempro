<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPOLAR — Sistem Pengajuan Proposal Sempro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/sempro.css') }}">
</head>

<body class="landing-page">

    <header class="landing-header">
        <a href="{{ url('/') }}" class="landing-brand">
            <div class="landing-mark">
                <img src="{{ asset('images/sempro-logo.png') }}" alt="Logo SIPOLAR">
            </div>
            <span>SIPOLAR</span>
        </a>

        <a href="{{ route('login') }}" class="btn btn-primary">
            Masuk ke Sistem
        </a>
    </header>


    <main>

        <section class="landing-hero">

            <div class="landing-hero-text">

                <span class="badge status-purple">
                    <span class="dot"></span>
                    Sistem Pengajuan Proposal Sempro
                </span>

                <h1>
                    Kelola Proposal Sempro
                    <span>Lebih Terarah.</span>
                </h1>

                <p>
                    SIPOLAR membantu mahasiswa, dosen pembimbing,
                    dan Admin/Prodi dalam mengelola proses pengajuan
                    proposal seminar proposal secara terstruktur.
                </p>

                <div class="landing-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Masuk ke Sistem
                    </a>

                    <a href="#tentang" class="btn btn-secondary">
                        Tentang Sistem
                    </a>
                </div>

            </div>


            <div class="landing-hero-card">

                <div class="landing-card-top">
                    <span class="muted"><b>Alur Pengajuan</b></span>
                </div>

                <div class="landing-step-list">

                    <div class="landing-step">
                        <div class="landing-step-number">1</div>
                        <div>
                            <b>Ajukan Proposal</b>
                            <span>Mahasiswa mengunggah proposal.</span>
                        </div>
                    </div>

                    <div class="landing-step">
                        <div class="landing-step-number">2</div>
                        <div>
                            <b>Review Dosen</b>
                            <span>Proposal ditinjau dan diberi komentar.</span>
                        </div>
                    </div>

                    <div class="landing-step">
                        <div class="landing-step-number">3</div>
                        <div>
                            <b>Revisi & Persetujuan</b>
                            <span>Mahasiswa melakukan revisi hingga disetujui.</span>
                        </div>
                    </div>

                    <div class="landing-step">
                        <div class="landing-step-number">4</div>
                        <div>
                            <b>Penjadwalan Sempro</b>
                            <span>Admin/Prodi menentukan jadwal seminar.</span>
                        </div>
                    </div>

                </div>

            </div>

        </section>


        <section class="landing-section" id="tentang">

            <div class="landing-section-head">
                <span class="badge status-info">Tentang SIPOLAR</span>

                <h2>
                    Satu sistem untuk seluruh proses pengajuan
                </h2>

                <p>
                    Setiap tahapan pengajuan dapat dipantau sesuai
                    peran pengguna dalam sistem.
                </p>
            </div>


            <div class="grid-3 landing-features">

                <div class="card landing-feature">
                    <div class="landing-feature-icon">◉</div>
                    <h3>Mahasiswa</h3>
                    <p>
                        Mengajukan proposal, melihat status,
                        membaca komentar, mengunggah revisi,
                        dan melihat jadwal sempro.
                    </p>
                </div>


                <div class="card landing-feature">
                    <div class="landing-feature-icon">♙</div>
                    <h3>Dosen Pembimbing</h3>
                    <p>
                        Melihat mahasiswa bimbingan,
                        meninjau proposal, memberikan komentar,
                        dan menyetujui proposal.
                    </p>
                </div>


                <div class="card landing-feature">
                    <div class="landing-feature-icon">◫</div>
                    <h3>Admin / Prodi</h3>
                    <p>
                        Mengelola data pengguna, menentukan
                        dosen pembimbing, memantau pengajuan,
                        dan menjadwalkan sempro.
                    </p>
                </div>

            </div>

        </section>

    </main>


    <footer class="landing-footer">
        <span>© {{ date('Y') }} SIPOLAR</span>
        <span>Sistem Pengajuan Proposal Sempro</span>
    </footer>

</body>
</html>