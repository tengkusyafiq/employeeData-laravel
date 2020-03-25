<?php

namespace App\Http\Controllers\Api\v1;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
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

    public function store(CreateEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        return new EmployeeResource($employee);
    }

    public function update(Employee $employee, Request $request): EmployeeResource
    {
        $employee->update($request->all());

        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee)
    {
        $result = $employee->delete();

        return response()->json([], 204);
    }
}
