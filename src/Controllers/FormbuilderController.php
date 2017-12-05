<?php

namespace TheWebmen\Formbuilder\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\CMS\Model\SiteTree;
use TheWebmen\Formbuilder\Forms\FormbuilderForm;

class FormbuilderController extends Controller {

    private static $url_segment = 'FormbuilderController';
    private static $allowed_actions = array(
        'FormbuilderForm'
    );

    public function index(){
        $this->httpError(404);
    }

    public function FormbuilderForm(){
        $r = $this->getRequest();
        if(!$r->isPOST()){
            $this->httpError(404);
        }
        $formPageID = $r->postVar('FormPageID');
        if(!$formPageID || !$page = SiteTree::get()->byID($formPageID)){
            $this->httpError(404);
        }
        $fields = [];
        if($fieldsData = $page->FormbuilderFields){
            $fields = json_decode($fieldsData);
        }
        return new FormbuilderForm('FormbuilderForm', $fields, $page->ID);
    }

}
