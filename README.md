# User Notification API

A RESTful API built with **Laravel 12** for sending notifications to users.  
It supports:

- User authentication (login/logout)
- Sending notifications
- Query result caching
- Per-user rate limiting
- Simple test coverage with PHPUnit

---

## Setup Instructions

### Requirements

- PHP 8.3+
- Composer
- MySQL (local or via Docker)

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/abdelrhman-saeed/notification-rate-limitter.git
   cd notification-rate-limitter
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Copy the `.env` file**


   ```bash
   cp .env.example .env
   ```

4. **Configure environment variables**

   Update your `.env` file:

   ```
   DB_CONNECTION=mysql
   DB_HOST=mysql-container
   DB_PORT=3306
   DB_DATABASE=notification_rate_limitter
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

5. **Run migrations and seeders**

   ```bash
   php artisan migrate:fresh --seed
   ```

   Default test users:

   | Email              | Password   |
   |-------------------|------------|
   | test@example.com  | password   |
   | test2@example.com | password   |

---

## API Endpoints

### Authentication

#### Login

```http
POST /api/login
```

**Request Body:**

```json
{
  "email": "test@example.com",
  "password": "password"
}
```

#### Logout

```http
POST /api/logout
Authorization: Bearer {token}
```

---

### Notifications

#### Send Notification

```http
POST /api/notifications
Authorization: Bearer {token}
```

**Request Body:**

```json
{
  "user_id": 1,
  "message": "Your message here"
}
```

---

## Running Tests

```bash
php artisan test
```

All tests use an in-memory SQLite or configured testing database.

---

## Postman Collection

Import the Postman collection to try the endpoints:

[🔗 Download Collection](./Notification_Rate_Limitter.postman_collection.json)

---

## Author

**Abdelrhman Saeed**  
[abdelrhmansaeed001@gmail.com](mailto:abdelrhmansaeed001@gmail.com)

---

## You're All Set!