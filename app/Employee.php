<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'kpi' => 'required',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'kpi',
    ];

    public static function createRules()
    {
        $createRules = self::$rules;
        $createRules['email'] .= '|unique:employees,email';

        return $createRules;
    }

    public static function updateRules()
    {
        return preg_filter('/^/', 'sometimes|', self::$rules);
    }
}
