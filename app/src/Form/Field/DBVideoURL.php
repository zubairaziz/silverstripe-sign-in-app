<?php

namespace App\Form\Field;

use App\Util\Util;
use SilverStripe\ORM\FieldType\DBVarchar;

class DBVideoURL extends DBVarchar
{
    public function prepValueForDB($value)
    {
        if ($videoID = Util::getYouTubeID(trim($value))) {
            // return sprintf('https://www.youtube.com/embed/%s', $videoID);
            return sprintf('https://www.youtube.com/watch?v=%s', $videoID);
        }

        return $value;
    }
}
