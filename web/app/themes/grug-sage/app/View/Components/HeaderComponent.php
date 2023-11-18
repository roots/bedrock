<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeaderComponent extends Component
{
    public $nav_items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // get the wordpress primary naviagtion menu items as an array
        $nav_items = wp_get_nav_menu_items('primary');
        $this->nav_items = $nav_items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header-component');
    }
}
