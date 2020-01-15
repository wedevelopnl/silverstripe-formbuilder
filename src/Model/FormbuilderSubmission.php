<?php

namespace TheWebmen\Formbuilder\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class FormbuilderSubmission extends DataObject {

    private static $table_name = 'TheWebmen_FormbuilderSubmission';

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

    public function __get($property)
    {
        $data = parent::__get('Data');
        $test = json_decode($data, true);
        $filter = new URLSegmentFilter();
        
        try {
            $prop = parent::__get($property);
        } catch (\Exception $exception) {
            $prop = null;
        }

        if (is_null($prop) && array_key_exists($filter->filter($property), $test)) {
            $property = $filter->filter($property);
            return is_array($test[$property]) ? implode(',', $test[$property]) : $test[$property];
        }

        if (is_null($prop) && array_key_exists($property, $test)) {
            return is_array($test[$property]) ? implode(',', $test[$property]) : $test[$property];
        }

        return $prop;
    }

}
