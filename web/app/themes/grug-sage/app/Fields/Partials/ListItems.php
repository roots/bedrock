<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ListItems extends Partial
{
    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $listItems = new FieldsBuilder('list_items');

        $listItems
            ->addRepeater('items')
                ->addText('item')
            ->endRepeater();

        return $listItems;
    }
}
