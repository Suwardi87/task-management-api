<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# 📝 Task Management API

Aplikasi manajemen tugas berbasis **Laravel 10**, **Inertia.js**, dan **Vue 3**. Mendukung sistem login, manajemen tugas, role-based access control, serta fitur CRUD lengkap.

---

## ⚙️ Setup Project

### 1. Clone Repository
```bash
git clone https://github.com/username/task-management-api.git
cd task-management-api
```

### 2. Install Dependency Backend
```bash
composer install
```

### 3. Install Dependency Frontend
```bash
npm install
```

### 4. Salin file environment
```bash
cp .env.example .env
```

### 5. Generate Key
```bash
php artisan key:generate
```

### 6. Konfigurasi Database
Edit file `.env`:
```env
DB_DATABASE=task_management_api
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 8. Jalankan Server
```bash
php artisan serve
npm run dev
```

---

## 🧠 Konfigurasi Inertia.js

Aplikasi menggunakan Inertia.js sebagai jembatan antara Laravel dan Vue 3.

**resources/js/app.js**
```js
import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from '@/Layouts/AppLayout.vue';

createInertiaApp({
  resolve: name =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mixin({ methods: { route } })
      .mount(el);
  },
  title: title => title ? `${title} - TaskApp` : 'TaskApp',
});
```

---

## 🗂️ ERD (Entity Relationship Diagram)

```
users
- id (UUID)
- name
- email
- password
- role (admin, manager, staff)
- status (active/inactive)

tasks
- id (UUID)
- title
- description
- status
- assigned_to (relasi ke users)
- due_date
- created_by (relasi ke users)

activity_logs
- id
- user_id
- action
- description
- logged_at
```

---

## ✨ Fitur

- ✅ Autentikasi (Login, Register)
- ✅ CRUD Task
- ✅ Role-based Task Assignment
- ✅ Activity Log untuk Task Overdue
- ✅ Responsive Frontend dengan Vue 3
- ✅ Middleware: auth, checkUserStatus, logRequest
- ✅ Laravel Sanctum untuk API Auth

---

## 🖼️ Screenshot

| Login | Task Dashboard | Edit Task |
|-------|----------------|-----------|
| ![Login](screenshots/login.png) | ![Task List](screenshots/task-list.png) | ![Task Form](screenshots/task-form.png) |

### Hasil Test
![Test Result](screenshots/test-result.png)

---

## 🧪 Testing

Jalankan:
```bash
php artisan test --coverage
```

---

## ⚙️ .env.example

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management_api
DB_USERNAME=root
DB_PASSWORD=

LOG_CHANNEL=stack
LOG_LEVEL=debug

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

---

## 🧰 Bonus (Opsional)

- Laravel Scheduler untuk pengecekan task overdue
- Ekspor task ke CSV
- Docker support (opsional)
- Swagger (opsional)

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah MIT License.

---

<!-- Bagian default Laravel (boleh dihapus jika tidak perlu) -->
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
