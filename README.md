# Laravel 9.19 API-Only Ecommerce

A fast, modern backend API boilerplate built with Laravel 9.19 and PHP 8. Features:

- **API-first design**: No Blade/views, pure REST endpoints
- **User management**: Registration, login, admin/user role support
- **Sanctum** authentication for secure, stateless APIs
- **Database seeding and factories** for users, roles, sample data
- **Easy extension** for other resources (products, categories, tags)
- Compatible with MySQL, PostgreSQL, SQLite

---

## Requirements

- PHP 8.0+
- Composer
- Node.js & NPM (for asset/Vite use—optional)
- A SQL database
- (Optional) Docker or Laravel Sail

---

## Installation

```
git clone https://github.com/yourusername/yourlaravelapi.git
cd yourlaravelapi
composer install

# Optional: asset build step if you add any front-end package/Vite
npm install && npm run build

cp .env.example .env
php artisan key:generate

# Set database details in .env
php artisan migrate --seed
```

---

## API Endpoints

- `POST /api/register` – Register new user, returns user and token
- `POST /api/login` – Authenticate, returns token
- `GET /api/users` – List users (admin only)
- `GET /api/users/{id}` – Show user by ID
- Other CRUD endpoints for your resources (`products`, `reviews`, etc.)

All endpoints protected by stateless **Sanctum** token authentication.

---

## Authentication

- Users register and login with `/api/register` and `/api/login`
- Use the Bearer token returned in `Authorization` header for protected routes

```
Authorization: Bearer {YOUR_API_TOKEN}
```

---

## Role-Based Authorization

- User roles stored as a string in `users.role` field (e.g., "admin", "user")
- Access policy enforced via Laravel Policies and Gates
- Only "admin" can access `/api/users` listing

---

## Database Seeding

Seeders and factories automatically create:

- 1 admin user (`admin@example.com`, password: `password`, role: `admin`)
- 10 random users
- Example products, categories, tags via respective seeders/factories

To reset and seed all:

```
php artisan migrate:fresh --seed
```

---

## Development Commands

- Start local server: `php artisan serve`
- Migrate DB: `php artisan migrate`
- Seed DB: `php artisan db:seed`
- Generate models/factories/controllers:

```
php artisan make:model Product -mf
php artisan make:factory UserFactory
php artisan make:seeder UserSeeder
php artisan make:controller Api/UserController --api
php artisan make:policy UserPolicy --model=User
```

---

## .gitignore

Repository excludes:

- `/vendor`
- `/node_modules`
- `/storage`
- `/public/storage`
- `.env` & variants
- IDE/project/editor files
- Asset build artifacts

See included `.gitignore`.

---

## Testing

- Use Postman, Insomnia, or curl for testing API endpoints.
- Example:

```
curl -X POST http://localhost:8000/api/login -d "email=admin@example.com&password=password"
```
- Use returned token for all protected endpoints.

---

## Security

- Do **NOT** commit `.env` or secret files.
- Use HTTPS for all production deployments.
- Keep dependencies up to date.

---

## License

MIT License. See [LICENSE](LICENSE).