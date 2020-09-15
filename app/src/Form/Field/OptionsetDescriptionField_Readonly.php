<?php

namespace App\Form\Field;

class OptionsetDescriptionField_Readonly extends OptionsetDescriptionField
{
    public function AttrValue()
    {
        $source = $this->getSource();

        return $source[$this->value][0];
    }

    public function AttrDescription()
    {
        $source = $this->getSource();

        return $source[$this->value][1];
    }

    public function InputValue()
    {
        return $this->value;
    }

    public function performReadonlyTransformation()
    {
        return clone $this;
    }
}
