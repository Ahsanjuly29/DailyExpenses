<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Models\Category;
use App\Models\expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;


Route::get('/', function () {

    // tmp data storing
    if (App::environment('local') && Auth::check() == false) {
        Artisan::call('migrate:fresh');
        Artisan::call('optimize:clear');
    }

    $categories = ['Food', 'Transport', 'Shopping', 'Others'];
    foreach ($categories as $categoryName) {
        Category::firstOrCreate(['name' => $categoryName]);
    }

    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {

        $userId = Auth::id();
        $targets = [
            'Transport' => 1200,
            'Food' => 2500,
            'Shopping' => 800,
            'Others' => 600,
        ];

        foreach ($targets as $name => $targetTotal) {
            $category = Category::where('name', $name)->first();

            if (!$category) {
                echo "Category '{$name}' not found. Skipping...\n";
                continue;
            }

            $currentTotal = Expense::where('user_id', $userId)
                ->where('category_id', $category->id)
                ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->sum('amount');

            $remaining = $targetTotal - $currentTotal;

            if ($remaining <= 0) {
                continue;
            }

            $entries = [];
            while ($remaining > 0) {
                $amount = rand(50, 300);
                $amount = min($amount, $remaining);
                $remaining -= $amount;
                $day = rand(1, now()->day);
                $date = Carbon::now()->startOfMonth()->addDays($day - 1);

                $entries[] = [
                    'user_id' => $userId,
                    'category_id' => $category->id,
                    'title' => "{$name} expense",
                    'amount' => $amount,
                    'date' => $date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Expense::insert($entries);
        }

        return redirect('expenses');
    })->name('dashboard');


    Route::resource('expenses', ExpenseController::class);

    // Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    // Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    // Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::get('/report', [ExpenseController::class, 'report'])->name('expenses.report');
});
