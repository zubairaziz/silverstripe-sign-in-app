<?php

namespace App\Security;

trait APIPermissionProvider
{
    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return true;
    }

    public function canDelete($member = null)
    {
        return true;
    }

    public function canView($member = null)
    {
        return true;
    }

    public function canPublish($member = null)
    {
        return true;
    }
}
