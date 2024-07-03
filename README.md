# RealtyMate - Real Estate Agency Backend Application

### *RealtyMate is a backend application for a real estate agency built with Laravel. This application provides an API for the frontend React application and manages various CRUD operations through routes, while also supporting roles and permissions for a web-based dashboard*.

## Features

- **User Authentication**: Register and login functionality using Laravel Sanctum.
- **Role Management**: Manage roles and permissions using Spatie Laravel-Permission.
- **Property Management**: Add, view, update, and delete properties.
- **Team Management**: Manage team members with roles and permissions.
- **Price Management**: Handle pricing information and associated features.
- **Testimonial Management**: Add and manage client testimonials.
- **Partner Management**: Manage business partners.
- **Mailing System**: Send emails for contact forms and PDF guide about property.
- **Dashboard**: Web-based admin panel for managing important entities.
- **API Endpoints**: Provides API endpoints for frontend integration.
- **Factory and Seeders**: Use of factories and seeders for testing and development.

## Technologies Used

- **Framework**: Laravel
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel-Permission
- **PDF Generation**: Barryvdh Laravel-Dompdf
- **Database**: MySQL
- **Mailing**: Laravel Mailables
- **Frontend Communication**: JSON API
- **Build Tools**: Vite
- **CSS**: Tailwind CSS

## Project Structure

- **app/Console/Commands**: Contains Artisan commands for creating admin users, teams, prices, and testimonials. 
    These commands are used in production to set up initial data.
- **app/Http/Controllers**: Contains controllers for handling requests.
  - **UI**: Controllers for handling web-based dashboard routes.
- **app/Http/Requests**: Contains form request classes for validating incoming requests.
- **UI**: Contains registration request for handling web-based requests, which requires the dashboard permission.
- **app/Mail**: Contains Mailable classes for sending emails.
- **app/Models**: Contains Eloquent models for various entities.
  - **app/Traits**: Contains reusable traits for creating users, managing roles, and permissions. 
    The traits use configuration files to create initial data, which are then utilized in seeders and commands.
- **config**: Contains configuration files for various settings including team data. 
    These configuration files are used within traits to populate the database.
- **database/factories**: Contains model factories for testing.
- **database/seeders**: Contains database seeders for seeding the database with initial data, using traits that read from configuration files.
- **resources/views**: Contains Blade templates for emails and dashboard views.
- **routes**: Contains route definitions for web and API routes.
- **tests**: Contains feature tests for various parts of the application.

## Installation and Setup

1.	**Clone the repository:**
```bash
git clone https://github.com/your-username/realty-mate-backend.git
cd realty-mate-backend
```

2. **Install dependencies:**
```bash
composer install
npm install
```

3. **Set up environment variables:**
   Update a `.env` file you find at the root of the project to add the necessary environment variables  for database and mail configurations:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=realty_mate
DB_USERNAME=your-username
DB_PASSWORD=your-passoword

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

4. **Testing Setup:**
   Create a `.env.testing` file at the root of the project to add the necessary environment variables for testing configuration.
   Copy all the variables from the .env file and modify the database settings:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=realty_mate_testing
DB_USERNAME=your-username
DB_PASSWORD=your-passoword
```

5. **Run database migrations and seeders:**
```bash
php artisan migrate --seed
```

6. **Start the application:**
```bash
php artisan serve
npm run dev
```

7. **Testing Tools:**
   The application uses PHPUnit for testing. You can run the tests with the command:
```bash
php artisan test
```

8. **Production Setup:**
   Create a `.env.production` file by copying the contents of the .env file and update the necessary environment variables:
```bash
APP_DEBUG=false
APP_URL=your-url-production

DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_PORT=3306
DB_DATABASE=your-production-db-name
DB_USERNAME=your-production-db-username
DB_PASSWORD=your-production-db-password
```

9. **Run the build command for production:**
```bash
npm run build
```

## API Endpoints

- **User Authentication**:
  - **POST /user/register**: Register a new user.
  - **POST /user/login**: Login a user.
  - **POST /logout**: Logout a user.
  - **GET /user**: Get the authenticated user details.
- **Properties**:
  - **GET /api/properties**: List all properties.
  - **POST /api/properties**: Create a new property.
  - **GET /api/properties/{id}**: Get a property by ID.
  - **PUT /api/properties/{id}**: Update a property by ID.
  - **DELETE /api/properties/{id}**: Delete a property by ID.
- **Teams**:
  - **GET /api/teams**: List all teams (public).
  - **POST /api/teams**: Create a new team.
  - **GET /api/teams/{id}**: Get a team by ID.
  - **PUT /api/teams/{id}**: Update a team by ID.
  - **DELETE /api/teams/{id}**: Delete a team by ID.
- **Prices**:
  - **GET /api/prices**: List all prices (public).
  - **POST /api/prices**: Create a new price.
  - **GET /api/prices/{id}**: Get a price by ID.
  - **PUT /api/prices/{id}**: Update a price by ID.
  - **DELETE /api/prices/{id}**: Delete a price by ID.
- **Testimonials**:
  - **GET /api/testimonials**: List all testimonials (public).
  - **POST /api/testimonials**: Create a new testimonial.
  - **GET /api/testimonials/{id}**: Get a testimonial by ID.
  - **PUT /api/testimonials/{id}**: Update a testimonial by ID.
  - **DELETE /api/testimonials/{id}**: Delete a testimonial by ID.
- **Partners**:
  - **GET /api/partners**: List all partners.
  - **POST /api/partners**: Create a new partner.
  - **GET /api/partners/{id}**: Get a partner by ID.
  - **PUT /api/partners/{id}**: Update a partner by ID.
  - **DELETE /api/partners/{id}**: Delete a partner by ID.
- **Contact**:
  - **POST /contact**: Send a contact message.
  - **POST /send-guide**: Send a PDF guide.

## Web Routes

- **Dashboard**: Manage entities through a web-based interface.
- **GET /dashboard**: View the dashboard.
- **GET /dashboard/properties**: Manage properties.
- **GET /dashboard/teams**: Manage teams.
- **GET /dashboard/roles-and-permissions**: Manage roles and permissions.
- **GET /dashboard/prices**: Manage prices.
- **GET /dashboard/testimonials**: Manage testimonials.
- **GET /dashboard/partners**: Manage partners.
- **POST /roles**: Create a new role.
- **PUT /roles**: Update a role.
- **DELETE /roles/delete**: Delete a role.
- **POST /roles/assign**: Assign a role to a user.
- **POST /roles/revoke**: Revoke a role from a user.
- **POST /permissions**: Create a new permission.
- **DELETE /permissions/delete**: Delete a permission.
- **POST /permissions/assign**: Assign a permission to a user.
- **POST /permissions/revoke**: Revoke a permission from a user.
- **POST /logout**: Logout from the dashboard.
- **POST /login**: Login to the dashboard.
- **POST /register**: Register a new user.
- **GET /**: Redirect to the login page.
- **GET /login**: Show the login page.
- **GET /register**: Show the registration page.
- **GET /{any}**: Catch-all route for frontend.

### Contributing

### *Feel free to submit issues, fork the repository and send pull requests*.
