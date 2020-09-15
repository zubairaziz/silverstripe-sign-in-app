<?php

namespace App\Form;

use App\Extension\FormSettings;
use App\Form\FormSettings as AppFormSettings;
use App\Model\SortableText;
use App\Security\CMSPermissionProvider;
use App\Util\Util;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataObject;

class ContactFormSettings extends DataObject
{
    use AppFormSettings;
    use CMSPermissionProvider;

    private static $table_name = 'ContactFormSettings';

    private static $extensions = [
        FormSettings::class
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }
}
