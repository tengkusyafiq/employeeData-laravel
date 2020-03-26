<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function model(array $row)
    {
        return new Employee([
            // assign the column name you want to get in Excel
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'kpi' => $row['kpi'],
            'action' => $row['action'], // to to CUD operations in controller
        ]);
    }
}
