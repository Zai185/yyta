# Laravel University Project

This project is a Laravel-based application designed to manage university-related data, including users, batches, courses, departments, staff, lecturers, modules, and students. It utilizes Filament for creating forms and tables for easy management of these entities.

## Project Structure

The project is organized as follows:

```
laravel-uni-proj
├── app
│   ├── Console
│   ├── Exceptions
│   ├── Filament
│   │   ├── Resources
│   │   │   ├── BatchResource.php
│   │   │   ├── CourseResource.php
│   │   │   ├── DepartmentResource.php
│   │   │   ├── LecturerResource.php
│   │   │   ├── ModuleResource.php
│   │   │   ├── StaffResource.php
│   │   │   └── StudentResource.php
│   │   └── Pages
│   ├── Http
│   │   ├── Controllers
│   ├── Models
│   │   ├── Batch.php
│   │   ├── Course.php
│   │   ├── Department.php
│   │   ├── Lecturer.php
│   │   ├── Module.php
│   │   ├── Staff.php
│   │   ├── Student.php
│   │   └── User.php
├── database
│   ├── factories
│   ├── migrations
│   │   ├── 2024_01_01_000001_create_batches_table.php
│   │   ├── 2024_01_01_000002_create_courses_table.php
│   │   ├── 2024_01_01_000003_create_departments_table.php
│   │   ├── 2024_01_01_000004_create_lecturers_table.php
│   │   ├── 2024_01_01_000005_create_modules_table.php
│   │   ├── 2024_01_01_000006_create_staff_table.php
│   │   ├── 2024_01_01_000007_create_students_table.php
│   │   └── 2024_01_01_000008_create_users_table.php
│   └── seeders
├── routes
│   └── web.php
├── .env.example
├── artisan
├── composer.json
├── package.json
├── README.md
└── resources
    └── views
```

## Features

- **User Management**: Manage users with roles such as staff and lecturers.
- **Batch Management**: Create and manage student batches.
- **Course Management**: Define courses with details like duration and fees.
- **Department Management**: Organize staff and lecturers into departments.
- **Lecturer Management**: Manage lecturer details and their associated departments.
- **Module Management**: Define modules associated with courses.
- **Student Management**: Manage student details and their associated batches.

## Installation

1. Clone the repository:
   ```
   git clone <repository-url>
   cd laravel-uni-proj
   ```

2. Install dependencies:
   ```
   composer install
   npm install
   ```

3. Set up the environment file:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations:
   ```
   php artisan migrate
   ```

5. Serve the application:
   ```
   php artisan serve
   ```

## Usage

Access the application at `http://localhost:8000`. Use the Filament admin panel to manage the various entities of the university.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any improvements or features.

## License

This project is licensed under the MIT License. See the LICENSE file for details.