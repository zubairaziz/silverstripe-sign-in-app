<?php

namespace App\Extension;

use SilverStripe\Core\Extension;

class StyledUserform extends Extension
{
    public function updateForm()
    {
        $form = $this->owner;

        $page = $form->controller->URLSegment;

        $form->addExtraClass('styled-userform has-custom-validation');

        $template = '';

        switch ($page) {
            case 'rental-listing-form':
                $template = 'Form/StyledFormRentalListing';
                break;
            default:
                $template = 'Form';
        }

        $form->setTemplate($template);
        $form->enableSpamProtection();
    }
}
