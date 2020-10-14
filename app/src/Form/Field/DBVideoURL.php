<?php

namespace App\Form\Field;

use App\Util\Util;
use SilverStripe\ORM\FieldType\DBVarchar;

class DBVideoURL extends DBVarchar
{
    public function prepValueForDB($value)
    {
        if ($videoID = Util::getYouTubeID(trim($value))) {
            return "https://www.youtube.com/watch?v={$videoID}";
        }

        return $value;
    }
}
