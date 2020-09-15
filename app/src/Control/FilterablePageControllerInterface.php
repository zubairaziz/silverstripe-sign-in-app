<?php

namespace App\Control;

interface FilterablePageControllerInterface
{
    public function setIndexFilters();
    public function getFilterParams();
    public function getIsFiltered();
    public function getFilteredHeading();
}
