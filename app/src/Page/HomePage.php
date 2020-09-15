<?php

namespace App\Page;

use App\Extension\SinglePageInstance;
use App\Form\Field\DBVideoURL;
use App\Model\Statistic;
use App\Util\Util;
use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\SiteConfig\SiteConfig;

class HomePage extends Page
{
    private static $table_name = 'HomePage';
    private static $singular_name = 'Home Page';
    private static $plural_name = 'Home Pages';
    private static $description = 'The main Home Page for the site';

    private static $extensions = [
        SinglePageInstance::class
    ];

    private static $db = [
        'MainHeader' => 'Varchar',
        'FormHeader' => 'Varchar',
        'JobHeader' => 'Varchar',
        'FormButtonLabel' => 'Varchar',
        'JobButtonLabel' => 'Varchar',
        'SuccessResponse' => 'HTMLText',
        'VideoURL' => DBVideoURL::class,
        'FundContent' => 'HTMLText',
        'FundButtonLabel' => 'Varchar',
    ];

    private static $has_one = [
        'VideoThumbnail' => Image::class,
        'FundImageMain' => Image::class,
        'FundImageHeader' => Image::class,
    ];

    private static $owns = [
        'VideoThumbnail',
        'FundImageMain',
        'FundImageHeader',
    ];

    private static $has_many = [
        'Statistics' => Statistic::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Content']);

        $fields->addFieldsToTab('Root.Main Panel', [
            TextField::create('MainHeader', 'Main Header'),
            TextField::create('FormHeader', 'Form Header')->showEmphasisHelper(),
            TextField::create('FormButtonLabel', 'Form Button Label'),
            TextField::create('JobHeader', 'Job Header')->showEmphasisHelper(),
            TextField::create('JobButtonLabel', 'Job Button Label'),
            HTMLEditorField::create('SuccessResponse', 'Success Response'),
        ]);

        $fields->addFieldsToTab('Root.Stats Panel', [
            GridField::create(
                'Statistics',
                'Statistics',
                $this->Statistics(),
                Util::getRecordEditorConfig()
            )
        ]);

        $fields->addFieldsToTab('Root.Video Panel', [
            TextField::create('VideoURL', 'Video URL'),
            UploadField::create('VideoThumbnail', 'Video Thumbnail'),
        ]);

        $fields->addFieldsToTab('Root.Fund Panel', [
            UploadField::create('FundImageMain', 'Main Image'),
            UploadField::create('FundImageHeader', 'Header Image'),
            HTMLEditorField::create('FundContent', 'Content'),
            TextField::create('FundButtonLabel', 'Button Label'),
        ]);

        return $fields;
    }

    public function getStructuredData()
    {
        $data = SiteConfig::current_site_config()->getSiteStructuredData();

        return json_encode($data);
    }
}
