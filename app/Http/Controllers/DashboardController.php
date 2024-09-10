<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if user is not authenticated
        }

        $user = Auth::user();
        // $bookCount = Book::count();
        // $categoryCount = Category::count();
        $userCount = User::count();

        // if ($user->role_id == 'admin') {
        //     return response()->json(['user_count' => $userCount]); // Return user count as JSON response
        // }

        return view('dashboard', [
            // 'book_count' => $bookCount,
            // 'category_count' => $categoryCount,
            'user_count' => $userCount
        ]);
    }

}
