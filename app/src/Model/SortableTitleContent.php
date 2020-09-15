<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Security\CMSPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class SortableTitleContent extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableTitleContent';
    private static $singular_name = 'Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'Varchar',
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Owner' => DataObject::class
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Content.Summary' => 'Content'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            HTMLEditorField::create('Content')
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Title',
            'Content'
        ]);
    }
}
