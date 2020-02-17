<p  align="center"><img  src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg"  width="400"></p>

  

## How to run the project

1. Clone the repo.

2. Install xampp(or any related programs) and start Apache and MySQL server.

3. Open phpmyadmin and create a database named `employeedata`

4. Duplicate .env.example and edit some lines as below:
	```
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=employeedata
	DB_USERNAME=root
	DB_PASSWORD=
	```

5. Install composer.

6. Run commands below:

	```
	php artisan key:generate
	php artisan cache:clear
	php artisan migrate
	php artisan passport:install
	php artisan serve
	```

  

## API Testing

1. To make fake employee data before API testing, run:

	`php artisan db:seed`

2. Import postman collection given in the root folder, to test all of the API:
Open postman > import > choose file > EmployeeData.postman_collection