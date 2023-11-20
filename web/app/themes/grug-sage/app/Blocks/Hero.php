<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Hero extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Hero';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Hero block.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'formatting';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'star-filled';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = ['hero', 'heading', 'title'];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = ['post', 'page'];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'preview';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => true,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => false,
        'mode' => false,
        'multiple' => true,
        'jsx' => true,
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = [
        [
            'name' => 'light',
            'label' => 'Light',
            'isDefault' => true,
        ],
        [
            'name' => 'dark',
            'label' => 'Dark',
        ]
    ];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $hero = [
        'hero_image' => 'https://dummyimage.com/600x400/e5e7eb/000000.jpg&text=Placeholder',
        'hero_heading' => 'Hero Heading',
        'hero_subheading' => 'Hero Subheading',
        'hero_button' => [
            'hero_button_link' => '#',
            'hero_button_text' => 'Button',
        ],
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return ['hero' => $this->hero()];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $hero = new FieldsBuilder('hero');

        $hero
            ->addImage('hero_image')
            ->addText('hero_heading')
            ->addText('hero_subheading')
            ->addLink('hero_button_link')
            ->addText('hero_button_text');

        return $hero->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function hero()
    {
        $hero_image = get_field('hero_image');
        if (is_array($hero_image)) {
            $hero_image = $hero_image['url'];
        }

        if(!$hero_image){
            $hero_image = $this->hero['hero_image'];
        }
        $hero_heading = get_field('hero_heading') ?: $this->hero['hero_heading'];
        $hero_subheading = get_field('hero_subheading') ?: $this->hero['hero_subheading'];
        $hero_button_link = get_field('hero_button_link') ?: $this->hero['hero_button']['hero_button_link'];
        $hero_button_text = get_field('hero_button_text') ?: $this->hero['hero_button']['hero_button_text'];


        return [
            'hero_image' => $hero_image,
            'hero_heading' => $hero_heading,
            'hero_subheading' => $hero_subheading,
            'hero_button' => [
                'hero_button_link' => $hero_button_link,
                'hero_button_text' => $hero_button_text,
            ],
        ];
    }

    /**
     * Assets to be enqueued when rendering the block.
     *
     * @return void
     */
    public function enqueue()
    {
        //
    }
}
