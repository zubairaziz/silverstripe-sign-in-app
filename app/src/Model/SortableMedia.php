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
use SilverStripe\Forms\SelectionGroup;
use SilverStripe\Forms\SelectionGroup_Item;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class SortableMedia extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'SortableMedia';
    private static $singular_name = 'Media Item';

    private static $extensions = [
        Sortable::class
    ];

    private static $db = [
        'MediaType' => 'Enum("Image,Video", "Image")',
        'VideoURL' => DBVideoURL::class
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Owner' => DataObject::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Media',
        'MediaType' => 'Type'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            SelectionGroup::create(
                'MediaType',
                [
                    SelectionGroup_Item::create(
                        'Image',
                        null,
                        'Image'
                    ),
                    SelectionGroup_Item::create(
                        'Video',
                        TextField::create('VideoURL', '')->showYouTubeHelper(),
                        'Video'
                    )
                ]
            )->setTitle('Media Type'),
            Wrapper::create(
                UploadField::create('Image')->setAllowedFileCategories('image')
            )->displayIf('MediaType')->isNotEmpty()->end()
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Type'
        ]);
    }

    public function validate()
    {
        $result = parent::validate();

        switch ($this->Type) {
            case 'Image':
                if (!$this->Image()->exists()) {
                    $result->addError('Image is required');
                }
                break;
            case 'Video':
                if (is_null($this->VideoURL)) {
                    $result->addError('Video URL is required');
                }
                break;
        }

        return $result;
    }

    public function getTitle()
    {
        return $this->MediaType;
    }

    public function getIsImage()
    {
        return $this->MediaType == 'Image';
    }

    public function getIsVideo()
    {
        return $this->MediaType == 'Video';
    }

    public function onAfterWrite()
    {
        if (!$this->ImageID && $this->VideoURL) {
            if ($thumbnail = Util::getYouTubeThumbnail($this->VideoURL, $this->Image, 'ElementAssets')) {
                $this->ImageID = $thumbnail->ID;
                $this->write();
            }
        }

        parent::onAfterWrite();
    }
}
