<?php

namespace TheWebmen\Formbuilder\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use TheWebmen\Formbuilder\Forms\FormbuilderForm;

class FormbuilderController extends Controller {

    private static $url_segment = 'FormbuilderController';
    private static $allowed_actions = array(
        'FormbuilderForm'
    );

    public function index(){
        $this->httpError(404);
    }
    
    public function getOwnerFromData($data)
    {
        $formOwnerID = $data['OwnerID'];
        $formOwnerClass = $data['OwnerClass'];
        $owner = $formOwnerClass::get()->byID($formOwnerID);

        $this->extend('updateOwnerFromData', $owner, $data);

        return $owner;
    }

    public function FormbuilderForm(){
        $r = $this->getRequest();
        if(!$r->isPOST()){
            $this->httpError(404);
        }

        $formOwnerID = $r->postVar('OwnerID');
        $formOwnerClass = $r->postVar('OwnerClass');
        if(!$formOwnerID || !$formOwnerClass){
            $this->httpError(404);
        }
        
        $owner = $this->getOwnerFromData($r->postVars());
        if (!$owner) {
            $this->httpError(404);
        }
        
        $fields = [];
        if($fieldsData = $owner->FormbuilderFields){
            $fields = json_decode($fieldsData);
        }
        return new FormbuilderForm('FormbuilderForm', $fields, $owner);
    }

}
