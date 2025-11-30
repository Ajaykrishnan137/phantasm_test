
# Phantasm Solutions – PHP Developer Assessment (Laravel)

The following two APIs are required for development (no UI implementation needed; please demonstrate functionality using Postman):

1. Implement JWT authentication for user access.
2. Create an API endpoint to add a product to the cart.

Develop at: 
```
https://github.com/Phantasm-Solutions-Ltd-Pvt/php-f2f-for-candidate
```

Please ensure these implementations are set up prior to joining, in order to streamline the face-to-face interview process.

Best regards,  
Phantasm

---

## ⚙️ Setup Instructions

**Clone the repo:**

```bash
git clone https://github.com/Ajaykrishnan137/phantasm_test.git
cd phantasm_test
```

**Install dependencies:**

```bash
composer install
npm install
```

**Copy .env.example and configure:**

```bash
cp .env.example .env
php artisan key:generate
```

**Run migrations and seed sample data:**

```bash
php artisan migrate --seed
```

**Start the server:**

```bash
php artisan serve
```

**Test APIs using Postman or Thunder Client:**

- **Register User:**  
`POST http://127.0.0.1:8000/api/register`

- **Login User:**  
`POST http://127.0.0.1:8000/api/login`

- **Add Product to Cart:**  
`POST http://127.0.0.1:8000/api/cart/add`
