<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Form\Field\DBIcon;
use App\Form\Field\IconField;
use App\Security\CMSPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class SortableIconTitleText extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableIconTitleText';
    private static $singular_name = 'Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'Varchar',
        'Icon' => DBIcon::class,
        'Content' => 'Text'
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
            TextField::create('Title'),
            IconField::create('Icon'),
            TextField::create('Content')
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
