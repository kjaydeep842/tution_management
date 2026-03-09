<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Success Stories - {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        /* Reusing some styles from home.blade.php for consistency */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px
        }

        .header {
            background: #0f172a;
            padding: 60px 0;
            text-align: center;
            color: #fff;
            margin-bottom: 60px
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 12px;
            letter-spacing: -1.5px
        }

        .header p {
            color: #94a3b8;
            font-size: 18px
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 60px
        }

        .result-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all .3s
        }

        .result-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .08)
        }

        .res-img-wrap {
            height: 240px;
            position: relative;
            background: #f1f5f9
        }

        .res-img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .res-percentage {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            padding: 8px 15px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, .4)
        }

        .res-body {
            padding: 24px;
            text-align: center
        }

        .res-name {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px
        }

        .res-exam {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px
        }

        .res-achievement {
            display: inline-block;
            background: #eef2ff;
            color: #6366f1;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 30px;
            margin-top: 10px
        }

        .nav-link {
            display: inline-block;
            margin-top: 20px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px
        }

        .pagination-wrap {
            margin-top: 40px;
            display: flex;
            justify-content: center
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            opacity: .8;
            transition: opacity .2s
        }

        .btn-back:hover {
            opacity: 1
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Our <span
                    style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Success
                    Stories</span></h1>
            <p>Proudly celebrating the achievements of our dedicated students.</p>
            <a href="{{ route('home') }}" class="btn-back">← Back to Home</a>
        </div>
    </header>

    <main class="container">
        <div class="results-grid">
            @foreach($results as $result)
                <div class="result-card">
                    <div class="res-img-wrap">
                        @if($result->image)
                            <img src="{{ asset('storage/' . $result->image) }}" class="res-img" alt="{{ $result->student_name }}">
                        @else
                            <div
                                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#cbd5e1;font-size:60px">
                                🎓</div>
                        @endif
                        <div class="res-percentage">{{ $result->marks_percentage }}</div>
                    </div>
                    <div class="res-body">
                        <div class="res-exam">{{ $result->exam_name }}</div>
                        <div class="res-name">{{ $result->student_name }}</div>
                        @if($result->achievement)
                            <div class="res-achievement">🏆 {{ $result->achievement }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $results->links() }}
        </div>
    </main>

    <footer style="background:#0f172a;color:#fff;padding:40px 0;text-align:center;margin-top:80px">
        <p style="color:#64748b;font-size:14px">© {{ date('Y') }}
            {{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre. All rights reserved.</p>
    </footer>
</body>

</html>