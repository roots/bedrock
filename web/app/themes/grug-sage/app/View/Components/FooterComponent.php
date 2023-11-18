<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FooterComponent extends Component
{
    public $nav_items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // get footer menu items as an array
        $nav_items = wp_get_nav_menu_items('footer');
        // dd($nav_items);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.footer-component');
    }
}
