<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Setting::get('site_name', config('app.name', 'Laravel')) }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #4f46e5, #7c3aed, #06b6d4, #4f46e5);
            background-size: 400% 400%;
            animation: gradientAnim 15s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientAnim {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .15;
            pointer-events: none;
            animation: blobAnim 12s ease-in-out infinite alternate;
        }

        @keyframes blobAnim {
            0% {
                transform: scale(1) translate(0, 0);
            }

            100% {
                transform: scale(1.15) translate(30px, 20px);
            }
        }

        .logo-box {
            width: 80px;
            height: 80px;
            border-radius: 24px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            animation: revealAnim 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes revealAnim {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered Delay classes */
        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }

        .delay-400 {
            animation-delay: 400ms;
        }

        .delay-500 {
            animation-delay: 500ms;
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">
    <div
        class="gradient-bg min-h-screen w-full flex flex-col sm:justify-center items-center py-20 px-4 sm:px-0 relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="blob"
            style="width:600px;height:600px;background:#fff;top:-150px;right:-150px;animation-duration:14s"></div>
        <div class="blob"
            style="width:500px;height:500px;background:#fff;bottom:-80px;left:-100px;animation-duration:10s;animation-direction:alternate-reverse">
        </div>

        <!-- Header Branding -->
        <div class="mb-14 flex flex-col items-center gap-6 z-10 reveal">
            <a href="/" class="group transition-all duration-500 hover:scale-105">
                <div class="logo-box">
                    <x-application-logo class="w-14 h-14" />
                </div>
            </a>
            <h1 class="text-white font-black text-3xl tracking-tighter uppercase delay-100 reveal">
                {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</h1>
        </div>

        <!-- Wider Form Card Section with Proper Padding -->
        <div
            class="w-full sm:max-w-2xl px-16 py-16 bg-white shadow-[0_60px_150px_-20px_rgba(0,0,0,0.5)] sm:rounded-[4rem] border border-gray-100 z-10 reveal delay-200">
            {{ $slot }}
        </div>

        <!-- Refined Footer -->
        <div class="mt-20 z-10 reveal delay-500">
            <div class="flex flex-col items-center gap-5">
                <div class="bg-black/10 border border-white/10 px-10 py-3.5 rounded-full backdrop-blur-md">
                    <span class="text-white/80 text-xs font-bold tracking-[4px] uppercase">Secure Student Access</span>
                </div>
                <p class="text-white/30 text-[11px] font-bold uppercase tracking-[5px]">&copy; {{ date('Y') }} Official
                    Academy Dashboard</p>
            </div>
        </div>
    </div>
</body>

</html>