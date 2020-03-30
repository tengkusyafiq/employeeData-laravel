<?php

namespace App\Http\Controllers\Api\v1;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeResourceCollection;
use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    public function index(Request $request): EmployeeResourceCollection
    {
        $employees = Employee::query();

        if (!empty($request->search)) {
            $s = $request->search;
            $employees = Employee::where(function ($q) use ($s) {
                $q->orWhere('first_name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                ;
            });
        }

        return new EmployeeResourceCollection($employees->paginate());
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

    public function update(UpdateEmployeeRequest $request, Employee $employee): EmployeeResource
    {
        dd($request->all());
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
        $messages = [
            'create_errors' => [],
            'update_errors' => [],
        ]; // gather all errors to be reported

        $request->validate([
            'import_file' => 'required|file',
        ]);

        $employees = Excel::toArray(new EmployeesImport(), request()->file('import_file'));

        foreach ($employees as $array) { // since it has outer array
            foreach ($array as $key => $employee) {
                $employeeData = [
                    'first_name' => $employee['first_name'],
                    'last_name' => $employee['last_name'],
                    'phone' => $employee['phone'],
                    'email' => $employee['email'],
                    'kpi' => $employee['kpi'],
                ];

                switch ($employee['action']) {
                    case 'create': //working
                        // validate before create, so same email cant be created again.
                        $validator = Validator::make($employeeData, Employee::createRules());
                        if ($validator->fails()) {
                            $messages['create_errors'][] = ['row' => 2 + $key, 'email' => $employeeData['email']];
                        } else {
                            Employee::create($employeeData);
                        }

                        break;
                    case 'update': //working
                        // validate before update, must have email as a reference to which employee to update.
                        $validateEmail = Employee::updateRules();
                        $validateEmail['email'] = 'required';
                        $validator = Validator::make($employeeData, $validateEmail);
                        if ($validator->fails()) {
                            $messages['update_errors'][] = 'Cannot update user '.$employeeData['email'].'. ';
                        } else {
                            // tell users if the employee to update, doesn't exists in our db.
                            if (Employee::where('email', '=', $employee['email'])->exists()) {
                                // update employee data
                                Employee::where('email', $employee['email'])->update($employeeData);
                            } else {
                                $messages['update_errors'][] = 'User '.$employeeData['email'].'does not exists in our database. ';
                            }
                        }

                        break;
                    case 'delete': //working
                        Employee::where('email', $employee['email'])->delete();

                        break;
                }
            }
        }
        $messages['result'] = 'Operation finished.';

        return response()->json($messages, 200);
    }
}
