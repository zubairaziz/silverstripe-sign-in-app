<?php

use App\Form\FormController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;

class Page extends SiteTree
{
    private static $api_access = true;

    public function getAbstract()
    {
        if ($this->MetaDescription) {
            return DBField::create_field('HTMLText', "<p>{$this->MetaDescription}</p>");
        }
    }

    public static function ContactForm()
    {
        $formController = FormController::create();

        return $formController->ContactForm();
    }

    public function PageCheck()
    {
        return $this->ID;
    }

    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    public function canEdit($member = null, $context = [])
    {
        return true;
    }

    public function canDelete($member = null, $context = [])
    {
        return true;
    }

    public function canView($member = null, $context = [])
    {
        return true;
    }

    public function canPublish($member = null)
    {
        return true;
    }
}
