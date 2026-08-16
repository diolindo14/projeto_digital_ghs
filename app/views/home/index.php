<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculdade Moderna de Direito — FMD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; scroll-behavior: smooth; color: #334155; }
        
        /* Navbar */
        .navbar { background-color: rgba(248, 249, 250, 0.98); padding: 8px 0; border-bottom: 2px solid #e2e8f0; }
        .nav-link { color: #475569 !important; font-weight: 600; font-size: 1.05rem; transition: 0.3s; margin: 0 10px; }
        .nav-link:hover { color: #1e3a8a !important; }
        
        /* Hero */
        .hero { background: linear-gradient(to right, rgba(15, 23, 42, 0.94) 0%, rgba(15, 23, 42, 0.82) 100%), url('<?= URL_ROOT ?>/img/logo_fmd.jpg') right 8% center / 380px auto no-repeat; color: white; padding: 180px 0 60px 0; min-height: 90vh; display: flex; flex-direction: column; justify-content: space-between; position: relative; }
        @media (max-width: 991px) { .hero { background-size: 250px auto; background-position: center bottom 30px; } }
        .hero h1 { font-weight: 800; font-size: 4rem; letter-spacing: -1px; line-height: 1.1; margin-bottom: 20px; }
        .hero h1 span { color: #f59e0b; }
        .hero p { font-size: 1.25rem; font-weight: 400; max-width: 750px; line-height: 1.6; margin-bottom: 40px; color: #f1f5f9; }
        
        .badge-hero { background-color: rgba(30, 58, 138, 0.4); border: 1px solid rgba(59, 130, 246, 0.5); color: #93c5fd; padding: 10px 25px; border-radius: 30px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 30px; font-size: 0.95rem; }
        
        .btn-warning-custom { background-color: #f59e0b; color: #0f172a; font-weight: 800; border: none; padding: 14px 30px; border-radius: 8px; transition: 0.3s; text-decoration: none; font-size: 1.1rem; }
        .btn-warning-custom:hover { background-color: #d97706; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); color: #0f172a; }
        
        .btn-outline-custom2 { border: 1px solid rgba(255,255,255,0.4); color: white; background: rgba(0,0,0,0.3); font-weight: 600; padding: 14px 30px; border-radius: 8px; transition: 0.3s; backdrop-filter: blur(5px); text-decoration: none; font-size: 1.1rem; }
        .btn-outline-custom2:hover { background: rgba(255,255,255,0.1); border-color: white; color: white; }

        /* Stats inside hero */
        .hero-stats { margin-top: 50px; display: flex; gap: 40px; flex-wrap: wrap; }
        .hero-stat-item { display: flex; flex-direction: column; }
        .hero-stat-item h3 { font-size: 1.8rem; font-weight: 800; margin-bottom: 0; display: flex; align-items: center; gap: 10px; color: white; }
        .hero-stat-item p { font-size: 0.95rem; color: #cbd5e1; margin: 0; }
        
        /* Navbar Links Extras */
        .nav-login-btn { font-weight: 700; color: #0f172a; text-decoration: none; transition: 0.3s; font-size: 1.05rem; }
        .nav-login-btn:hover { color: #1e3a8a; }
        .nav-register-btn { background-color: #1e3a8a; color: white; font-weight: 700; padding: 10px 24px; border-radius: 8px; text-decoration: none; transition: 0.3s; font-size: 1.05rem; }
        .nav-register-btn:hover { background-color: #1e40af; color: white; }

        /* Sections common */
        .section-padding { padding: 90px 0; }
        .section-title { font-weight: 800; font-size: 2.5rem; color: #0f172a; margin-bottom: 15px; }
        .section-subtitle { font-size: 1.1rem; color: #64748b; margin-bottom: 50px; text-transform: uppercase; font-weight: 600; letter-spacing: 2px; }

        /* Oferta Academica */
        .card-academico { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; height: 100%; transition: 0.3s; display: flex; flex-direction: column; text-align: left; }
        .card-academico:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(30, 58, 138, 0.1); }
        .badge-ano { background-color: #eff6ff; color: #1e3a8a; padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; display: inline-block; width: fit-content; margin-bottom: 20px; }

        /* Feature Box */
        .feature-box { background: white; padding: 40px 30px; border-radius: 20px; text-align: center; height: 100%; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }
        .feature-box:hover { transform: translateY(-10px); }
        .feature-icon { width: 70px; height: 70px; background: rgba(30, 58, 138, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; color: #1e3a8a; font-size: 2rem; }
        .feature-title { font-weight: 700; font-size: 1.2rem; color: #0f172a; margin-bottom: 15px; }
        .feature-desc { color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 0; }

        /* CTA Strip */
        .cta-strip { background: #0f172a; padding: 80px 0; color: white; text-align: center; }
        .cta-strip h2 { font-weight: 800; font-size: 3rem; margin-bottom: 20px; }
        
        /* Contact Form */
        .contact-info-item { display: flex; align-items: center; margin-bottom: 25px; }
        .contact-icon { width: 45px; height: 45px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #1e3a8a; font-size: 1.3rem; margin-right: 15px; flex-shrink: 0; }
        .contact-text h5 { font-weight: 700; font-size: 1rem; margin-bottom: 2px; color: #0f172a; }
        .contact-text p { color: #64748b; font-size: 0.9rem; margin-bottom: 0; }
        
        .contact-form { background: white; padding: 40px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .form-control-custom { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 18px; border-radius: 8px; font-size: 0.9rem; color: #334155; }
        .form-control-custom:focus { background-color: white; border-color: #1e3a8a; box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1); }

        /* Footer */
        footer { background: #0b1120; color: #94a3b8; padding: 80px 0 40px 0; font-size: 0.95rem; }
        .footer-logo { color: white; font-weight: 800; font-size: 1.4rem; display: flex; align-items: center; gap: 12px; margin-bottom: 25px; }
        .footer-heading { color: white; font-weight: 700; font-size: 1.1rem; margin-bottom: 25px; }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 12px; color: #94a3b8; font-size: 1rem; }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: 0.3s; }
        .footer-links a:hover { color: white; }
        .footer-bottom { padding-top: 40px; margin-top: 60px; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center; color: #64748b; font-size: 0.9rem; position: relative; }
        
        .btn-scroll-top { position: absolute; right: 0; bottom: 40px; width: 50px; height: 50px; background-color: #1e3a8a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; text-decoration: none; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 100; border: none; }
        .btn-scroll-top:hover { background-color: #1e40af; transform: translateY(-5px); color: white; }
        @media (max-width: 991px) { .btn-scroll-top { position: fixed; right: 20px; bottom: 20px; } }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= URL_ROOT ?>/">
                <img src="<?= URL_ROOT ?>/img/logo_fmd.jpg" alt="Faculdade Moderna de Direito" style="height: 55px; object-fit: contain;">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark fs-5" style="line-height: 1.1;">FMD</span>
                    <span class="text-muted small" style="font-size: 0.75rem; font-weight: 500;">Faculdade Moderna de Direito</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <ion-icon name="menu" class="text-dark fs-1"></ion-icon>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#curso">Curso</a></li>
                    <li class="nav-item"><a class="nav-link" href="#regimes">Regimes & Propinas</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= URL_ROOT ?>/matricula">Inscrição</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>
                <div class="d-flex align-items-center gap-4 mt-3 mt-lg-0 pb-3 pb-lg-0">
                    <a href="<?= URL_ROOT ?>/auth" class="nav-login-btn">Entrar</a>
                    <a href="<?= URL_ROOT ?>/matricula" class="nav-register-btn">Inscrever-se</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 1. Secção Início (Hero Section) -->
    <section id="inicio" class="hero">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <div class="row">
                <div class="col-lg-9 col-xl-8">
                    <div class="badge-hero">
                        <ion-icon name="school-outline" class="fs-5 text-warning"></ion-icon> Inscrições Abertas 2026/2027 (02 de Julho a 29 de Setembro)
                    </div>
                    
                    <h1>O Teu Futuro <span>Começa Aqui!</span></h1>
                    <p class="fs-4 fw-semibold text-warning mb-2">Forma-te hoje para liderar o amanhã com justiça e ética.</p>
                    <p>Faculdade Moderna de Direito — Acreditada pelo Ministério da Educação e Ensino Superior (Autorização N.º 20250812). Licenciatura em Direito de 4 Anos com exames escrito e oral obrigatórios.</p>
                    
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="<?= URL_ROOT ?>/matricula" class="btn-warning-custom d-inline-flex align-items-center gap-2">
                            Inscrever-se Agora <ion-icon name="arrow-forward-outline"></ion-icon>
                        </a>
                        <a href="#sobre" class="btn-outline-custom2">
                            Conhecer a Instituição
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <h3><ion-icon name="ribbon-outline" class="text-warning"></ion-icon> Acreditação Oficial</h3>
                            <p>Autorização N.º 20250812</p>
                        </div>
                        <div class="hero-stat-item">
                            <h3>4 Anos</h3>
                            <p>Licenciatura em Direito</p>
                        </div>
                        <div class="hero-stat-item">
                            <h3>30.000 FCFA</h3>
                            <p>Propina Mensal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Secção Sobre a Instituição -->
    <section id="sobre" class="section-padding bg-light">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <!-- Coluna Esquerda: Textos + Horarios -->
                <div class="col-lg-6 pe-lg-5">
                    <span class="text-primary text-uppercase fw-bold" style="letter-spacing: 1.5px; font-size: 0.85rem;">Sobre a Instituição</span>
                    <h2 class="fw-bold mt-2 mb-4" style="color: #0f172a; font-size: 2.5rem; line-height: 1.2;">Faculdade Moderna de Direito (FMD)</h2>
                    <p class="fs-5 text-muted mb-4" style="line-height: 1.7;">A Faculdade Moderna de Direito (FMD) é uma nova instituição universitária privada focada na área jurídica na Guiné-Bissau. Lançada no final de 2024, a sua criação partiu da iniciativa de jovens licenciados formados pela Faculdade de Direito de Bissau (pública) que decidiram criar uma alternativa de ensino de excelência na capital.</p>
                    <p class="fs-5 text-muted mb-5" style="line-height: 1.7;">Localizada em Bissau, Belém (atrás da Cooperação Portuguesa), a nossa faculdade prepara juristas capacitados para responder aos desafios da justiça, da governação e das instituições contemporâneas com Ética, Ciência, Rigor e Júris.</p>
                </div>
                
                <!-- Coluna Direita: Missão, Visão e Valores -->
                <div class="col-lg-6 ps-lg-4">
                    <div class="d-flex flex-column gap-4">
                        <div class="border rounded-4 p-4 bg-white d-flex flex-column flex-sm-row gap-4 align-items-sm-start" style="border-color: #e2e8f0 !important; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 55px; height: 55px; background-color: #eff6ff;">
                                <ion-icon name="journal-outline" class="text-primary fs-3"></ion-icon>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">Missão</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">Assegurar a formação integral de profissionais do Direito dotados de elevado sentido ético, sentido crítico e sólida preparação científica.</p>
                            </div>
                        </div>
                        
                        <div class="border rounded-4 p-4 bg-white d-flex flex-column flex-sm-row gap-4 align-items-sm-start" style="border-color: #e2e8f0 !important; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 55px; height: 55px; background-color: #eff6ff;">
                                <ion-icon name="eye-outline" class="text-primary fs-3"></ion-icon>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-2">Visão</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">Consolidar-se como uma instituição de excelência no ensino do Direito e na promoção do Estado de Direito Democrático.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Secção Oferta Académica (Curso) -->
    <section id="curso" class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <span class="text-primary text-uppercase fw-bold" style="letter-spacing: 1.5px; font-size: 0.85rem;">Oferta Académica</span>
                <h2 class="fw-bold mt-2 mb-3" style="color: #0f172a; font-size: 2.5rem;">Licenciatura em Direito</h2>
                <p class="fs-5 text-muted mx-auto" style="max-width: 700px;">
                    Curso de 4 Anos estruturado com formação prática e teórica rigorosa, bolsas de mérito, estágios académicos a partir do 3.º ano e seminários especializados.
                </p>
            </div>

            <!-- 4 Column Grid (Anos Curriculares) -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
                <!-- 1 Ano -->
                <div class="col">
                    <div class="card-academico">
                        <span class="badge-ano">1.º Ano</span>
                        <h5 class="fw-bold text-dark mt-2 mb-3">Bases Jurídicas & Teoria</h5>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            Introdução ao Estudo do Direito, Teoria Geral do Direito Civil, Direito Constitucional, Ciência Política, História do Direito, Economia Política.
                        </p>
                        <strong class="text-primary" style="font-size: 1.05rem;">Propina: 30.000 FCFA/mês</strong>
                    </div>
                </div>
                
                <!-- 2 Ano -->
                <div class="col">
                    <div class="card-academico">
                        <span class="badge-ano">2.º Ano</span>
                        <h5 class="fw-bold text-dark mt-2 mb-3">Direito Substantivo I</h5>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            Direito das Obrigações, Direito Penal, Direito Administrativo, Direito Internacional Público, Direitos Fundamentais.
                        </p>
                        <strong class="text-primary" style="font-size: 1.05rem;">Propina: 30.000 FCFA/mês</strong>
                    </div>
                </div>

                <!-- 3 Ano -->
                <div class="col">
                    <div class="card-academico">
                        <span class="badge-ano">3.º Ano</span>
                        <h5 class="fw-bold text-dark mt-2 mb-3">Processo & Estágio Académico</h5>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            Direitos Reais, Direito Comercial, Direito Processual Civil, Direito Processual Penal, Direito do Trabalho, Direito Fiscal. Início do Estágio Académico.
                        </p>
                        <strong class="text-primary" style="font-size: 1.05rem;">Propina: 30.000 FCFA/mês</strong>
                    </div>
                </div>

                <!-- 4 Ano -->
                <div class="col">
                    <div class="card-academico">
                        <span class="badge-ano">4.º Ano</span>
                        <h5 class="fw-bold text-dark mt-2 mb-3">Prática & Consolidação</h5>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            Direito da Família e Sucessões, Prática Processual, Filosofia do Direito, Direito Internacional Privado, Exame Escrito e Oral Obrigatórios.
                        </p>
                        <strong class="text-primary" style="font-size: 1.05rem;">Propina: 30.000 FCFA/mês</strong>
                    </div>
                </div>
            </div>

            <!-- Seminários Obrigatórios -->
            <div class="p-4 rounded-4 bg-light border border-2 border-primary-subtle shadow-sm mt-4">
                <h5 class="fw-bold text-primary mb-3"><ion-icon name="journal-outline" class="align-middle me-2"></ion-icon> Seminários Obrigatórios de Especialização:</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 fw-bold text-dark"><ion-icon name="briefcase-outline" class="text-warning me-2"></ion-icon> Direito dos Petróleos e Recursos Naturais</div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 fw-bold text-dark"><ion-icon name="newspaper-outline" class="text-primary me-2"></ion-icon> Direito da Comunicação Social</div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 fw-bold text-dark"><ion-icon name="shield-checkmark-outline" class="text-success me-2"></ion-icon> Ética e Deontologia nas Profissões Jurídicas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Secção Regimes de Candidatura & Propinas -->
    <section id="regimes" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <span class="text-primary text-uppercase fw-bold" style="letter-spacing: 1.5px; font-size: 0.85rem;">Inscrições 2026/2027</span>
                <h2 class="fw-bold mt-2 mb-3" style="color: #0f172a; font-size: 2.5rem;">Regimes de Inscrição & Taxas</h2>
                <p class="text-muted fs-5">Período de Inscrição: <strong>02 de Julho a 29 de Setembro de 2026</strong></p>
            </div>

            <div class="row g-4">
                <!-- Regime Geral -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white p-4 text-center">
                            <span class="badge bg-warning text-dark fw-bold mb-2">REGIME GERAL</span>
                            <h3 class="fw-bold mb-0">10.000 FCFA</h3>
                            <small class="text-white-50">Taxa de Inscrição</small>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Documentos Necessários:</h6>
                            <ul class="small text-muted ps-3 mb-0" style="line-height: 1.7;">
                                <li>Cópia do Bilhete de Identidade ou Passaporte;</li>
                                <li>Certificado ou cópia autenticada do certificado de conclusão do 12.º ano com disciplinas discriminadas e média final;</li>
                                <li>Declaração de frequência do 12.º ano (se concluindo no ano letivo corrente);</li>
                                <li>Comprovativo de depósito da taxa de inscrição.</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-light p-3 text-center border-0">
                            <a href="<?= URL_ROOT ?>/matricula" class="btn btn-outline-primary w-100 fw-bold">Candidatar neste Regime</a>
                        </div>
                    </div>
                </div>

                <!-- Regime Especial -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-dark text-white p-4 text-center" style="background-color: #0b1120 !important;">
                            <span class="badge bg-warning text-dark fw-bold mb-2">REGIME ESPECIAL</span>
                            <h3 class="fw-bold mb-0">20.000 FCFA</h3>
                            <small class="text-white-50">Taxa de Inscrição</small>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Documentos Necessários:</h6>
                            <ul class="small text-muted ps-3 mb-0" style="line-height: 1.7;">
                                <li>Carta de motivação dirigida ao Diretor da Faculdade justificando a escolha do Curso de Direito;</li>
                                <li>Cópia do B.I. ou Passaporte;</li>
                                <li>Cópia autenticada do Diploma/Certificado de Bacharel ou Licenciatura;</li>
                                <li>Curriculum Vitae atualizado;</li>
                                <li>Comprovativo de depósito da taxa de inscrição.</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-light p-3 text-center border-0">
                            <a href="<?= URL_ROOT ?>/matricula" class="btn btn-outline-dark w-100 fw-bold">Candidatar neste Regime</a>
                        </div>
                    </div>
                </div>

                <!-- Regime Transferência -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white p-4 text-center">
                            <span class="badge bg-warning text-dark fw-bold mb-2">TRANSFERÊNCIA</span>
                            <h3 class="fw-bold mb-0">25.000 FCFA</h3>
                            <small class="text-white-50">Taxa de Inscrição</small>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Documentos Necessários:</h6>
                            <ul class="small text-muted ps-3 mb-0" style="line-height: 1.7;">
                                <li>Carta de intenção dirigida ao Diretor da Faculdade justificando a transferência;</li>
                                <li>Comprovativo de inscrição/matrícula no estabelecimento de proveniência;</li>
                                <li>Certificado de frequência de Direito da escola de origem com notas;</li>
                                <li>Histórico Escolar / Plano do Curso com horas letivas e créditos;</li>
                                <li>Comprovativo de depósito da taxa de inscrição.</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-light p-3 text-center border-0">
                            <a href="<?= URL_ROOT ?>/matricula" class="btn btn-outline-primary w-100 fw-bold">Candidatar neste Regime</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dados Bancários CORIS BANK -->
            <div class="mt-5 p-4 rounded-4 text-white" style="background: linear-gradient(135deg, #1e3a8a, #0b1120);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-1"><ion-icon name="card-outline" class="me-2"></ion-icon> Dados para Depósito da Taxa de Inscrição</h4>
                        <p class="mb-0 text-white-50">Depósito direto na conta institucional oficial da Faculdade Moderna de Direito.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="p-3 rounded-3 bg-white text-dark display-6 fw-bold fs-5">
                            CORIS BANK: <span class="text-primary">0056872410168</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Secção Contacto -->
    <section id="contacto" class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <span class="text-primary text-uppercase fw-bold" style="letter-spacing: 2px; font-size: 0.85rem;">Contacto Institucional</span>
                <h2 class="fw-bold mt-2 display-5" style="color: #0f172a;">Contacte a Faculdade</h2>
            </div>

            <div class="row g-5">
                <!-- Informações -->
                <div class="col-lg-5">
                    <h4 class="fw-bold mb-4" style="font-size: 1.25rem; color: #0f172a;">Informações Oficiais</h4>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon"><ion-icon name="location-outline"></ion-icon></div>
                        <div class="contact-text">
                            <h5>Localização</h5>
                            <p>Bissau, Belém (atrás da Cooperação Portuguesa)</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon"><ion-icon name="call-outline"></ion-icon></div>
                        <div class="contact-text">
                            <h5>Telefones Oficiais</h5>
                            <p>
                                +245 965 752 160<br>
                                +245 955 774 053<br>
                                +245 955 585 189<br>
                                +245 955 808 824 / +245 955 216 555
                            </p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon"><ion-icon name="mail-outline"></ion-icon></div>
                        <div class="contact-text">
                            <h5>Correio Eletrónico</h5>
                            <p>secretaria@fmd.edu.gw</p>
                        </div>
                    </div>

                    <div class="bank-card shadow-sm mt-3 p-3 bg-light rounded-3">
                        <h6 class="fw-bold text-dark mb-1">Depósitos Bancários:</h6>
                        <p class="mb-0 text-primary fw-bold">CORIS BANK — N.º 0056872410168</p>
                    </div>
                </div>

                <!-- Formulário de Mensagem -->
                <div class="col-lg-7">
                    <div class="contact-form shadow-sm">
                        <h5 class="fw-bold mb-4" style="font-size: 1.1rem;">Enviar Pedido de Informação</h5>
                        <form action="#" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                            <div class="row g-3 mb-3">
                                <div class="col-md-7">
                                    <input type="text" class="form-control-custom w-100" placeholder="Nome completo" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="email" class="form-control-custom w-100" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control-custom w-100" placeholder="Telefone" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control-custom w-100" placeholder="Assunto" required>
                            </div>
                            <div class="mb-4">
                                <textarea class="form-control-custom w-100" rows="4" placeholder="A sua mensagem..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-white rounded-3 shadow-sm" style="background-color: #1e3a8a; border: none;">Enviar Mensagem</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 pe-lg-5">
                    <div class="footer-logo">
                        <img src="<?= URL_ROOT ?>/img/logo_fmd.jpg" alt="FMD" style="height: 45px; object-fit: contain;">
                        Faculdade Moderna de Direito
                    </div>
                    <p class="mb-3" style="color: #cbd5e1; line-height: 1.6;">Plataforma de Gestão Académica da Faculdade Moderna de Direito (FMD).</p>
                    <p class="fst-italic" style="color: #64748b; font-size: 0.9rem;">"Ciência • Ética • Rigor • Júris"</p>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Portais & Serviços</h5>
                    <ul class="footer-links">
                        <li><a href="<?= URL_ROOT ?>/auth">Portal do Estudante</a></li>
                        <li><a href="<?= URL_ROOT ?>/auth">Portal do Professor</a></li>
                        <li><a href="<?= URL_ROOT ?>/auth">Secretaria & Tesouraria</a></li>
                        <li><a href="<?= URL_ROOT ?>/matricula">Candidatura Online</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">Contactos</h5>
                    <ul class="footer-links">
                        <li>Bissau, Belém (atrás da Cooperação Portuguesa)</li>
                        <li>Tel: +245 965 752 160 / 955 585 189</li>
                        <li class="mt-2">Email: secretaria@fmd.edu.gw</li>
                        <li>CORIS BANK N.º 0056872410168</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-1">&copy; 2026 Faculdade Moderna de Direito (FMD). Todos os direitos reservados. Autorização N.º 20250812.</p>
                <p class="mb-0">Desenvolvido por <strong>Diosives Pedro Nunes Crobute</strong></p>
                
                <a href="#inicio" class="btn-scroll-top">
                    <ion-icon name="arrow-up-outline"></ion-icon>
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
