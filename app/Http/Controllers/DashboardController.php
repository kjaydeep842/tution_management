<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Inquiry;
use App\Models\Fee;
use App\Models\TuitionClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_inquiries' => Inquiry::where('status', 'pending')->count(),
            'total_classes' => TuitionClass::count(),
            'pending_fees' => Fee::where('status', 'unpaid')->sum('amount'),
        ];

        return view('dashboard', compact('stats'));
    }
}
