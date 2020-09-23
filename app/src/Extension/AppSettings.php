<?php

namespace App\Extension;

use SilverStripe\ORM\DataExtension;

class AppSettings extends DataExtension
{
    public function canCreate($member = null, $context = [])
    {
        return false;
    }

    public function canDelete($member = null)
    {
        return false;
    }
}
