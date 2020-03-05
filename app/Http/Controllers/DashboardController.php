<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\Device;
use App\Question;
use App\QuestionCategory;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class DashboardController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $usersCount = User::count();
        $questionCategoriesCount = QuestionCategory::count();
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
            'questionCategoriesCount' => $questionCategoriesCount,
            'devicesAndroid' => $devicesAndroid,
            'devicesIos' => $devicesIos,
            'articlesCount' => $articlesCount,
            'audiosCount' => $audiosCount,
            'monthlyNewUsersCount' => $monthlyNewUsersCount,
            'todayActiveUsersCount' => $todayActiveUsersCount,
        ]);
    }

    public function notify()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = Device::where('device_type', 'android')->pluck('fcm_id')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        dd($downstreamResponse->numberSuccess(),
        $downstreamResponse->numberFailure(),
        $downstreamResponse->numberModification());
    }
}
