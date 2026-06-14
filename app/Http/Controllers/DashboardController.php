<?php

namespace App\Http\Controllers;

use App\Enums\ComplaintStatus;
use App\Models\Category;
use App\Models\FormType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => FormType::count(),
            'active' => FormType::where('status', ComplaintStatus::ACTIVE)->count(),
            'pending' => FormType::where('status', ComplaintStatus::PENDING)->count(),
            'completed' => FormType::where('status', ComplaintStatus::COMPLETED)->count(),
            'today' => FormType::whereDate('created_at', today())->count(),
            'this_week' => FormType::where('created_at', '>=', now()->startOfWeek())->count(),
        ];

        $byCategory = FormType::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $recent = FormType::with(['category', 'requestType'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $categoriesCount = Category::count();

        return view('admin.dashboard', compact('stats', 'byCategory', 'recent', 'categoriesCount'));
    }
}
