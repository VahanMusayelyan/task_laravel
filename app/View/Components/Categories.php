<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Category;
use App\Film;
use Illuminate\Support\Facades\DB;

class Categories extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $arraycategory = Category::get()->toArray();
        
        $arrayyear = DB::table('films')->select('year')->orderBy('year', 'desc')->distinct('year')->get()->toArray();


    return view('components.categories',['arraycategory'=>$arraycategory,'arrayyear'=>$arrayyear]);
    }
}
