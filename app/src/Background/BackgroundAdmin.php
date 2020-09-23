<?php

namespace App\Background;

use App\Admin\SettingsAdmin;
use SilverStripe\Security\PermissionProvider;

class BackgroundAdmin extends SettingsAdmin implements PermissionProvider
{
    private static $url_segment = 'backgrounds';
    private static $menu_title = 'Backgrounds';
    private static $menu_icon_class = 'fas fa-images';
    private static $required_permission_codes = ['CMS_ACCESS_BackgroundAdmin'];
    protected static $settings = BackgroundSettings::class;

    public function updateEditFormBefore($form)
    {
        $fields = $form->Fields();
    }

    public function providePermissions()
    {
        return [
            'CMS_ACCESS_BackgroundAdmin' => [
                'name' => "Access to 'Backgrounds' section",
                'category' => 'CMS Access'
            ]
        ];
    }
}
