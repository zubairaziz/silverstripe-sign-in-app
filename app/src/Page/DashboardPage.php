<?php

namespace App\Page;

use App\Extension\SinglePageInstance;
use Page;
use SilverStripe\SiteConfig\SiteConfig;

class DashboardPage extends Page
{
    private static $table_name = 'DashboardPage';
    private static $singular_name = 'Dashboard Page';
    private static $plural_name = 'Dashboard Pages';
    private static $description = 'Dashboard for admins';
    private static $icon_class = 'font-icon-p-data';

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
