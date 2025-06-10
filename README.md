# Sale Sight Web App


A Laravel + Vue.js application to upload CSV files and interpret them in Dashboard. 

---

## Features

- Select upload target type (product, product type, order, order details)
- Upload CSV files and preview first rows before sending
- Parse CSV data with PapaParse
- Process and chunk data to avoid large payloads
- Send chunked POST requests to backend API endpoints with Bearer token authorization
- Show progress and upload status messages
- Limit chunk uploads to avoid overload

---

## Tech Stack

- Vue.js 3 with `<script setup>`
- PapaParse for CSV parsing
- Axios for HTTP requests
- Backend API (RESTful, with Laravel Sanctum authentication)

---

## Prerequisites

- Node.js (v18 or latest recommended)
- npm or yarn package manager
- Backend API running and accessible

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/jcembang26/sale-sight.git
cd sale-sight
```

### 2. Install dependencies

```bash
composer update

npm install
# or
yarn install
```

### 3. Create/Update .env variables

```env
APP_URL=YOUR_SITE_URL
DB_CONNECTION=CONNECTION_YOU_WANT_TO_USE 

# e.g. mysql

# DB Credentials
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sale_sight
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate key

```bash
php artisan key:generate
```

### 5. DB and Migrations

- Create database name `sale_sight`
- Run migration

```bash
php artisan migrate
```

### 6. Run the development server

```bash
npm run dev
# or
yarn dev
```