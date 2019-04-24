<?php

namespace TheWebmen\Formbuilder\Fields;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class ModelDropdownField extends \SilverStripe\Forms\DropdownField
{
    public static function get_allowed_models()
    {
        $models = self::config()->get('models');

        $return = ArrayList::create();

        foreach ($models as $model)
        {
            $return->push(new ArrayData(['class' => $model, 'name' => (new $model())->plural_name()]));
        }

        return $return;
    }

}