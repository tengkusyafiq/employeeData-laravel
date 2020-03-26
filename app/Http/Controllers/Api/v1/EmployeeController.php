<?php

namespace App\Http\Controllers\Api\v1;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeResourceCollection;
use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        // return response()->json($employee['email']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);

        $employees = Excel::toArray(new EmployeesImport(), request()->file('import_file'));

        foreach ($employees as $array) { // since it has outer array
            foreach ($array as $employee) {
                // validate all rows here
                // if (validated){code below}
                // dd($employee);
                // $employee = $request->validate([
                //     'id' => 'required',
                //     'first_name' => 'required',
                //     'last_name' => 'required',
                //     'phone' => 'required',
                //     'email' => 'required|unique:employees,email',
                //     'kpi' => 'required',
                //     'action' => 'required',
                // ]);

                // without validation: empty input cant be detected

                switch ($employee['action']) {
                    case 'create': //working
                        // without validation:
                        // same user can be created multiple times, so we use this
                        if (Employee::where('email', '=', $employee['email'])->exists()) {
                            // if user already exists
                            break;
                        }
                        Employee::create([
                            'first_name' => $employee['first_name'],
                            'last_name' => $employee['last_name'],
                            'phone' => $employee['phone'],
                            'email' => $employee['email'],
                            'kpi' => $employee['kpi'],
                        ]);

                        break;
                    case 'update': //working
                        Employee::where('email', $employee['email'])->update([
                            'first_name' => $employee['first_name'],
                            'last_name' => $employee['last_name'],
                            'phone' => $employee['phone'],
                            'email' => $employee['email'],
                            'kpi' => $employee['kpi'],
                        ]);

                        break;
                    case 'delete': //working
                        Employee::where('email', $employee['email'])->delete();

                        break;
                }
            }
        }

        return response()->json('Operation is finished.', 200);
    }
}
