<?php

namespace App\Model;

use App\Extension\Sortable;
use App\Form\Field\DBVideoURL;
use App\Security\CMSPermissionProvider;
use App\Util\Util;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class SortableVideo extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableVideo';
    private static $singular_name = 'Video';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'Title' => 'Varchar',
        'VideoURL' => DBVideoURL::class
    ];

    private static $has_one = [
        'VideoImage' => Image::class,
        'Owner' => DataObject::class
    ];

    private static $owns = [
        'VideoImage'
    ];

    private static $summary_fields = [
        'VideoImage.CMSThumbnail' => 'Image',
        'Title' => 'Title'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            TextField::create('VideoURL', 'Video URL')->showYouTubeHelper(),
            UploadField::create('VideoImage')->setAllowedFileCategories('image')
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'VideoURL'
        ]);
    }

    public function onAfterWrite()
    {
        if (!$this->VideoImageID && $this->VideoURL) {
            if ($thumbnail = Util::getYouTubeThumbnail($this->VideoURL, $this->VideoImage, 'ElementAssets')) {
                $this->VideoImageID = $thumbnail->ID;
                $this->write();
            }
        }

        parent::onAfterWrite();
    }
}
