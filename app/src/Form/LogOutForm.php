<?php

namespace App\Form;

use App\Page\HomePage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class LogOutForm extends Form
{
    public function __construct($controller, $name, $isNavigation = false)
    {
        $page = HomePage::get()->first();

        $fields = null;

        if ($isNavigation) {
            $this->addExtraClass('inline-block w-12 h-12');
            $actions = FieldList::create(
                FormAction::create('submit', 'Log Out')
                    ->setUseButtonTag(true)
            );
        } else {
            $actions = FieldList::create(
                FormAction::create('submit', 'Cancel')
                    ->setUseButtonTag(true)
                    ->addExtraClass('button button-secondary my-1')
            );
        }

        $required = null;

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('log-out-form');

        if ($isNavigation) {
            $this->setTemplate('App/Form/NavigationLogOutForm');
        } else {
            $this->setTemplate('App/Form/SingleActionForm');
        }
    }

    public function submit($data, $form)
    {
        $success = true;

        $session = $this->controller->getSession();
        $session->set('LoggedIn', false);
        $session->set('EmployeeID', null);
        $session->set('Employee', null);

        return $this->controller->handlelogout($success);
    }
}
