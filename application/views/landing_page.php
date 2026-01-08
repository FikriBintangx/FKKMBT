<?php $this->load->view('templates/header'); ?>

<style>
    /* Override global body padding for landing page if needed, 
       but header needs padding-top. The issue is likely bottom padding. */
    body {
        padding-bottom: 0 !important; /* Fix floating footer gap */
        background-color: #ffffff; /* Ensure white background connects */
    }

    /* Adjust hero to sit nicely under fixed navbar */
    .hero-section-alt {
        margin-top: -20px; /* Pull up slightly to meet navbar if needed */
        padding-top: 40px;
    }

        /* New Fresh Hero Section */
        .hero-section-alt {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 40px 20px 60px;
            border-radius: 0 0 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section-alt::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.05) 0%, transparent 70%);
            z-index: 0;
        }
        .hero-badge-alt {
            background: #dcfce7;
            color: #166534;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
        .hero-title-alt {
            font-size: 2.2rem;
            font-weight: 900;
            color: #1e293b;
            line-height: 1.1;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }
        .hero-desc-alt {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 1;
        }

        /* App-Like Grid Menu */
        .app-menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 0 10px;
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }
        .app-menu-item {
            background: white;
            padding: 20px 15px;
            border-radius: 20px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid rgba(0,0,0,0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .app-menu-item:active { transform: scale(0.98); }
        .app-menu-icon {
            width: 50px; height: 50px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
            transition: transform 0.3s;
        }
        .app-menu-item:hover .app-menu-icon { transform: rotateY(180deg); }
        .app-menu-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
        }
        .app-menu-desc {
            color: #94a3b8;
            font-size: 10px;
            line-height: 1.3;
        }

        /* Call To Action Card */
        .cta-card {
            background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%);
            border-radius: 24px;
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: 40px;
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.25);
        }
        .cta-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0; width: 100px; height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 0 0 0 100%;
        }
    </style>
</head>
<body class="bg-light">
    
    <!-- Navbar (Dark Green) -->
    <?php $this->load->view('templates/header'); ?>

    <!-- Fresh Hero Section -->
    <section class="hero-section-alt">
        <div class="container">
            <div class="hero-badge-alt" data-aos="zoom-in">
                <i class="bi bi-shield-check-fill"></i> PORTAL RESMI
            </div>
            
            <h1 class="hero-title-alt" data-aos="fade-up">Bukit Tiara<br><span style="color: #16a34a;">Community App</span></h1>
            <p class="hero-desc-alt" data-aos="fade-up" data-aos-delay="100">
                Satu aplikasi untuk segala kebutuhan warga. Informasi transparan, layanan cepat, dan komunitas yang lebih guyub.
            </p>

            <a href="<?= base_url('auth/login') ?>" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-lg position-relative z-1" data-aos="fade-up" data-aos-delay="200" style="background: #1e293b; border: none;">
                Masuk Member Area
            </a>
        </div>
    </section>

    <!-- App Grid Menu -->
    <div class="container px-3 pb-5">
        <div class="app-menu-grid">
            <!-- Warga -->
            <a href="<?= base_url('warga') ?>" class="app-menu-item" data-aos="fade-up" data-aos-delay="300">
                <div class="app-menu-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h6 class="app-menu-title">Direktori Warga</h6>
                <span class="app-menu-desc">Cari tetangga & blok</span>
            </a>

            <!-- Iuran -->
            <a href="<?= base_url('iuran') ?>" class="app-menu-item" data-aos="fade-up" data-aos-delay="400">
                <div class="app-menu-icon" style="background: #fef9c3; color: #ca8a04;">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h6 class="app-menu-title">Info Iuran</h6>
                <span class="app-menu-desc">Transparansi dana</span>
            </a>

            <!-- Kegiatan -->
            <a href="<?= base_url('kegiatan') ?>" class="app-menu-item" data-aos="fade-up" data-aos-delay="500">
                <div class="app-menu-icon" style="background: #fee2e2; color: #dc2626;">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h6 class="app-menu-title">Agenda Warga</h6>
                <span class="app-menu-desc">Jadwal & dokumentasi</span>
            </a>

            <!-- Struktur -->
            <a href="<?= base_url('struktur') ?>" class="app-menu-item" data-aos="fade-up" data-aos-delay="600">
                <div class="app-menu-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <h6 class="app-menu-title">Organisasi</h6>
                <span class="app-menu-desc">Pengurus RT/RW</span>
            </a>
        </div>

        <!-- CTA Login / Register -->
        <div class="cta-card" data-aos="flip-up" data-aos-delay="700">
            <i class="bi bi-door-open-fill display-4 mb-3 d-block text-warning opacity-75"></i>
            <h3 class="fw-bold mb-2">Warga Bukit Tiara?</h3>
            <p class="opacity-75 small mb-4">Login untuk akses fitur eksklusif: Lapor Warga, Panic Button, dan E-Voting.</p>
            <a href="<?= base_url('auth/login') ?>" class="btn btn-light text-success fw-bold rounded-pill px-4 py-2 w-100 shadow-sm">
                Login Sekarang
            </a>
        </div>
    </div>


    <!-- Footer (Dark Green) -->
    <?php $this->load->view('templates/footer'); ?>
