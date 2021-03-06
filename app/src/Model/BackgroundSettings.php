<?php

namespace App\Model;

use App\Extension\AppSettings;
use App\Security\CMSPermissionProvider;
use App\Util\Util;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataObject;
use TractorCow\Colorpicker\Color;
use TractorCow\Colorpicker\Forms\ColorField;

class BackgroundSettings extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'BackgroundSettings';
    private static $hide_from_form_admin = true;

    private static $extensions = [
        AppSettings::class
    ];

    private static $db = [
        'UseBackgroundColor' => 'Boolean',
        'BackgroundColor' => Color::class
    ];

    private static $has_one = [
        'BackgroundVideo' => File::class
    ];

    private static $owns = [
        'BackgroundVideo'
    ];

    private static $has_many = [
        'BackgroundImages' => SortableImage::class
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $fields->addFieldsToTab('Root.Background.Solid Color', [
            FieldGroup::create(
                'Enable Background Color',
                CheckboxField::create('UseBackgroundColor', 'Use Solid Background Color')
            ),
            ColorField::create('BackgroundColor', 'Background Color')
        ]);

        $fields->addFieldsToTab('Root.Background.Image', [
            GridField::create(
                'BackgroundImages',
                'Image(s)',
                $this->owner->BackgroundImages(),
                Util::getRecordEditorConfig()
            )
        ]);

        $fields->addFieldsToTab('Root.Background.Video', [
            UploadField::create(
                'BackgroundVideo',
                'Video'
            )->setAllowedExtensions(['mp4', 'wav', 'webm'])
        ]);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function populateDefaults()
    {
        $this->BackgroundColor = '514A6B';

        parent::populateDefaults();
    }

    public static function current_settings()
    {
        $settings = DataObject::get_one(self::class);

        if ($settings) {
            return $settings;
        }

        return self::make_settings();
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        $settings = DataObject::get_one(self::class);

        if (!$settings) {
            self::make_settings();
        }
    }

    public static function make_settings()
    {
        $settings = self::create();
        $settings->write();

        return $settings;
    }
}
