<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Security\CMSPermissionProvider;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class SortableImageTitleText extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableImageTitleText';
    private static $singular_name = 'Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'Varchar',
        'Content' => 'Text'
    ];

    private static $has_one = [
        'Owner' => DataObject::class,
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Title'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            UploadField::create('Image')
                ->setAllowedFileCategories('image')
                ->setFolderName('ElementAssets'),
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
