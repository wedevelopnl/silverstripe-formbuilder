<?php

namespace TheWebmen\Formbuilder\Fields;

use SilverStripe\ORM\ArrayList;

class ModelDropdownField extends \SilverStripe\Forms\DropdownField
{
    public static function get_allowed_models()
    {
//        $models = self::config()->get('models');
//
//        $return = ArrayList::create();
//
//        foreach ($models as $model)
//        {
//            $return->push(new ArrayData(['class' => $model, 'name' => $model::$plural_name]));
//        }
//
//        return $return;
    }

}