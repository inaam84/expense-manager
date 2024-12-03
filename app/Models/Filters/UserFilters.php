<?php

namespace App\Models\Filters;

use App\Models\Lookups\UserWebAccess;
use Illuminate\Http\Request;

class UserFilters extends QueryFilters
{
    protected $request;

    protected $filterKey = 'ViewUsers_Filters';

    protected $defaultFilters = [
        'sortBy' => 'firstname',
        'direction' => 'ASC',
        'perPage' => '20',
    ];

    protected $viewFilters = [
        'firstname' => null,
        'lastname' => null,
        'email' => null,
        'username' => null,
        'system_access' => null,
    ];

    protected function getDefaultFilters()
    {
        return $this->defaultFilters;
    }

    protected function getViewFilters()
    {
        return $this->viewFilters;
    }

    public function getFilterKey()
    {
        return $this->filterKey;
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function firstname($value = '')
    {
        if ($value) {
            $this->builder->where('firstname', 'LIKE', '%'.addslashes($value).'%');
        }
    }

    public function lastname($value = '')
    {
        if ($value) {
            $this->builder->where('lastname', 'LIKE', '%'.addslashes($value).'%');
        }
    }

    public function username($value = '')
    {
        if ($value) {
            $this->builder->where('username', addslashes($value));
        }
    }

    public function email($value = '')
    {
        if ($value) {
            $this->builder->where('email', $value);
        }
    }

    public function system_access($value = '')
    {
        if ($value || $value == '0') {
            $this->builder->where('system_access', $value);
        }
    }

    public function sortBy($column)
    {
        $allowedColumns = ['firstname', 'created_at'];

        if (in_array($column, $allowedColumns)) {
            $direction = isset($this->filters()['direction']) ? $this->filters()['direction'] : 'ASC';

            $this->builder->orderBy($column, $direction);

        }
    }

    public function perPage($value = '')
    {
        session(['user_per_page' => $value]);
    }

    public function render()
    {
        $html = '';

        // row
        $html .= html()->div()->attributes(['class' => 'row'])->open();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('First Name')->for('firstname')->class('form-label');
        $html .= html()->text('firstname')->class('form-control form-control-sm mb-3')->value($this->filters()['firstname'])->attribute('maxlength', 70);
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Last Name')->for('lastname')->class('form-label');
        $html .= html()->text('lastname')->class('form-control form-control-sm mb-3')->value($this->filters()['lastname'])->attribute('maxlength', 70);
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Username')->for('username')->class('form-label');
        $html .= html()->text('username')->class('form-control form-control-sm mb-3')->value($this->filters()['username'])->attribute('maxlength', 50);
        $html .= html()->div()->close();
        $html .= html()->div()->close();

        // row
        $html .= html()->div()->attributes(['class' => 'row'])->open();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Email')->for('email')->class('form-label');
        $html .= html()->text('email')->class('form-control form-control-sm mb-3')->value($this->filters()['email'])->attribute('maxlength', 70);
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('System Access')->for('system_access')->class('form-label');
        $html .= html()->select('system_access')->class('form-select form-select-sm mb-3')->value((int) $this->filters()['system_access'])->options(['' => ''] + UserWebAccess::getList());
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->div()->close();
        $html .= html()->div()->close();

        // row
        $html .= html()->div()->attributes(['class' => 'row'])->open();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Sort By')->for('sortBy')->class('form-label');
        $html .= html()->select('sortBy')->class('form-select form-select-sm mb-3')->value($this->filters()['sortBy'])->options(['firstname' => 'First Name', 'created_at' => 'Creation Date']);
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Order By')->for('direction')->class('form-label');
        $html .= html()->select('direction')->class('form-select form-select-sm mb-3')->value($this->filters()['direction'])->options(['ASC' => 'Ascending', 'DESC' => 'Descending']);
        $html .= html()->div()->close();
        $html .= html()->div()->attributes(['class' => 'col-md-4'])->open();
        $html .= html()->label('Per Page')->for('perPage')->class('form-label');
        $html .= html()->select('perPage')->class('form-select form-select-sm mb-3')->value((int) $this->filters()['perPage'])->options(getPerPageDdl());
        $html .= html()->div()->close();
        $html .= html()->div()->close();

        return $html;
    }
}
