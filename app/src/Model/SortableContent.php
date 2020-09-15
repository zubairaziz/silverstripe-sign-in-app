<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Security\CMSPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;

class SortableContent extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableContent';
    private static $singular_name = 'Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'HTMLText'
    ];

    private static $has_one = [
        'Owner' => DataObject::class
    ];

    private static $summary_fields = [
        'Title'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            HTMLEditorField::create('Title')
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Title'
        ]);
    }
}
