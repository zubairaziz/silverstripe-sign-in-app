<?php

use App\Model\Employee;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Dev\Debug;

class PageController extends ContentController
{
    private static $allowed_actions = [
        'SignInForm'
    ];

    protected function init()
    {
        parent::init();
    }

    public function getIsLoggedIn()
    {
        return $this->getRequest()->getSession()->get('LoggedIn');
    }

    public function getLoggedInEmployee()
    {
        return $this->getRequest()->getSession()->get('Employee');
    }

    public function getAllEmployees()
    {
        if ($this->getIsLoggedIn()) {
            return Employee::get()
                ->filter(['ActiveEmployee' => true])
                ->exclude(['ID' => $this->getLoggedInEmployee()->ID]);
        }
        return Employee::get()->filter(['ActiveEmployee' => true]);
    }

    public function getSession()
    {
        $session = $this->getRequest()->getSession();
        Debug::show($session);
        return $session;
    }

    public function getDebug()
    {
        $this->getSession();
        return 'Debug';
    }
}
