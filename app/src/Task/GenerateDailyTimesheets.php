<?php

namespace App\Task;

use App\Model\Employee;
use SilverStripe\Dev\BuildTask;

class GenerateDailyTimesheets extends BuildTask
{
    protected $title = 'Generate Daily Timesheets';

    protected $description = 'Generates today\'s timesheet for all employees.';

    public function run($request)
    {
        $employees = Employee::get()->filter(['ActiveEmployee' => true]);
        foreach ($employees as $employee) {
            if (!$employee->getTodaysTimesheet()) {
                $employee->generateTimesheet();
            }
        }
    }
}
