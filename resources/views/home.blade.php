<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ \App\Models\Setting::get('site_name', 'BrightMind') }} - Expert Tuition Centre</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:#fff;color:#1e293b;overflow-x:hidden}
.container{max-width:1200px;margin:0 auto;padding:0 24px}
.text-grad{background:linear-gradient(135deg,#6366f1,#a855f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.reveal{opacity:0;transform:translateY(40px);transition:opacity .7s ease,transform .7s ease}
.reveal.visible{opacity:1;transform:none}
.reveal-left{opacity:0;transform:translateX(-50px);transition:opacity .7s ease,transform .7s ease}
.reveal-left.visible{opacity:1;transform:none}
.reveal-right{opacity:0;transform:translateX(50px);transition:opacity .7s ease,transform .7s ease}
.reveal-right.visible{opacity:1;transform:none}
.delay-1{transition-delay:.1s}.delay-2{transition-delay:.2s}.delay-3{transition-delay:.3s}.delay-4{transition-delay:.4s}
.navbar{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(15,12,41,.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.07);transition:all .3s}
.navbar.scrolled{background:rgba(10,8,30,.98);box-shadow:0 4px 30px rgba(0,0,0,.3)}
.navbar-inner{height:70px;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:12px;text-decoration:none}
.logo-icon{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0}
.nav-links{display:flex;align-items:center;gap:28px}
.nav-links a{color:rgba(255,255,255,.65);font-size:14px;font-weight:500;text-decoration:none;transition:color .2s}
.nav-links a:hover{color:#fff}
.btn-ghost{color:rgba(255,255,255,.8);font-size:14px;font-weight:500;text-decoration:none;padding:8px 16px;border-radius:10px;transition:all .2s}
.btn-ghost:hover{background:rgba(255,255,255,.1);color:#fff}
.btn-cta{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:14px;font-weight:700;border-radius:12px;text-decoration:none;transition:all .3s;box-shadow:0 4px 20px rgba(99,102,241,.4)}
.btn-cta:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(99,102,241,.5)}
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:16px 36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:16px;font-weight:700;border-radius:16px;text-decoration:none;transition:all .3s;box-shadow:0 10px 30px rgba(99,102,241,.4);border:none;cursor:pointer}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(99,102,241,.55)}
.btn-outline{display:inline-flex;align-items:center;gap:8px;padding:15px 36px;background:rgba(255,255,255,.08);color:#fff;font-size:16px;font-weight:600;border-radius:16px;text-decoration:none;transition:all .3s;border:1.5px solid rgba(255,255,255,.2)}
.btn-outline:hover{background:rgba(255,255,255,.15);transform:translateY(-2px)}
.hero{background:linear-gradient(135deg,#0f0c29 0%,#302b63 55%,#24243e 100%);min-height:100vh;display:flex;align-items:center;padding-top:70px;position:relative;overflow:hidden}
.blob{position:absolute;border-radius:50%;filter:blur(90px);opacity:.22;pointer-events:none;animation:blobAnim 12s ease-in-out infinite alternate}
@keyframes blobAnim{0%{transform:scale(1)}100%{transform:scale(1.15) translate(20px,15px)}}
.hero-inner{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;padding:80px 0;position:relative;z-index:1}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.09);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.14);border-radius:50px;padding:8px 20px;margin-bottom:28px}
.hero-title{font-size:4rem;font-weight:900;color:#fff;line-height:1.1;letter-spacing:-2px;margin-bottom:24px}
.hero-sub{color:rgba(196,181,253,.85);font-size:18px;line-height:1.75;max-width:480px;margin-bottom:40px}
.hero-btns{display:flex;gap:16px;flex-wrap:wrap;margin-bottom:48px}
.hero-trust{display:flex;align-items:center;gap:20px}
.avatar-stack{display:flex}
.avatar{width:40px;height:40px;border-radius:50%;border:3px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:12px;margin-left:-10px}
.float-card{width:320px;background:linear-gradient(140deg,rgba(99,102,241,.9),rgba(139,92,246,.95));border-radius:28px;padding:32px 24px;box-shadow:0 40px 80px rgba(99,102,241,.5);border:1px solid rgba(255,255,255,.15);position:relative;animation:floatCard 6s ease-in-out infinite}
@keyframes floatCard{0%,100%{transform:translateY(0) rotate(-1deg)}50%{transform:translateY(-18px) rotate(1deg)}}
.chip{background:rgba(255,255,255,.13);border-radius:10px;padding:9px 14px;margin-bottom:7px;display:flex;justify-content:space-between;align-items:center;border:1px solid rgba(255,255,255,.1)}
.fbadge{position:absolute;background:#fff;border-radius:14px;padding:10px 14px;box-shadow:0 16px 40px rgba(0,0,0,.15);display:flex;align-items:center;gap:10px;white-space:nowrap}
.fbadge-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:13px;flex-shrink:0}
.wave{position:absolute;bottom:0;left:0;right:0;line-height:0}
.stats-section{background:#fff;padding:72px 0}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.stat-card{padding:36px 24px;background:#fafafa;border-radius:24px;border:1px solid #f1f5f9;text-align:center;transition:all .3s}
.stat-card:hover{transform:translateY(-6px);box-shadow:0 20px 40px rgba(99,102,241,.1);border-color:#e0e7ff}
.stat-num{font-size:44px;font-weight:900;background:linear-gradient(135deg,#6366f1,#a855f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:6px}
.stat-label{color:#64748b;font-size:14px;font-weight:500}
.section-head{text-align:center;margin-bottom:64px}
.section-head h2{font-size:2.6rem;font-weight:900;color:#0f172a;letter-spacing:-1.5px;margin-bottom:16px}
.section-head p{color:#64748b;font-size:16px;max-width:540px;margin:0 auto;line-height:1.7}
.slabel{display:inline-flex;align-items:center;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#6366f1;background:#eef2ff;padding:6px 14px;border-radius:30px;margin-bottom:16px}
.features-section{background:#f8fafc;padding:96px 0}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.feature-card{background:#fff;border-radius:24px;padding:32px;border:1px solid #f1f5f9;transition:all .35s}
.feature-card:hover{transform:translateY(-10px);box-shadow:0 30px 60px rgba(99,102,241,.12);border-color:#e0e7ff}
.feature-icon{width:56px;height:56px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:20px}
.feature-card h3{font-size:18px;font-weight:700;color:#0f172a;margin-bottom:10px}
.feature-card p{color:#64748b;font-size:14px;line-height:1.75}
.subjects-section{background:#fff;padding:96px 0}
.subjects-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.subject-card{background:#fff;border:1.5px solid #f1f5f9;border-radius:22px;padding:26px 18px;text-align:center;transition:all .3s;position:relative;overflow:hidden}
.subject-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#6366f1,#a855f7);transform:scaleX(0);transition:transform .3s;transform-origin:left}
.subject-card:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(99,102,241,.1);border-color:#c7d2fe}
.subject-card:hover::after{transform:scaleX(1)}
.subj-emoji{font-size:36px;margin-bottom:12px;display:block;transition:transform .3s}
.subject-card:hover .subj-emoji{transform:scale(1.2) rotate(-5deg)}
.subj-name{font-size:15px;font-weight:700;color:#0f172a;margin-bottom:8px}
.subj-pill{font-size:11px;font-weight:600;padding:3px 10px;border-radius:8px;display:inline-block}
.teachers-section{background:#f8fafc;padding:96px 0}
.teachers-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.teacher-card{background:#fff;border-radius:24px;overflow:hidden;border:1px solid #f1f5f9;transition:all .35s}
.teacher-card:hover{transform:translateY(-10px);box-shadow:0 30px 60px rgba(99,102,241,.12)}
.tc-banner{height:88px;position:relative}
.tc-avatar-wrap{position:absolute;bottom:-30px;left:26px}
.tc-avatar{width:62px;height:62px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:#fff;border:4px solid #fff}
.tc-body{padding:42px 26px 26px}
.tc-name{font-size:17px;font-weight:800;color:#0f172a;margin-bottom:4px}
.tc-sub{font-size:13px;color:#6366f1;font-weight:600;margin-bottom:10px}
.tc-branch{display:inline-flex;align-items:center;gap:5px;background:#f1f5f9;color:#64748b;font-size:12px;font-weight:600;padding:4px 10px;border-radius:8px}
.testi-section{background:linear-gradient(135deg,#0f0c29 0%,#302b63 55%,#24243e 100%);padding:96px 0;position:relative;overflow:hidden}
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.testi-card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:24px;padding:32px;backdrop-filter:blur(14px);transition:all .35s}
.testi-card:hover{background:rgba(255,255,255,.1);transform:translateY(-6px)}
.testi-stars{color:#f59e0b;font-size:15px;letter-spacing:3px;margin-bottom:16px}
.testi-q{color:#e2e8f0;font-size:14px;line-height:1.8;margin-bottom:24px;font-style:italic}
.testi-author{display:flex;align-items:center;gap:12px}
.testi-av{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:13px;flex-shrink:0}
.contact-section{background:#f8fafc;padding:96px 0}
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}
.form-card{background:#fff;border-radius:28px;padding:44px 36px;box-shadow:0 24px 64px rgba(0,0,0,.08);border:1px solid #f1f5f9}
.input-field{width:100%;padding:12px 15px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;transition:all .25s;font-family:'Inter',sans-serif;color:#1e293b}
.input-field:focus{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.1)}
.form-label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:7px}
.class-picker{position:relative}
.picker-trigger{width:100%;padding:12px 38px 12px 15px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;transition:all .25s;user-select:none;min-height:46px}
.picker-trigger.open{border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.1)}
.picker-trigger .placeholder{font-size:14px;color:#94a3b8}
.picker-trigger .selected-class{flex:1}
.picker-trigger .selected-class .cls-name{font-size:14px;font-weight:700;color:#0f172a;line-height:1.2}
.picker-trigger .selected-class .cls-subj{font-size:11px;color:#6366f1;font-weight:600;background:#eef2ff;padding:2px 8px;border-radius:5px;display:inline-block;margin-top:3px}
.picker-arrow{flex-shrink:0;transition:transform .25s}
.picker-arrow.open{transform:rotate(180deg)}
.picker-dropdown{display:none;position:absolute;top:calc(100% + 6px);left:0;right:0;background:#fff;border:1.5px solid #e0e7ff;border-radius:14px;box-shadow:0 12px 40px rgba(0,0,0,.12);z-index:200;overflow:hidden;max-height:280px;overflow-y:auto}
.picker-dropdown.open{display:block}
.picker-item{padding:12px 16px;cursor:pointer;border-bottom:1px solid #f8fafc;transition:background .15s}
.picker-item:last-child{border-bottom:none}
.picker-item:hover{background:#f5f3ff}
.picker-item.empty{color:#94a3b8;font-size:14px;font-style:italic}
.picker-item .pi-name{font-size:14px;font-weight:700;color:#0f172a;margin-bottom:5px}
.picker-item .pi-subj{display:flex;flex-wrap:wrap;gap:5px}
.pi-badge{font-size:11px;color:#6366f1;font-weight:600;background:#eef2ff;padding:2px 9px;border-radius:6px;display:inline-block}
.pi-badge.more{color:#64748b;background:#f1f5f9}
footer{background:#0f172a;color:#fff;padding:64px 0 36px}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:48px;margin-bottom:48px}
.footer-link{color:#64748b;font-size:14px;text-decoration:none;transition:color .2s;display:block;margin-bottom:11px}
.footer-link:hover{color:#a78bfa}
@media(max-width:1024px){.hero-inner,.contact-grid,.footer-grid{grid-template-columns:1fr;gap:48px}.float-card-wrap{display:none}.features-grid{grid-template-columns:repeat(2,1fr)}.teachers-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:768px){.features-grid,.subjects-grid,.testi-grid,.stats-grid,.teachers-grid{grid-template-columns:1fr}.hero-title{font-size:2.6rem!important}.section-head h2{font-size:1.9rem!important}.nav-links{display:none}}
@media(max-width:640px){.subjects-grid{grid-template-columns:repeat(2,1fr)}.stats-grid{grid-template-columns:repeat(2,1fr)}.hero-title{font-size:2rem!important}.hero-btns{flex-direction:column}}
</style>
</head>
<body>
<nav class="navbar" id="navbar">
<div class="container navbar-inner">
<a href="/" class="nav-logo">
<div class="logo-icon">
@if($logo = \App\Models\Setting::get('site_logo'))
<img src="{{ asset('storage/'.$logo) }}" style="height:100%;width:auto;object-fit:contain">
@else
<svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
@endif
</div>
<span style="color:#fff;font-weight:800;font-size:19px;letter-spacing:-.5px">{{ \App\Models\Setting::get('site_name','BrightMind') }}</span>
</a>
<div class="nav-links">
<a href="#features">Why Us</a>
<a href="#subjects">Subjects</a>
<a href="#teachers">Teachers</a>
<a href="#contact">Contact</a>
</div>
<div style="display:flex;align-items:center;gap:12px">
<a href="{{ route('login') }}" class="btn-ghost">Login</a>
<a href="#contact" class="btn-cta">Enrol Free →</a>
</div>
</div>
</nav>
<section class="hero">
<div class="blob" style="width:560px;height:560px;background:#7c3aed;top:-120px;right:-120px;animation-duration:14s"></div>
<div class="blob" style="width:420px;height:420px;background:#4f46e5;bottom:-40px;left:-80px;animation-duration:10s;animation-direction:alternate-reverse"></div>
<div class="container">
<div class="hero-inner">
<div>
<div class="hero-badge">
<span style="font-size:16px">🎓</span>
<span style="color:#c4b5fd;font-size:13px;font-weight:600">Admissions Open · 2026–27Batch</span>
</div>
<h1 class="hero-title">Unlock Your <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Full Potential</span><br>Today.</h1>
<p class="hero-sub">Expert tutors. Personalised plans. Proven results across
@if($subjects->count()){{ $subjects->take(3)->join(', ') }} &amp; more
@else Mathematics, Science, English &amp; more
@endif — for students from Grade 1 to Grade 12.</p>
<div class="hero-btns">
<a href="#contact" class="btn-primary">Book Free Demo →</a>
<a href="#subjects" class="btn-outline">Explore Courses</a>
</div>
<div class="hero-trust">
<div class="avatar-stack">
@foreach(['#f43f5e','#f59e0b','#10b981','#6366f1'] as $ac)
<div class="avatar" style="background:{{$ac}}">{{ chr(65+$loop->index*4) }}</div>
@endforeach
</div>
<div>
<div style="color:#fff;font-weight:700;font-size:14px">{{ $studentCount > 0 ? $studentCount.'+' : '1,200+' }} Students Enrolled</div>
<div style="color:#a78bfa;font-size:12px;margin-top:3px">⭐⭐⭐⭐⭐ 4.9 / 5 Rating</div>
</div>
</div>
</div>
<div class="float-card-wrap" style="display:flex;justify-content:center">
<div style="position:relative">
<div class="float-card">
<div style="width:60px;height:60px;background:rgba(255,255,255,.18);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:28px">🧠</div>
<h3 style="color:#fff;font-size:20px;font-weight:800;text-align:center;margin-bottom:8px">Smart Learning</h3>
<p style="color:rgba(196,181,253,.8);font-size:13px;text-align:center;margin-bottom:20px;line-height:1.6">Adaptive teaching for every student's unique style.</p>
@php $heroSubs = $subjects->count() ? $subjects->take(4) : collect(['Mathematics','Science','English','Computer']); @endphp
@foreach($heroSubs as $hs)
<div class="chip">
<span style="color:#fff;font-size:13px;font-weight:500">{{ $hs }}</span>
<span style="color:#a5f3fc;font-size:11px;font-weight:700">✓ Active</span>
</div>
@endforeach
</div>
<div class="fbadge" style="top:-18px;right:-36px">
<div class="fbadge-icon" style="background:#d1fae5;color:#059669">A+</div>
<div>
<div style="font-size:12px;font-weight:700;color:#1e293b">Top Performers</div>
<div style="font-size:11px;color:#64748b;margin-top:2px">95% pass rate</div>
</div>
</div>
<div class="fbadge" style="bottom:-18px;left:-36px">
<div class="fbadge-icon" style="background:#fef3c7;font-size:18px">📅</div>
<div>
<div style="font-size:12px;font-weight:700;color:#1e293b">Flexible Batches</div>
<div style="font-size:11px;color:#64748b;margin-top:2px">Morning &amp; Evening</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="wave"><svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:80px;display:block"><path d="M0,80 Q360,10 720,50 Q1080,90 1440,20 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="stats-section">
<div class="container">
<div class="stats-grid">
@php
$statsData=[[$studentCount>0?$studentCount:1200,'+','Students Enrolled','🎓'],[98,'%','Pass Rate','🏆'],[$teacherCount>0?$teacherCount:25,'+','Expert Tutors','🧑‍🏫'],[$subjectCount>0?$subjectCount:12,'+','Subjects Covered','📚']];
@endphp
@foreach($statsData as $st)
<div class="stat-card reveal delay-{{ $loop->index+1 }}">
<div style="font-size:28px;margin-bottom:8px">{{ $st[3] }}</div>
<div class="stat-num" data-target="{{ $st[0] }}" data-suffix="{{ $st[1] }}">{{ $st[0] }}{{ $st[1] }}</div>
<div class="stat-label">{{ $st[2] }}</div>
</div>
@endforeach
</div>
</div>
</section>
<section id="features" class="features-section">
<div class="container">
<div class="section-head reveal">
<div class="slabel">✦ Why Choose Us</div>
<h2>Learning That <span class="text-grad">Actually Works</span></h2>
<p>Expert teaching, small batches, and data-driven progress tracking to help every student reach their peak.</p>
</div>
@php
$features=[['🧑‍🏫','Expert Tutors','Highly qualified teachers with years of experience and passion for teaching.','#ede9fe'],['📊','Progress Tracking','Regular reports, attendance and exam analysis accessible anytime.','#e0f2fe'],['⚡','Small Batches','Limited class sizes ensure every student gets focused attention.','#fef3c7'],['📱','Online + Offline','Attend in-person or join live online sessions from anywhere.','#dcfce7'],['💡','Doubt Sessions','Dedicated weekly doubt-clearing so no concept goes unresolved.','#fce7f3'],['🏆','Proven Results','95% of students pass board exams with distinction.','#ede9fe']];
@endphp
<div class="features-grid">
@foreach($features as $f)
<div class="feature-card reveal delay-{{ ($loop->index%3)+1 }}">
<div class="feature-icon" style="background:{{ $f[3] }}">{{ $f[0] }}</div>
<h3>{{ $f[1] }}</h3>
<p>{{ $f[2] }}</p>
</div>
@endforeach
</div>
</div>
</section>
<section id="subjects" class="subjects-section">
<div class="container">
<div class="section-head reveal">
<div class="slabel">✦ Our Courses</div>
<h2>Available <span class="text-grad">Subjects</span></h2>
<p>@if($subjects->count())We offer {{ $subjects->count() }} subjects across all grades.
@else We offer a wide range of subjects across all grades.@endif</p>
</div>
@php
$sMeta=['Mathematics & Statistics'=>['📐','#ede9fe','#7c3aed','Gr. 8-12'],'Mathematics'=>['📐','#ede9fe','#7c3aed','Gr. 1-12'],'Chemistry'=>['⚗️','#fee2e2','#dc2626','Gr. 8-12'],'Biology'=>['🧬','#dcfce7','#16a34a','Gr. 8-12'],'Physics'=>['🔭','#ede9fe','#7c3aed','Gr. 8-12'],'English'=>['📝','#fef3c7','#d97706','Gr. 1-12'],'Hindi'=>['🔤','#ffedd5','#ea580c','Gr. 1-10'],'Gujarati'=>['🗺️','#ccfbf1','#0d9488','Gr. 1-10'],'Computer Science'=>['💻','#e0f2fe','#0284c7','Gr. 6-12'],'Information Technology (IT)'=>['💻','#e0f2fe','#0284c7','Gr. 6-12'],'Accountancy'=>['📊','#fef3c7','#d97706','Gr. 11-12'],'Business Studies'=>['💼','#fce7f3','#db2777','Gr. 11-12'],'Economics'=>['📈','#dcfce7','#16a34a','Gr. 11-12'],'Organisation of Commerce'=>['🏛️','#ede9fe','#7c3aed','Gr. 11-12'],'Commercial Law & Secretarial Practice'=>['⚖️','#ede9fe','#7c3aed','Gr. 11-12'],'Geography'=>['🗺️','#ccfbf1','#0d9488','Gr. 6-10'],'History'=>['📜','#ffedd5','#ea580c','Gr. 6-10'],'Science'=>['🔬','#dcfce7','#16a34a','Gr. 1-10']];
$dMeta=['📖','#f1f5f9','#6366f1','All Grades'];
$dispSubjs=$subjects->count()?$subjects:collect(['Mathematics','Science','English','Computer Science','Accountancy','Business Studies','Economics','History']);
@endphp
<div class="subjects-grid">
@foreach($dispSubjs as $sn)
@php $sm=isset($sMeta[$sn])?$sMeta[$sn]:$dMeta; @endphp
<div class="subject-card reveal delay-{{ ($loop->index%4)+1 }}">
<span class="subj-emoji">{{ $sm[0] }}</span>
<div class="subj-name">{{ $sn }}</div>
<span class="subj-pill" style="background:{{ $sm[1] }};color:{{ $sm[2] }}">{{ $sm[3] }}</span>
</div>
@endforeach
</div>
</div>
</section>
<section id="teachers" class="teachers-section">
<div class="container">
<div class="section-head reveal">
<div class="slabel">✦ Meet Our Team</div>
<h2>Our <span class="text-grad">Expert Teachers</span></h2>
<p>Passionate educators dedicated to bringing out the best in every student.</p>
</div>
@php $tgrads=[['#6366f1','#8b5cf6'],['#ec4899','#f43f5e'],['#10b981','#059669'],['#f59e0b','#ea580c'],['#06b6d4','#0284c7'],['#8b5cf6','#6366f1']]; @endphp
@if($teachers->count())
<div class="teachers-grid">
@foreach($teachers->take(6) as $teacher)
@php
$ti=$loop->index%count($tgrads);$tg=$tgrads[$ti];
$twords=explode(' ',trim($teacher->name));$tinit='';
foreach($twords as $tw){if(strlen($tw)>0)$tinit.=strtoupper($tw[0]);}
$tinit=substr($tinit,0,2);
$tspec=$teacher->subject_specialisation?$teacher->subject_specialisation:'Subject Specialist';
@endphp
<div class="teacher-card reveal delay-{{ ($loop->index%3)+1 }}">
<div class="tc-banner" style="background:linear-gradient(135deg,{{ $tg[0] }},{{ $tg[1] }})">
<div class="tc-avatar-wrap"><div class="tc-avatar" style="background:linear-gradient(135deg,{{ $tg[0] }},{{ $tg[1] }})">{{ $tinit }}</div></div>
</div>
<div class="tc-body">
<div class="tc-name">{{ $teacher->name }}</div>
<div class="tc-sub">{{ $tspec }}</div>
@if($teacher->branch)<div class="tc-branch">📍 {{ $teacher->branch->name }}</div>@endif
</div>
</div>
@endforeach
</div>
@else
@php $sTeach=[['Priya Sharma','Mathematics & Physics','Main Branch','PS'],['Rajesh Patel','English & Literature','City Branch','RP'],['Anita Mehta','Biology & Chemistry','Main Branch','AM']]; @endphp
<div class="teachers-grid">
@foreach($sTeach as $st)
@php $si=$loop->index%count($tgrads);$sg=$tgrads[$si]; @endphp
<div class="teacher-card reveal delay-{{ $loop->index+1 }}">
<div class="tc-banner" style="background:linear-gradient(135deg,{{ $sg[0] }},{{ $sg[1] }})">
<div class="tc-avatar-wrap"><div class="tc-avatar" style="background:linear-gradient(135deg,{{ $sg[0] }},{{ $sg[1] }})">{{ $st[3] }}</div></div>
</div>
<div class="tc-body">
<div class="tc-name">{{ $st[0] }}</div>
<div class="tc-sub">{{ $st[1] }}</div>
<div class="tc-branch">📍 {{ $st[2] }}</div>
</div>
</div>
@endforeach
</div>
@endif
</div>
</section>
<section id="testimonials" class="testi-section">
<div class="blob" style="width:480px;height:480px;background:#6366f1;top:-80px;right:-80px"></div>
<div class="blob" style="width:380px;height:380px;background:#8b5cf6;bottom:-80px;left:-40px"></div>
<div class="container" style="position:relative;z-index:1">
<div class="section-head reveal">
<div class="slabel" style="background:rgba(167,139,250,.15);color:#a78bfa">✦ Testimonials</div>
<h2 style="color:#fff">What Parents <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Say</span></h2>
<p style="color:#a78bfa">Real stories from our growing community of students and parents.</p>
</div>
@php
$sn=\App\Models\Setting::get('site_name','BrightMind');
$testis=[["Priya's performance in Science improved dramatically! The teachers are amazing.",'Rajesh Sharma','Parent of Class 10 Student','RS'],["My daughter went from failing Maths to scoring 95 in just 3 months. Best investment we made!",'Sunita Patel','Parent of Class 8 Student','SP'],["The personalised attention and progress reports keep us informed. Highly recommend {$sn}!",'Vikram Nair','Parent of Class 6 Student','VN']];
@endphp
<div class="testi-grid">
@foreach($testis as $t)
<div class="testi-card reveal delay-{{ $loop->index+1 }}">
<div class="testi-stars">★★★★★</div>
<p class="testi-q">"{{ $t[0] }}"</p>
<div class="testi-author">
<div class="testi-av">{{ $t[3] }}</div>
<div>
<div style="color:#fff;font-weight:700;font-size:14px">{{ $t[1] }}</div>
<div style="color:#a78bfa;font-size:12px;margin-top:2px">{{ $t[2] }}</div>
</div>
</div>
</div>
@endforeach
</div>
</div>
</section>
<section id="contact" class="contact-section">
<div class="container">
<div class="contact-grid">
<div class="reveal-left">
<div class="slabel">✦ Get In Touch</div>
<h2 style="font-size:2.5rem;font-weight:900;color:#0f172a;letter-spacing:-1.5px;margin-bottom:18px">Ready to Get <span class="text-grad">Started?</span></h2>
<p style="color:#64748b;font-size:15px;line-height:1.8;margin-bottom:36px">Fill in the form and our team will contact you within 24 hours — completely free.</p>
@php
$cItems=[['📍','Visit Us',\App\Models\Setting::get('site_address','123 Education Lane, Mumbai')],['📞','Call Us','+91 98765 43210 · +91 87654 32109'],['📧','Email Us',\App\Models\Setting::get('contact_email','admissions@brightmind.in')]];
@endphp
<div style="display:flex;flex-direction:column;gap:18px;margin-bottom:32px">
@foreach($cItems as $ci)
<div style="display:flex;align-items:flex-start;gap:14px">
<div style="width:46px;height:46px;background:#ede9fe;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0">{{ $ci[0] }}</div>
<div>
<div style="font-weight:700;color:#0f172a;font-size:14px;margin-bottom:3px">{{ $ci[1] }}</div>
<div style="color:#64748b;font-size:13px">{{ $ci[2] }}</div>
</div>
</div>
@endforeach
</div>
<div style="background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:22px;padding:26px 28px;color:#fff">
<div style="font-size:22px;margin-bottom:7px">🎁 Free Trial Class</div>
<p style="color:rgba(196,181,253,.9);font-size:14px;margin:0;line-height:1.7">Every new student gets one <strong style="color:#fff">completely free</strong> demo class with no commitment.</p>
</div>
</div>
<div class="form-card reveal-right">
<h3 style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:5px">Send an Inquiry</h3>
<p style="color:#94a3b8;font-size:14px;margin-bottom:28px">We'll respond within 24 hours.</p>
@if(session('success'))
<div style="background:#f0fdf4;border:1.5px solid #86efac;color:#166534;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:14px">✅ {{ session('success') }}</div>
@endif
<form action="{{ route('inquiry.store') }}" method="POST">
@csrf
<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
<div>
<label class="form-label">Student's Name *</label>
<input type="text" name="name" required placeholder="e.g. Arjun Sharma" class="input-field">
</div>
<div>
<label class="form-label">Contact Number *</label>
<input type="text" name="contact" required placeholder="+91 98765 43210" class="input-field">
</div>
</div>
<div style="margin-bottom:14px">
<label class="form-label">Interested Class (optional)</label>
<div class="class-picker" id="classPicker">
<div class="picker-trigger" id="pickerTrigger" onclick="togglePicker()">
<div id="pickerDisplay"><span class="placeholder">Choose a class…</span></div>
<svg class="picker-arrow" id="pickerArrow" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
</div>
<div class="picker-dropdown" id="pickerDropdown">
<div class="picker-item empty" onclick="pickClass('','','')">— No preference —</div>
@foreach($classes as $tc)
@php
$sparts=array_values(array_filter(array_map('trim',explode(',',$tc->subject??''))));
@endphp
<div class="picker-item" onclick="pickClass('{{ $tc->id }}','{{ addslashes($tc->name) }}','{{ addslashes(implode('|',$sparts)) }}')">
<div class="pi-name">{{ $tc->name }}</div>
@if(count($sparts))
<div class="pi-subj">
@foreach(array_slice($sparts,0,3) as $sp)
<span class="pi-badge">{{ $sp }}</span>
@endforeach
@if(count($sparts)>3)
<span class="pi-badge more">+{{ count($sparts)-3 }} more</span>
@endif
</div>
@endif
</div>
@endforeach
</div>
<input type="hidden" name="tuition_class_id" id="pickerValue">
</div>
</div>
<div style="margin-bottom:14px">
<label class="form-label">How did you hear about us?</label>
<select name="source" class="input-field" style="cursor:pointer">
<option value="">Select source</option>
<option value="Friend">Friend / Family</option>
<option value="Social Media">Social Media</option>
<option value="Google">Google Search</option>
<option value="Flyer">Flyer / Pamphlet</option>
<option value="Other">Other</option>
</select>
</div>
<div style="margin-bottom:24px">
<label class="form-label">Message / Requirements</label>
<textarea name="notes" rows="4" placeholder="Tell us about the student's grade, challenges, goals..." class="input-field" style="resize:none"></textarea>
</div>
<button type="submit" class="btn-primary" style="width:100%;font-size:15px;padding:15px;justify-content:center">Submit Inquiry – It's Free! 🚀</button>
<p style="text-align:center;color:#94a3b8;font-size:12px;margin-top:10px">No spam. We'll only reach out with relevant information.</p>
</form>
</div>
</div>
</div>
</section>
<footer>
<div class="container">
<div class="footer-grid">
<div>
<div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
<div class="logo-icon" style="width:36px;height:36px"><svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/></svg></div>
<span style="font-weight:800;font-size:19px">{{ \App\Models\Setting::get('site_name','BrightMind') }}</span>
</div>
<p style="color:#64748b;font-size:14px;line-height:1.8;max-width:280px">Empowering students to achieve academic excellence through personalised, expert-led tuition.</p>
</div>
<div>
<h4 style="font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:18px">Quick Links</h4>
<a href="#features" class="footer-link">Why Choose Us</a>
<a href="#subjects" class="footer-link">Subjects</a>
<a href="#teachers" class="footer-link">Our Teachers</a>
<a href="#contact" class="footer-link">Contact Us</a>
<a href="{{ route('login') }}" class="footer-link">Student Login</a>
</div>
<div>
<h4 style="font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:18px">Top Subjects</h4>
@foreach($dispSubjs->take(5) as $fs)
<a href="#subjects" class="footer-link">{{ $fs }}</a>
@endforeach
</div>
</div>
<div style="border-top:1px solid rgba(255,255,255,.07);padding-top:28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
<p style="color:#475569;font-size:13px">© {{ date('Y') }} {{ \App\Models\Setting::get('site_name','BrightMind') }} Tuition Centre. All rights reserved.</p>
<p style="color:#334155;font-size:12px">Built with ❤️ for better education</p>
</div>
</div>
</footer>
<script>
window.addEventListener('scroll',function(){
document.getElementById('navbar').classList.toggle('scrolled',window.scrollY>60);
});
document.querySelectorAll('a[href^="#"]').forEach(function(a){
a.addEventListener('click',function(e){
var t=document.querySelector(a.getAttribute('href'));
if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}
});
});
var revObs=new IntersectionObserver(function(entries){
entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');revObs.unobserve(e.target);}});
},{threshold:.12});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(function(el){revObs.observe(el);});
function animNum(el,target,suffix){
var d=1800,s=16,cur=0,inc=target/(d/s);
var t=setInterval(function(){cur+=inc;if(cur>=target){el.textContent=target.toLocaleString()+suffix;clearInterval(t);}else{el.textContent=Math.floor(cur).toLocaleString()+suffix;}},s);
}
var cObs=new IntersectionObserver(function(entries){
entries.forEach(function(e){if(e.isIntersecting){var el=e.target;var tgt=parseInt(el.dataset.target,10);var sfx=el.dataset.suffix||'';if(tgt)animNum(el,tgt,sfx);cObs.unobserve(el);}});
},{threshold:.5});
document.querySelectorAll('.stat-num[data-target]').forEach(function(el){cObs.observe(el);});
function togglePicker(){
var dd=document.getElementById('pickerDropdown');
var tr=document.getElementById('pickerTrigger');
var ar=document.getElementById('pickerArrow');
var open=dd.classList.contains('open');
dd.classList.toggle('open',!open);
tr.classList.toggle('open',!open);
ar.classList.toggle('open',!open);
}
function pickClass(id,name,subjsStr){
document.getElementById('pickerValue').value=id;
var disp=document.getElementById('pickerDisplay');
if(!id){
disp.innerHTML='<span class="placeholder">Choose a class\u2026</span>';
}else{
var parts=subjsStr?subjsStr.split('|').filter(Boolean):[];
var badges='';
parts.slice(0,3).forEach(function(p){badges+='<span class="pi-badge" style="font-size:11px;color:#6366f1;font-weight:600;background:#eef2ff;padding:2px 8px;border-radius:5px;margin-right:4px">'+p+'</span>';});
if(parts.length>3)badges+='<span style="font-size:11px;color:#64748b;background:#f1f5f9;padding:2px 8px;border-radius:5px">+'+( parts.length-3)+' more</span>';
disp.innerHTML='<div><div style="font-size:14px;font-weight:700;color:#0f172a;line-height:1.2">'+name+'</div>'+(badges?'<div style="margin-top:4px">'+badges+'</div>':'')+'</div>';
}
document.getElementById('pickerDropdown').classList.remove('open');
document.getElementById('pickerTrigger').classList.remove('open');
document.getElementById('pickerArrow').classList.remove('open');
}
document.addEventListener('click',function(e){
var picker=document.getElementById('classPicker');
if(picker&&!picker.contains(e.target)){
document.getElementById('pickerDropdown').classList.remove('open');
document.getElementById('pickerTrigger').classList.remove('open');
document.getElementById('pickerArrow').classList.remove('open');
}
});
</script>
</body>
</html>
