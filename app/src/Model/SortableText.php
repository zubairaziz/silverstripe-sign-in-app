<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Security\CMSPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class SortableText extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableText';
    private static $singular_name = 'Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'Varchar'
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
            TextField::create('Title')
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
