<?php

namespace App\Extension;

use App\Email\StyledEmail;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;
use SilverStripe\UserForms\Model\EditableFormField\EditableEmailField;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\View\ArrayData;

class UserformSubmittedForm extends DataExtension
{
    public function updateAfterProcess()
    {
        $this->owner->onBeforeWrite();
        $current = Director::get_current_page();
        $uf = UserDefinedForm::get()->byID($current->ID);
        $toEmail = false;

        foreach ($this->owner->Values() as $field) {
            if ($field->getEditableField()->ClassName == EditableEmailField::class) {
                $toEmail = $field->Value;
            }
        }

        if (filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            if ($uf->AutoresponderEnabled) {
                $from = $uf->EmailFrom;

                if ($uf->EmailFrom == '') {
                    $from = 'info@signinapp.com';
                }

                $subject = $uf->AutoresponderSubject;
                $content = $uf->AutoresponderContent;

                $body = ArrayData::create([
                    'Subject' => $subject,
                    'Body' => $content
                ])->renderWith('App/Email/GenericEmail');

                $email = new StyledEmail($toEmail, $subject);
                $email->setFrom($from);
                $email->build($body);
                $email->send();
            }
        }
    }
}
