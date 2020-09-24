<?php

namespace App\Admin;

use App\Model\Timesheet;

class TimesheetAdmin extends ModelAdmin
{
    private static $url_segment = 'timesheets';
    private static $menu_title = 'Timesheets';
    private static $menu_icon_class = 'fas fa-business-time';
    private static $managed_models = [
        Timesheet::class
    ];
}
