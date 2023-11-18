<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeroComponent extends Component
{
    /**
     *
     * @var mixed
     */
    public $hero_image;
    public $hero_title;
    public $hero_description;
    public $hero_button_text;
    public $hero_button_link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $hero_image = null,
        string $hero_title = '',
        string $hero_description = '',
        string $hero_button_text = '',
        $hero_button_link = '',
    )
    {
        // dump all acf fields into the component
        // the fields come from advanced custom fields
        if(get_field('hero_image')){
            $this->hero_image = get_field('hero_image');
        } else {
            $this->hero_image = 'https://dummyimage.com/600x400/e5e7eb/000000.jpg&text=Placeholder';
        }

        $this->hero_title = get_field('hero_title');
        $this->hero_description = get_field('hero_description');
        $this->hero_button_text = get_field('call_to_action_button_text');
        $this->hero_button_link = get_field('hero_button_link');
        // dd($this);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero-component');
    }
}
