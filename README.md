# Inventory Management REST API

Inventory Management REST API built using CodeIgniter 4 and MySQL.

## Features

- Category CRUD
- Product CRUD
- Stock In
- Stock Out
- Stock Validation
- Stock Transaction History
- Product Search
- Product Pagination
- Service Layer Architecture
- RESTful API

---

## Tech Stack

- PHP 8
- CodeIgniter 4
- MySQL
- REST API
- Postman

---

## Project Structure

```bash
app/
├── Controllers/
├── Models/
├── Services/
├── Database/
```

---

## Installation

### Clone Repository

```bash
git clone https://github.com/azaryageraldo/inventory-api.git
```

### Move to Project

```bash
cd inventory-api
```

### Install Dependencies

```bash
composer install
```

### Setup Environment

Copy env file:

```bash
cp env .env
```

Update database configuration in `.env`

```env
database.default.hostname = localhost
database.default.database = inventory_api
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

## Run Migration

```bash
php spark migrate
```

---

## Run Server

```bash
php spark serve
```

Server will run at:

```bash
http://localhost:8080
```

---

# API Endpoints

## Category Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/categories | Get all categories |
| GET | /api/categories/{id} | Get category detail |
| POST | /api/categories | Create category |
| PUT | /api/categories/{id} | Update category |
| DELETE | /api/categories/{id} | Delete category |

---

## Product Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/products | Get all products |
| GET | /api/products/{id} | Get product detail |
| POST | /api/products | Create product |
| PUT | /api/products/{id} | Update product |
| DELETE | /api/products/{id} | Delete product |

---

## Product Search & Pagination

### Search

```http
GET /api/products?search=laptop
```

### Pagination

```http
GET /api/products?per_page=5
```

### Search + Pagination

```http
GET /api/products?search=asus&per_page=5
```

---

## Stock Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/stock/in | Add stock |
| POST | /api/stock/out | Reduce stock |
| GET | /api/stock/history | Stock transaction history |

---

## Example Request

### Create Product

```http
POST /api/products
```

Request Body:

```json
{
  "category_id": 1,
  "name": "Laptop Asus",
  "price": 15000000,
  "stock": 10
}
```

---

## Business Logic

### Stock Out Validation

Stock cannot be reduced if requested quantity exceeds available stock.

Example response:

```json
{
  "status": false,
  "message": "Insufficient stock"
}
```

---

## Architecture

This project uses Service Layer Architecture to separate business logic from controllers.

Flow:

```text
Controller → Service → Model → Database
```

---

## Author

Azarya Geraldo