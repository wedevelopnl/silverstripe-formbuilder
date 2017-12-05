<?php

namespace TheWebmen\Formbuilder\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class FormbuilderSubmission extends DataObject {

    private static $db = array(
        'Data' => 'Text'
    );

    private static $has_one = [
        'SiteTree' => SiteTree::class
    ];

}
