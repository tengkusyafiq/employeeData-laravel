<p  align="center"><img  src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg"  width="400"></p>

  

<p  align="center">

<a  href="https://travis-ci.org/laravel/framework"><img  src="https://travis-ci.org/laravel/framework.svg"  alt="Build Status"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/d/total.svg"  alt="Total Downloads"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/v/stable.svg"  alt="Latest Stable Version"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/license.svg"  alt="License"></a>

</p>

  

## About Laravel

  

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

  

-  [Simple, fast routing engine](https://laravel.com/docs/routing).

-  [Powerful dependency injection container](https://laravel.com/docs/container).

- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.

- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).

- Database agnostic [schema migrations](https://laravel.com/docs/migrations).

-  [Robust background job processing](https://laravel.com/docs/queues).

-  [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

  

Laravel is accessible, powerful, and provides tools required for large, robust applications.

  

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