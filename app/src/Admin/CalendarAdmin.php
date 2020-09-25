<?php

namespace App\Admin;

use App\Model\CalendarSettings;
use SilverStripe\Security\PermissionProvider;

class CalendarAdmin extends SettingsAdmin implements PermissionProvider
{
    private static $url_segment = 'calendar';
    private static $menu_title = 'Calendar';
    private static $menu_icon_class = 'fas fa-calendar';
    private static $required_permission_codes = ['CMS_ACCESS_CalendarAdmin'];
    protected static $settings = CalendarSettings::class;

    public function updateEditFormBefore($form)
    {
        $fields = $form->Fields();
    }

    public function providePermissions()
    {
        return [
            'CMS_ACCESS_CalendarAdmin' => [
                'name' => "Access to 'Calendar' section",
                'category' => 'CMS Access'
            ]
        ];
    }
}
