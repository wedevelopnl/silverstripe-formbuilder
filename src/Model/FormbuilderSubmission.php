<?php

namespace TheWebmen\Formbuilder\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TextField;

class FormbuilderSubmission extends DataObject {

    private static $db = array(
        'Data' => 'Text'
    );

    private static $has_one = [
        'SiteTree' => SiteTree::class
    ];

    private static $summary_fields = [
        'ID',
        'Created'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Data');
        $fields->removeByName('SiteTreeID');

        if($this->Data){
            $json = json_decode($this->Data, true);
            foreach($json as $key => $value){
                if(is_array($value)){
                    $value = implode(',', $value);
                }
                $fields->addFieldToTab('Root.Main', TextField::create($key, $key)->setValue($value)->setReadonly(true)->setDisabled(true));
            }
        }

        return $fields;
    }

}
