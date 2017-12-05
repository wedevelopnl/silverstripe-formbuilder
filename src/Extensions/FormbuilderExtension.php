<?php

namespace TheWebmen\Formbuilder;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class FormbuilderExtension extends DataExtension {

    public function updateCMSFields(FieldList $fields)
    {
        var_dump($fields);
        die;
    }

}
