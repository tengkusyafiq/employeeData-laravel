<?php

namespace App\Http\Controllers;

use App\Employee;

class EmployeeController extends Controller
{
    public function show(Employee $employee)
    {
        return $employee;
    }
}
