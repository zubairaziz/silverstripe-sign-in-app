<?php

namespace App\Admin;

use App\Model\Employee;

class EmployeeAdmin extends ModelAdmin
{
    private static $url_segment = 'employees';
    private static $menu_title = 'Employees';
    private static $menu_icon_class = 'fas fa-users';
    private static $managed_models = [
        Employee::class
    ];
}
