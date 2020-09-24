<?php

namespace App\Admin;

use App\Model\MessageSettings;
use SilverStripe\Security\PermissionProvider;

class MessageAdmin extends SettingsAdmin implements PermissionProvider
{
    private static $url_segment = 'messages';
    private static $menu_title = 'Messages';
    private static $menu_icon_class = 'fas fa-comments';
    private static $required_permission_codes = ['CMS_ACCESS_MessageAdmin'];
    protected static $settings = MessageSettings::class;

    public function updateEditFormBefore($form)
    {
        $fields = $form->Fields();
    }

    public function providePermissions()
    {
        return [
            'CMS_ACCESS_MessageAdmin' => [
                'name' => "Access to 'Messages' section",
                'category' => 'CMS Access'
            ]
        ];
    }
}
