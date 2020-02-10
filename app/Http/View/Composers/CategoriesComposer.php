<?php

namespace App\Http\View\Composers;

use App\Category;
use Illuminate\View\View;

class CategoriesComposer
{

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories = Category::where('is_active', 1)->get();
        
        $view->with('categories', $categories);
    }
}
