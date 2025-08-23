# Todo List API

A RESTful API built with Laravel for managing todo items. This API serves as the backend for the [Todo List Vue.js Frontend](https://github.com/Orekidesu/todo-list).

## Features

-   Create, read, update, and delete todo items
-   User authentication and registration
-   Category management for organizing tasks
-   RESTful API endpoints with versioning
-   JSON responses
-   Laravel framework with modern PHP practices

## Prerequisites

Before running this project, make sure you have the following installed:

-   **PHP 8.1 or higher**
-   **Composer** - [Download here](https://getcomposer.org/)
-   **MySQL 5.7+ or MariaDB 10.3+**
-   **Node.js 16+ and npm** (for asset compilation)
-   **Git**

### Recommended Development Environment

-   **Laragon** (Windows) - [Download here](https://laragon.org/)
-   **XAMPP** (Cross-platform) - [Download here](https://www.xampp.org/)
-   **Laravel Valet** (macOS) - [Installation guide](https://laravel.com/docs/valet)

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/Orekidesu/todo_api.git
    cd todo-list-api
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Copy environment file**

    ```bash
    copy .env.example .env
    ```

4. **Generate application key**

    ```bash
    php artisan key:generate
    ```

5. **Configure database**

    Edit the `.env` file with your database credentials:

    ```
    FRONTEND_URL=http://localhost:5173 (default frontend url)
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=todo_list_api
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Create database**

    Create a new database named `todo_list_api` in your MySQL server.

7. **Run database migrations**

    ```bash
    php artisan migrate
    ```

## Running the Application

1. **Start the development server**

    ```bash
    php artisan serve
    ```

    The API will be available at `http://localhost:8000`

2. **For production deployment**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

## 📁 Project Structure

```
todo-list-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── V1/
│   │   │           ├── Auth/                    # Authentication controllers
│   │   │           │   ├── AuthenticatedSessionController.php
│   │   │           │   ├── EmailVerificationNotificationController.php
│   │   │           │   ├── NewPasswordController.php
│   │   │           │   ├── PasswordResetLinkController.php
│   │   │           │   ├── RegisteredUserController.php
│   │   │           │   └── VerifyEmailController.php
│   │   │           ├── Category/               # Category management
│   │   │           │   └── CategoryController.php
│   │   │           └── Task/                   # Task management
│   │   │               └── TaskController.php
│   │   ├── Middleware/                         # Custom middleware
│   │   └── Requests/                           # Form request validation
│   ├── Models/                                 # Eloquent models
│   │   ├── Category.php
│   │   ├── Task.php
│   │   └── User.php
│   └── Providers/                              # Service providers
├── bootstrap/                                  # Application bootstrap files
├── config/                                     # Configuration files
│   ├── auth.php                               # Authentication configuration
│   ├── database.php                           # Database configuration
│   ├── sanctum.php                            # Sanctum configuration
│   └── ...
├── database/
│   ├── migrations/                            # Database migrations
│   │   ├── create_users_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_tasks_table.php
│   │   └── ...
│   ├── seeders/                               # Database seeders
│   └── factories/                             # Model factories
├── public/                                    # Publicly accessible files
│   └── index.php                              # Application entry point
├── resources/
│   └── views/                                 # Blade templates (if needed)
├── routes/
│   ├── api.php                                # API routes
│   └── web.php                                # Web routes
├── storage/                                   # Application storage
│   ├── app/                                   # Application files
│   ├── framework/                             # Framework files
│   └── logs/                                  # Application logs
├── tests/                                     # Application tests
│   ├── Feature/                               # Feature tests
│   └── Unit/                                  # Unit tests
├── vendor/                                    # Composer dependencies
├── .env.example                               # Environment variables template
├── artisan                                    # Laravel Artisan CLI
├── composer.json                              # PHP dependencies & scripts
├── composer.lock                              # Locked PHP dependencies
└── README.md                                  # Project documentation
```

### Key Directories Explained

-   **`app/Http/Controllers/Api/V1/`** - Versioned API controllers organized by feature (Auth, Category, Task)
-   **`app/Models/`** - Eloquent models representing database entities (User, Task, Category)
-   **`database/migrations/`** - Database schema migrations for creating and modifying tables
-   **`routes/api.php`** - API route definitions with versioning and middleware
-   **`config/`** - Laravel configuration files including authentication and database settings
-   **`tests/`** - PHPUnit test files for ensuring code quality and functionality

### API Architecture

-   **RESTful Design** - Following REST conventions for consistent API endpoints
-   **Version Control** - API versioning (v1) for backward compatibility
-   **Laravel Sanctum** - Token-based authentication for SPA applications
-   **Resource Controllers** - Standard CRUD operations for tasks and categories
-   **Middleware Protection** - Authentication required for protected endpoints

## API Endpoints

### Authentication

| Method | Endpoint                                  | Description             |
| ------ | ----------------------------------------- | ----------------------- |
| POST   | `/api/v1/register`                        | Register a new user     |
| POST   | `/api/v1/login`                           | Login user              |
| POST   | `/api/v1/logout`                          | Logout user             |
| POST   | `/api/v1/forgot-password`                 | Request password reset  |
| POST   | `/api/v1/reset-password`                  | Reset password          |
| POST   | `/api/v1/email/verification-notification` | Send email verification |
| GET    | `/api/v1/verify-email/{id}/{hash}`        | Verify email address    |

Note: This repository only implemented the register,login,logout. If you want to explore more, you can use the rest of the enpoints.

### Tasks

| Method    | Endpoint               | Description            |
| --------- | ---------------------- | ---------------------- |
| GET       | `/api/v1/tasks`        | Get all tasks          |
| POST      | `/api/v1/tasks`        | Create a new task      |
| GET       | `/api/v1/tasks/{task}` | Get a specific task    |
| PUT/PATCH | `/api/v1/tasks/{task}` | Update a specific task |
| DELETE    | `/api/v1/tasks/{task}` | Delete a specific task |

### Categories

| Method    | Endpoint                        | Description                |
| --------- | ------------------------------- | -------------------------- |
| GET       | `/api/v1/categories`            | Get all categories         |
| POST      | `/api/v1/categories`            | Create a new category      |
| GET       | `/api/v1/categories/{category}` | Get a specific category    |
| PUT/PATCH | `/api/v1/categories/{category}` | Update a specific category |
| DELETE    | `/api/v1/categories/{category}` | Delete a specific category |

### Other

| Method | Endpoint    | Description                 |
| ------ | ----------- | --------------------------- |
| GET    | `/api/user` | Get authenticated user info |

## Frontend Application

This API is designed to work with the Vue.js frontend application:

🔗 **[Todo List Vue.js Frontend](https://github.com/Orekidesu/todo-list)**

## Some considerations

This API uses Laravel Sanctum for authentication. Make sure to:

1. Include the CSRF token for SPA authentication
2. Use the `/api/v1/login` endpoint to authenticate users
3. Include the authentication token in subsequent requests

Make sure to configure the frontend application to point to this API endpoint.

If you encounter any issues or have questions, please open an issue on GitHub.
