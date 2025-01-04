<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchForm extends Component
{
    public $routeName;

    public function __construct($routeName)
    {
        $this->routeName = $routeName;
    }

    public function render()
    {
        return view('components.search-form');
    }
}
