<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeResourceCollection;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    public function index(): EmployeeResourceCollection
    {
        return new EmployeeResourceCollection(Employee::paginate());
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'kpi' => 'required',
        ]);

        $employee = Employee::create($request->all());

        return new EmployeeResource($employee);
    }

    public function update(Employee $employee, Request $request): EmployeeResource
    {
        $employee->update($request->all());

        return new EmployeeResource($employee);
    }
}
