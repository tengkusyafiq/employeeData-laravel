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
        $response = new EmployeeResource($employee);
        if ($employee) {
            // return response()->json($response, 200); //error
            return $response;
        }

        return response()->json(['message' => 'Employee cannot be updated.'], 500);
    }

    public function update(Employee $employee, Request $request): EmployeeResource
    {
        $result = $employee->update($request->all());
        $response = new EmployeeResource($employee);
        if ($result) {
            // return response()->json($response, 200); //error
            return $response;
        }

        return response()->json(['message' => 'Employee cannot be updated.'], 400);
    }

    public function destroy(Employee $employee)
    {
        $result = $employee->delete();

        if ($result) {
            // still return empty json since we're returning 204(empty)
            return response()->json(['message' => 'Delete successful.'], 204);
        }

        return response()->json(['message' => 'Delete failed.'], 500);
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
