<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\Device;
use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $usersCount = User::count();
        $quizCount = Quiz::where('is_active', 1)->count();
        $devicesAndroid = Device::where('device_type', 'android')->count();
        $devicesIos = Device::where('device_type', 'ios')->count();
        $articlesCount = Content::whereHas('category', function($query) {
            return $query->where('is_active', 1);
        })->where('type', 'article')->count();
        $audiosCount = Content::whereHas('category', function($query) {
            return $query->where('is_active', 1);
        })->where('type', 'audio')->count();
        $monthlyNewUsersCount = Device::where('created_at', '>', now()->startOfMonth())->count();
        $todayActiveUsersCount = Device::where('last_active_session', '>', now()->startOfDay())->count();
        return view('dashboard', [
            'categoriesCount' => $categoriesCount,
            'usersCount' => $usersCount,
            'quizCount' => $quizCount,
            'devicesAndroid' => $devicesAndroid,
            'devicesIos' => $devicesIos,
            'articlesCount' => $articlesCount,
            'audiosCount' => $audiosCount,
            'monthlyNewUsersCount' => $monthlyNewUsersCount,
            'todayActiveUsersCount' => $todayActiveUsersCount,
        ]);
    }
}
