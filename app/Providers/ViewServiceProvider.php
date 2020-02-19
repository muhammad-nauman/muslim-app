<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'content.create',
                'content.edit',

                'quizzes.create',
                'quizzes.edit',

                'weekly_reminders.create',
                'weekly_reminders.edit',
            ], 'App\Http\View\Composers\CategoriesComposer'
        );
    }
}
