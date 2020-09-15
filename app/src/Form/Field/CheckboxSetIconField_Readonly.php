<?php

namespace App\Form\Field;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class CheckboxSetIconField_Readonly extends CheckboxSetIconField
{
    public function AttrValues()
    {
        $source = $this->getSource();
        $values = $this->getValueArray();

        $selected = ArrayList::create();

        foreach ($values as $value) {
            $data = $source[$value];

            $selected->push(ArrayData::create([
                'Title' => $data[0],
                'Icon' => $data[1]
            ]));
        }

        return $selected;
    }

    public function InputValue()
    {
        return join(', ', $this->getValueArray());
    }

    public function performReadonlyTransformation()
    {
        return clone $this;
    }
}
