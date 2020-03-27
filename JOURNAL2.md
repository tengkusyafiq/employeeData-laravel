## Setup passport
to install passport and use GRANT password, its really easy, no need to setup login route api at all.
just follow: https://laravel.com/docs/7.x/passport#installation
php artisan passport:client to make a client

To login/get token:
use POST to http://127.0.0.1:8000/oauth/token/
the body should have this info:
    grant_type:password
    client_id:3
    client_secret:YQPBGGChnGKjzjnirB35D7T6OBfsDEFaHSNcKPSC
    username:delilah@vimigo.my
    password:password
    scope:*

## search:
https://www.youtube.com/watch?v=3PeF9UvoSsk
https://www.youtube.com/results?search_query=Laravel+api+Pagination+with+Filters
https://www.youtube.com/watch?v=KWnmOBkHzUo

## csv import user
https://www.youtube.com/channel/UC4gijXR8cM4gmEt9Olse-TQ/search?query=inferno+%2315


## how to handle exception eg: 404 etc
https://www.youtube.com/watch?v=_mdZxG6ExbE


## to do import csv

To setup laravel excel:
https://docs.laravel-excel.com/3.1/getting-started/installation.html
`composer require maatwebsite/excel`
`php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"`


To make import:
https://docs.laravel-excel.com/3.1/imports/
`php artisan make:import EmployeesImport --model=Employee`

_KIV_ See example of import file here:
https://www.w3adda.com/blog/laravel-6-import-excel-csv-file-database-using-maatwebsite
basically fill in the column here.


Add the route api for import:
```php
Route::prefix('v1')->name('v1.')->group(function () {
    // get employee data, use apiResource to make it restful
    Route::apiResource('employee', 'Api\v1\EmployeeController')->middleware('auth:api');
    Route::post('employee/import', 'Api\v1\EmployeeController@import')->name('employee.import')->middleware('auth:api');
});
```

Make the `import()` method in the controller:
https://www.webslesson.info/2019/02/import-excel-file-in-laravel.html

## better approach to make validation flexible to be used multiple times
put validation rule in model.
https://medium.com/@konafets/a-better-place-for-your-validation-rules-in-laravel-f5e3f5b7cc

then validate something(input or array) using:
https://stackoverflow.com/questions/42258185/how-to-validate-array-in-laravel
```php
$validator = Validator::make($input, $rules);

//Now check validation:
if ($validator->fails()) 
{ 
  /* do something */ 
}
```
or in laravel docs
https://laravel.com/docs/5.8/validation
```php
use Illuminate\Support\Facades\Validator;

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Store the blog post...
```