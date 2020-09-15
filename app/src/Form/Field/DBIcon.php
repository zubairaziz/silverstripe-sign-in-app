<?php

namespace App\Form\Field;

use App\Util\AssetUtil;
use SilverStripe\ORM\FieldType\DBVarchar;

class DBIcon extends DBVarchar
{
    public function forTemplate()
    {
        if ($this->exists()) {
            return AssetUtil::getAssetIcon($this->value);
        }
    }

    public function scaffoldFormField($title = null, $params = null)
    {
        return IconField::create(
            $this->name,
            $title
        );
    }
}
