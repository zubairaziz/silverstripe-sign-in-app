<?php

namespace App\Page;

use App\Control\FilterablePageControllerInterface;
use App\Model\Employee;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\ArrayData;

class DashboardPageController extends PaginatedPageController implements FilterablePageControllerInterface
{
    protected $searchTerm = null;
    protected $searchCategory = null;
    protected $pageLength = 6;

    private static $allowed_actions = [
        'employee'
    ];

    private static $url_handlers = [
        'employee/$URLSegment!' => 'employee'
    ];

    public function init()
    {
        parent::init();
    }

    public function employee()
    {
        if ($employee = Employee::get()->filter('URLSegment', $this->getRequest()->param('URLSegment'))->first()) {
            return $this->customise([
                'Employee' => $employee,
                'HolderPage' => $this->data(),
            ])->render();
        }

        return $this->httpError(404);
    }

    public function setIndexFilters()
    {
        if ($searchTerm = $this->request->getVar('search')) {
            $this->searchTerm = urldecode($searchTerm);
        }
    }

    public function getPageResults()
    {
        $items = Employee::get();

        if ($this->searchTerm) {
            $items = $items->filterAny([
                'FirstName:PartialMatch' => $this->searchTerm,
                'LastName:PartialMatch' => $this->searchTerm,
            ]);
        }

        return $this->getResultsResponse($items, 'App/Page/Includes/EmployeeList');
    }

    public function getFilterParams()
    {
        return ArrayData::create([
            'SearchTerm' => $this->searchTerm,
        ]);
    }

    public function getIsFiltered()
    {
        return count(array_filter([$this->searchTerm])) > 0;
    }

    public function getFilteredHeading()
    {
        $filterValue = '';

        if ($this->searchTerm) {
            $filterValue = $this->searchTerm;
        }

        $heading = sprintf('<strong>Searching:</strong> %s', $filterValue);

        return DBField::create_field('HTMLText', $heading);
    }
}
