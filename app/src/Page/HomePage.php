<?php

namespace App\Page;

use App\Extension\SinglePageInstance;
use Page;
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
    ];

    private static $has_one = [
    ];

    private static $owns = [
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Content']);

        return $fields;
    }

    public function getStructuredData()
    {
        $data = SiteConfig::current_site_config()->getSiteStructuredData();

        return json_encode($data);
    }
}
