<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre – Expert Tutoring for Every Student</title>
    <meta name="description" content="Join {{ \App\Models\Setting::get('site_name', 'BrightMind') }} for personalised expert tuition. Enrol today and unlock your child's potential.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        .gradient-hero { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); }
        .gradient-card { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); }
        .gradient-accent { background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%); }
        .text-gradient { background: linear-gradient(90deg, #6366f1, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(99, 102, 241, 0.15); }
        .float-anim { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100%{ transform: translateY(0px); } 50%{ transform: translateY(-15px); } }
        .nav-glass { background: rgba(15, 12, 41, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .blob { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.25; pointer-events: none; }
        .section-label { font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #6366f1; }
        .input-style { width: 100%; padding: 12px 16px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; transition: all 0.2s; }
        .input-style:focus { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,0.12); }
        .btn-primary { display: inline-flex; align-items: center; justify-content: center; padding: 14px 32px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; font-weight: 700; border-radius: 16px; transition: all 0.3s; text-decoration: none; border: none; cursor: pointer; font-size: 15px; box-shadow: 0 10px 30px rgba(99,102,241,0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 40px rgba(99,102,241,0.4); }
        .btn-outline { display: inline-flex; align-items: center; justify-content: center; padding: 14px 32px; background: rgba(255,255,255,0.08); color: white; font-weight: 600; border-radius: 16px; transition: all 0.3s; text-decoration: none; border: 1.5px solid rgba(255,255,255,0.2); font-size: 15px; }
        .btn-outline:hover { background: rgba(255,255,255,0.15); }
        @media (max-width: 640px) {
            .hero-title { font-size: 2.5rem !important; }
            .hero-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body style="background:#ffffff; color:#1e293b; overflow-x:hidden; margin:0;">

<!-- ═══════════════ NAVBAR ═══════════════ -->
<nav class="nav-glass fixed top-0 left-0 right-0 z-50">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px; height:70px; display:flex; align-items:center; justify-content:space-between;">
        <!-- Logo -->
        <a href="/" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
            <div class="{{ \App\Models\Setting::get('site_logo') ? '' : 'gradient-card' }}" style="width:{{ \App\Models\Setting::get('site_logo') ? 'auto' : '38px' }}; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                @if($logo = \App\Models\Setting::get('site_logo'))
                    <img src="{{ asset('storage/' . $logo) }}" class="h-full w-auto object-contain">
                @else
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                @endif
            </div>
            <span style="color:white; font-weight:800; font-size:20px; letter-spacing:-0.5px;">{{ \App\Models\Setting::get('site_name', 'BrightMind') }}</span>
        </a>
        <!-- Nav Links (hidden on mobile) -->
        <div style="display:flex; align-items:center; gap:32px;" class="hidden md:flex">
            <a href="#features" style="color:rgba(255,255,255,0.7); font-size:14px; font-weight:500; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Features</a>
            <a href="#classes" style="color:rgba(255,255,255,0.7); font-size:14px; font-weight:500; text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Subjects</a>
            <a href="#testimonials" style="color:rgba(255,255,255,0.7); font-size:14px; font-weight:500; text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Reviews</a>
            <a href="#contact" style="color:rgba(255,255,255,0.7); font-size:14px; font-weight:500; text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Contact</a>
        </div>
        <!-- Actions -->
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.8); font-size:14px; font-weight:500; text-decoration:none; padding:8px 16px; border-radius:10px; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">Login</a>
            <a href="#contact" class="btn-primary" style="padding:10px 22px; font-size:14px; border-radius:12px;">Enrol Free →</a>
        </div>
    </div>
</nav>

<!-- ═══════════════ HERO ═══════════════ -->
<section class="gradient-hero" style="min-height:100vh; display:flex; align-items:center; padding-top:70px; position:relative; overflow:hidden;">
    <!-- Background blobs -->
    <div class="blob" style="width:500px; height:500px; background:#7c3aed; top:-100px; right:-100px;"></div>
    <div class="blob" style="width:400px; height:400px; background:#4f46e5; bottom:0; left:-100px;"></div>
    <div class="blob" style="width:300px; height:300px; background:#ec4899; top:30%; left:40%;"></div>

    <div style="max-width:1200px; margin:0 auto; padding:80px 24px; display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; position:relative; z-index:1;" class="hero-grid">
        <!-- Left: Copy -->
        <div>
            <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.1); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.15); border-radius:50px; padding:8px 18px; margin-bottom:28px;">
                <span style="font-size:16px;">🎓</span>
                <span style="color:#c4b5fd; font-size:13px; font-weight:600;">Admissions Open · 2025–26 Batch</span>
            </div>
            <h1 class="hero-title" style="font-size:4rem; font-weight:900; color:white; line-height:1.1; margin:0 0 24px; letter-spacing:-2px;">
                Unlock Your<br>
                <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Full Potential</span><br>Today.
            </h1>
            <p style="color:rgba(196,181,253,0.9); font-size:18px; line-height:1.7; margin:0 0 40px; max-width:480px;">
                Expert tutors. Personalised learning plans. Proven results across Maths, Science, English &amp; more — for students from Grade 1 to Grade 12.
            </p>
            <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:48px;">
                <a href="#contact" class="btn-primary">Book Free Demo Class →</a>
                <a href="#features" class="btn-outline">Explore Courses</a>
            </div>
            <!-- Trust row -->
            <div style="display:flex; align-items:center; gap:20px;">
                <div style="display:flex;">
                    @foreach(['#f43f5e','#f59e0b','#10b981','#6366f1'] as $bg)
                    <div style="width:42px; height:42px; border-radius:50%; background:{{ $bg }}; border:3px solid rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-weight:700; color:white; font-size:13px; margin-left:-10px;">{{ chr(rand(65,90)) }}</div>
                    @endforeach
                </div>
                <div>
                    <div style="color:white; font-weight:700; font-size:14px;">1,200+ Happy Students</div>
                    <div style="color:#a78bfa; font-size:12px;">⭐ ⭐ ⭐ ⭐ ⭐ &nbsp;4.9 / 5 Rating</div>
                </div>
            </div>
        </div>

        <!-- Right: Hero Card -->
        <div style="display:flex; justify-content:center;">
            <div style="position:relative;" class="float-anim">
                <!-- Main card -->
                <div class="gradient-card" style="width:320px; border-radius:28px; padding:40px 32px; box-shadow:0 40px 80px rgba(99,102,241,0.4); border:1px solid rgba(255,255,255,0.15);">
                    <div style="width:70px; height:70px; background:rgba(255,255,255,0.15); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                        <svg width="36" height="36" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 style="color:white; font-size:22px; font-weight:800; text-align:center; margin:0 0 8px;">Smart Learning</h3>
                    <p style="color:rgba(196,181,253,0.8); font-size:13px; text-align:center; margin:0 0 28px; line-height:1.6;">Adaptive teaching for every student's unique learning style.</p>
                    @foreach(['Mathematics','Science','English','Computer'] as $sub)
                    <div style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.12); border-radius:12px; padding:10px 16px; margin-bottom:8px;">
                        <span style="color:white; font-size:14px; font-weight:500;">{{ $sub }}</span>
                        <span style="color:#a5f3fc; font-size:12px; font-weight:600;">✓ Available</span>
                    </div>
                    @endforeach
                </div>
                <!-- Floating badges -->
                <div style="position:absolute; top:-16px; right:-32px; background:white; border-radius:16px; padding:12px 16px; box-shadow:0 20px 40px rgba(0,0,0,0.15); display:flex; align-items:center; gap:12px; min-width:160px;">
                    <div style="width:40px; height:40px; background:#d1fae5; border-radius:12px; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:16px; color:#059669; flex-shrink:0;">A+</div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#1e293b;">Top Performers</div>
                        <div style="font-size:11px; color:#64748b;">95% pass rate</div>
                    </div>
                </div>
                <div style="position:absolute; bottom:-16px; left:-32px; background:white; border-radius:16px; padding:12px 16px; box-shadow:0 20px 40px rgba(0,0,0,0.15); display:flex; align-items:center; gap:12px; min-width:160px;">
                    <div style="width:40px; height:40px; background:#fef3c7; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">📅</div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#1e293b;">Flexible Batches</div>
                        <div style="font-size:11px; color:#64748b;">Morning & Evening</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave divider -->
    <div style="position:absolute; bottom:0; left:0; right:0; line-height:0;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:80px; display:block;">
            <path d="M0,80 Q360,0 720,40 Q1080,80 1440,20 L1440,80 Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- ═══════════════ STATS ═══════════════ -->
<section style="background:white; padding:60px 0;">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:24px; text-align:center;" class="stats-grid">
            @foreach([['1200+','Students Enrolled','#6366f1'],['98%','Pass Rate','#8b5cf6'],['25+','Expert Tutors','#6366f1'],['12+','Subjects Covered','#8b5cf6']] as $s)
            <div style="padding:32px 24px; background:#fafafa; border-radius:20px; border:1px solid #f1f5f9;">
                <div style="font-size:42px; font-weight:900; background:linear-gradient(135deg,{{ $s[2] }},#a855f7); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:8px;">{{ $s[0] }}</div>
                <div style="color:#64748b; font-size:14px; font-weight:500;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════════ FEATURES ═══════════════ -->
<section id="features" style="background:#f8fafc; padding:96px 0;">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
        <div style="text-align:center; margin-bottom:64px;">
            <div class="section-label" style="margin-bottom:12px;">Why Choose Us</div>
            <h2 style="font-size:2.75rem; font-weight:900; color:#0f172a; margin:0 0 16px; letter-spacing:-1.5px;">Learning That <span class="text-gradient">Actually Works</span></h2>
            <p style="color:#64748b; font-size:17px; max-width:560px; margin:0 auto; line-height:1.7;">We combine expert teaching with a nurturing environment to help every student reach their peak potential.</p>
        </div>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;" class="features-grid">
            @foreach([
                ['🧑‍🏫','Expert Tutors','All tutors are highly qualified with years of experience and a genuine passion for student success.','#ede9fe','#7c3aed'],
                ['📊','Progress Tracking','Regular progress reports, attendance summaries, and exam mark analysis accessible anytime.','#e0f2fe','#0284c7'],
                ['⚡','Small Batch Sizes','Limited class sizes mean every student gets focused, individualised attention from the teacher.','#fef3c7','#d97706'],
                ['📱','Online + Offline','Flexible learning modes — attend in-person or join our live online sessions from anywhere.','#dcfce7','#16a34a'],
                ['💡','Doubt Sessions','Dedicated weekly doubt-clearing sessions so no concept goes misunderstood.','#fce7f3','#db2777'],
                ['🏆','Proven Results','95% of our students pass board exams with distinction. Results speak for themselves.','#ede9fe','#7c3aed'],
            ] as $f)
            <div class="card-hover" style="background:white; border-radius:24px; padding:36px 32px; border:1px solid #f1f5f9; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                <div style="width:56px; height:56px; background:{{ $f[3] }}; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:26px; margin-bottom:20px;">{{ $f[0] }}</div>
                <h3 style="font-size:19px; font-weight:700; color:#0f172a; margin:0 0 12px;">{{ $f[1] }}</h3>
                <p style="color:#64748b; font-size:14px; line-height:1.7; margin:0;">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════════ SUBJECTS ═══════════════ -->
<section id="classes" style="background:white; padding:96px 0;">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
        <div style="text-align:center; margin-bottom:64px;">
            <div class="section-label" style="margin-bottom:12px;">Our Courses</div>
            <h2 style="font-size:2.75rem; font-weight:900; color:#0f172a; margin:0; letter-spacing:-1.5px;">Available <span class="text-gradient">Subjects</span></h2>
        </div>
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;" class="subjects-grid">
            @foreach([
                ['📐','Mathematics','Gr. 1–12','#ede9fe','#7c3aed'],
                ['⚗️','Chemistry','Gr. 8–12','#fee2e2','#dc2626'],
                ['🧬','Biology','Gr. 8–12','#dcfce7','#16a34a'],
                ['🔭','Physics','Gr. 8–12','#ede9fe','#7c3aed'],
                ['📝','English','Gr. 1–10','#fef3c7','#d97706'],
                ['💻','Computer Sc.','Gr. 6–12','#e0f2fe','#0284c7'],
                ['🗺️','Geography','Gr. 6–10','#ccfbf1','#0d9488'],
                ['📜','History','Gr. 6–10','#ffedd5','#ea580c'],
            ] as $sub)
            <div class="card-hover" style="background:white; border:1.5px solid #f1f5f9; border-radius:20px; padding:28px 20px; cursor:pointer; text-align:center;">
                <div style="font-size:36px; margin-bottom:14px;">{{ $sub[0] }}</div>
                <h4 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 8px;">{{ $sub[1] }}</h4>
                <span style="font-size:12px; font-weight:600; padding:4px 12px; background:{{ $sub[3] }}; color:{{ $sub[4] }}; border-radius:8px;">{{ $sub[2] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════════ TESTIMONIALS ═══════════════ -->
<section id="testimonials" style="background:linear-gradient(135deg,#0f0c29 0%,#302b63 50%,#24243e 100%); padding:96px 0; position:relative; overflow:hidden;">
    <div class="blob" style="width:500px; height:500px; background:#6366f1; top:-100px; right:-100px;"></div>
    <div class="blob" style="width:400px; height:400px; background:#8b5cf6; bottom:-100px; left:-50px;"></div>
    <div style="max-width:1200px; margin:0 auto; padding:0 24px; position:relative; z-index:1;">
        <div style="text-align:center; margin-bottom:64px;">
            <div style="font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#a78bfa; margin-bottom:12px;">Testimonials</div>
            <h2 style="font-size:2.75rem; font-weight:900; color:white; margin:0 0 16px; letter-spacing:-1.5px;">What Parents Say</h2>
            <p style="color:#a78bfa; font-size:17px; margin:0;">Real stories from our growing student community.</p>
        </div>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;" class="testimonials-grid">
            @foreach([
                ["Priya\'s performance in Science improved dramatically! The teachers are amazing and always available to help.", 'Rajesh Sharma', 'Parent of Class 10 Student', 'RS'],
                ["My daughter went from failing Maths to scoring 95 in just 3 months. Best investment we ever made!", 'Sunita Patel', 'Parent of Class 8 Student', 'SP'],
                ["The personalised attention and weekly progress reports keep us informed. Highly recommend {{ \App\Models\Setting::get('site_name', 'BrightMind') }}!", 'Vikram Nair', 'Parent of Class 6 Student', 'VN'],
            ] as $t)
            <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:24px; padding:36px 32px; backdrop-filter:blur(10px);">
                <div style="color:#f59e0b; font-size:18px; margin-bottom:20px; letter-spacing:2px;">★★★★★</div>
                <p style="color:#e2e8f0; font-size:15px; line-height:1.8; margin:0 0 28px; font-style:italic;">"{{ $t[0] }}"</p>
                <div style="display:flex; align-items:center; gap:14px;">
                    <div class="gradient-card" style="width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:800; font-size:14px; flex-shrink:0;">{{ $t[3] }}</div>
                    <div>
                        <div style="color:white; font-weight:700; font-size:14px;">{{ $t[1] }}</div>
                        <div style="color:#a78bfa; font-size:12px; margin-top:2px;">{{ $t[2] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══════════════ CONTACT / INQUIRY ═══════════════ -->
<section id="contact" style="background:#f8fafc; padding:96px 0;">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:start;" class="contact-grid">
            <!-- Left -->
            <div>
                <div class="section-label" style="margin-bottom:12px;">Get In Touch</div>
                <h2 style="font-size:2.75rem; font-weight:900; color:#0f172a; margin:0 0 20px; letter-spacing:-1.5px;">Ready to Get <span class="text-gradient">Started?</span></h2>
                <p style="color:#64748b; font-size:16px; line-height:1.8; margin:0 0 40px;">Fill in the form and our team will contact you within 24 hours to discuss the perfect learning plan for your child — completely free.</p>

                <div style="display:flex; flex-direction:column; gap:20px; margin-bottom:36px;">
                    @foreach([['📍','Visit Us', \App\Models\Setting::get('site_address', '123 Education Lane, Mumbai, Maharashtra 400001')],['📞','Call Us','+91 98765 43210  ·  +91 87654 32109'],['📧','Email Us', \App\Models\Setting::get('contact_email', 'admissions@brightmind.in')]] as $c)
                    <div style="display:flex; align-items:flex-start; gap:16px;">
                        <div style="width:48px; height:48px; background:#ede9fe; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">{{ $c[0] }}</div>
                        <div>
                            <div style="font-weight:700; color:#0f172a; margin-bottom:4px; font-size:15px;">{{ $c[1] }}</div>
                            <div style="color:#64748b; font-size:14px;">{{ $c[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="gradient-card" style="border-radius:24px; padding:28px 32px; color:white;">
                    <div style="font-size:22px; margin-bottom:8px;">🎁 Free Trial Class</div>
                    <p style="color:rgba(196,181,253,0.9); font-size:14px; margin:0; line-height:1.7;">Every new student gets one <strong style="color:white;">completely free</strong> demo class with no commitment required.</p>
                </div>
            </div>

            <!-- Right: Form -->
            <div style="background:white; border-radius:28px; padding:48px 40px; box-shadow:0 20px 60px rgba(0,0,0,0.07); border:1px solid #f1f5f9;">
                <h3 style="font-size:24px; font-weight:800; color:#0f172a; margin:0 0 6px;">Send an Inquiry</h3>
                <p style="color:#94a3b8; font-size:14px; margin:0 0 32px;">We'll respond within 24 hours.</p>

                @if(session('success'))
                <div style="background:#f0fdf4; border:1.5px solid #86efac; color:#166534; border-radius:14px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:center; gap:12px; font-size:14px;">
                    ✅ {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('inquiry.store') }}" method="POST">
                    @csrf
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                        <div>
                            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Student's Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Arjun Sharma" class="input-style">
                        </div>
                        <div>
                            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Contact Number *</label>
                            <input type="text" name="contact" required placeholder="+91 98765 43210" class="input-style">
                        </div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Interested Class (optional)</label>
                        <select name="tuition_class_id" class="input-style" style="appearance:none; background-image:url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e\"); background-repeat:no-repeat; background-position:right 12px center; background-size:20px; cursor:pointer;">
                            <option value="">Choose a class…</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} – {{ $class->subject }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">How did you hear about us?</label>
                        <select name="source" class="input-style" style="appearance:none; background-image:url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e\"); background-repeat:no-repeat; background-position:right 12px center; background-size:20px; cursor:pointer;">
                            <option value="">Select source</option>
                            <option value="Friend">Friend / Family</option>
                            <option value="Social Media">Social Media</option>
                            <option value="Google">Google Search</option>
                            <option value="Flyer">Flyer / Pamphlet</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div style="margin-bottom:28px;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Message / Requirements</label>
                        <textarea name="notes" rows="4" placeholder="Tell us about the student's current grade, challenges, goals..." class="input-style" style="resize:none;"></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%; font-size:16px; padding:16px;">Submit Inquiry – It's Free! 🚀</button>
                    <p style="text-align:center; color:#94a3b8; font-size:12px; margin:12px 0 0;">No spam. We'll only reach out with relevant information.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ FOOTER ═══════════════ -->
<footer style="background:#0f172a; color:white; padding:72px 0 40px;">
    <div style="max-width:1200px; margin:0 auto; padding:0 24px;">
        <div style="display:grid; grid-template-columns:2fr 1fr 1fr; gap:48px; margin-bottom:56px;" class="footer-grid">
            <div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                    <div class="{{ \App\Models\Setting::get('site_logo') ? '' : 'gradient-card' }}" style="width:{{ \App\Models\Setting::get('site_logo') ? 'auto' : '36px' }}; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        @if($logo = \App\Models\Setting::get('site_logo'))
                            <img src="{{ asset('storage/' . $logo) }}" class="h-full w-auto object-contain">
                        @else
                            <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                        @endif
                    </div>
                    <span style="font-weight:800; font-size:20px;">{{ \App\Models\Setting::get('site_name', 'BrightMind') }}</span>
                </div>
                <p style="color:#64748b; font-size:14px; line-height:1.8; margin:0 0 24px; max-width:300px;">Empowering students to achieve academic excellence through personalised, expert-led tuition since 2015.</p>
            </div>
            <div>
                <h4 style="font-weight:700; font-size:14px; color:#e2e8f0; margin:0 0 20px;">Quick Links</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px;">
                    @foreach([['#features','About Us'],['#classes','Courses'],['#contact','Contact'],[route('login'),'Student Login']] as $l)
                    <li><a href="{{ $l[0] }}" style="color:#64748b; font-size:14px; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#64748b'">{{ $l[1] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 style="font-weight:700; font-size:14px; color:#e2e8f0; margin:0 0 20px;">Subjects</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px;">
                    @foreach(['Mathematics','Science','English','Computer Science'] as $s)
                    <li style="color:#64748b; font-size:14px;">{{ $s }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:32px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <p style="color:#475569; font-size:13px; margin:0;">© {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre. All rights reserved.</p>
            <p style="color:#334155; font-size:12px; margin:0;">Built with ❤️ for better education</p>
        </div>
    </div>
</footer>

<style>
@media (max-width: 1024px) {
    .hero-grid, .contact-grid, .footer-grid { grid-template-columns: 1fr !important; gap: 40px !important; }
    .float-anim { display: none; }
    .features-grid { grid-template-columns: repeat(2,1fr) !important; }
}
@media (max-width: 768px) {
    .features-grid, .subjects-grid, .testimonials-grid, .stats-grid { grid-template-columns: 1fr !important; }
    .hero-title { font-size: 2.5rem !important; }
    h2 { font-size: 2rem !important; }
    section { padding: 64px 0 !important; }
}
@media (max-width: 480px) {
    .subjects-grid { grid-template-columns: repeat(2,1fr) !important; }
    .stats-grid { grid-template-columns: repeat(2,1fr) !important; }
    nav div:nth-child(2) { display: none !important; }
}
</style>

<script>
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const el = document.querySelector(a.getAttribute('href'));
        if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
    });
});
</script>
</body>
</html>
