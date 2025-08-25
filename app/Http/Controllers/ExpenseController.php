<?php

// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $expensesQuery = Expense::with('category')->where('user_id', $userId);


        // dd($request->from, $request->to);
        $hasCategoryFilter = $request->filled('category_id');

        if ($hasCategoryFilter) {
            $expensesQuery->where('category_id', $request->category_id);
        }

        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
        }

        $expensesQuery->whereBetween('date', [$from, $to]);

        $total = (clone $expensesQuery)->sum('amount');
        $expenses = $expensesQuery->orderByDesc('date')->paginate(10);

        $summary = Category::query()
            ->leftJoin('expenses', function ($join) use ($from, $to, $userId) {
                $join->on('expenses.category_id', '=', 'categories.id')
                    ->where('expenses.user_id', $userId)
                    ->whereBetween('expenses.date', [$from, $to]);
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->select('categories.id', 'categories.name')
            ->selectRaw('COALESCE(SUM(expenses.amount), 0) AS total')
            ->get();

        $grandTotal = $summary->sum('total');
        $monthLabel = now()->format('F Y');

        return view('expenses.index', [
            'expenses'      => $expenses,
            'categories'    => Category::orderBy('name')->get(),
            'total'         => $total,
            'summary'       => $summary,
            'grandTotal'    => $grandTotal,
            'monthLabel'    => $monthLabel,
            'rangeStart'    => $from->format('F j, Y'),
            'rangeEnd'      => $to->format('F j, Y'),
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        return view('expenses.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Expense added!');
    }

    public function report(Request $request)
    {
        // Set default "from" and "to" dates to current month if not provided
        $from = $request->filled('from') ? $request->from : Carbon::now()->startOfMonth()->toDateString();
        $to   = $request->filled('to')   ? $request->to   : Carbon::now()->endOfMonth()->toDateString();

        // Build query with filters
        $query = Expense::with('category')
            ->whereDate('date', '>=', $from)
            ->whereDate('date', '<=', $to);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $expenses = $query->orderBy('date', 'desc')->get();
        $total = $expenses->sum('amount');
        $categories = Category::all();

        return view('expenses.report', compact('expenses', 'total', 'categories', 'from', 'to'));
    }
}
