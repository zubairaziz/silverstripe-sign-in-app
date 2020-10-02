<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Security\CMSPermissionProvider;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;

class SortableImage extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableImage';
    private static $singular_name = 'Image';

    private static $extensions = [
        Sortable::class
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Owner' => DataObject::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            UploadField::create('Image')->setAllowedFileCategories('image')
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Image'
        ]);
    }

    public function Me()
    {
        return $this->Image();
    }

    public function Delay()
    {
        $seconds = 5; // Delay in seconds
        $delay = $seconds + ($seconds * $this->Sort);
        return $delay;
    }

    public function getTitle()
    {
        return 'Image';
    }
}
