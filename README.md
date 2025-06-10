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
git clone https://github.com/your-username/csv-uploader-webapp.git
cd csv-uploader-webapp
