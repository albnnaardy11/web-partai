# 🇮🇩 Partai Ibu: Official Management System & Public Portal

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v4-FBBF24?style=for-the-badge&logo=filament)](https://filamentphp.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-v5.3-7952B3?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com)
[![Status](https://img.shields.io/badge/Status-Production--Ready-success?style=for-the-badge)]()

Welcome to the **Partai Ibu** digital ecosystem. This platform is a state-of-the-art solution for political management, featuring a high-performance CMS and a stunning public portal.

---

## 🚀 Vision
To empower every Indonesian through transparent, data-driven political engagement and direct aspirations management.

## 🛠 Features

### 🏛 Admin Management (Filament CMS)
- **Dynamic Content Engine**: Seamlessly manage Hero sections, About pages, Values, and Programs.
- **News Center (Warta Ibu)**: Create, edit, and publish news articles with image support and badge categorization.
- **Aspirasi Rakyat Portal**: Real-time management of public feedback with status tracking.
- **Membership Management**: Comprehensive CRM for member registration, document validation (KTP), and status monitoring.
- **Dashboard Analytics**: Real-time widgets for member growth, regional spread, and latest activities.

### 🌐 Public Portal (Frontend)
- **Premium News Portal**: Full-featured news listing with **real-time search**, categories, and breadcrumb navigation.
- **Deep Content Detail**: Professional article views with related news suggestions.
- **High-Aesthetic UI**: Modern, responsive design with "Red Palette" branding and smooth transitions.
- **Secure Registration**: Multi-step member registration with file upload support.
- **Enterprise SEO**: Pre-configured OG tags, Twitter cards, and semantic HTML structure.

---

## 🏗 Technology Stack

- **Backend**: [Laravel 11](https://laravel.com)
- **Admin Panel**: [Filament v4](https://filamentphp.com)
- **Database**: MySQL/MariaDB
- **Frontend**: Vanilla JS (ES6+), SCSS, Bootstrap 5.3
- **Tooling**: Composer, NPM, SASS Compiler

---

## 📦 Directory Structure

```text
├── backend/               # Laravel 11 Project
│   ├── app/               # Core Logic & Filament Resources
│   ├── database/          # Migrations & Seeders
│   └── routes/            # API Endpoints
├── frontend/              # Frontend Project
│   ├── src/               # UI Source Files
│   │   ├── news.html      # News Listing Portal
│   │   ├── news-detail.html# Article Detail View
│   │   └── components/    # Modular HTML Fragments
│   └── dist/              # Compiled CSS/Assets
└── deploy.sh              # Automated Deployment Script
```

---

## 🔧 Installation & Setup

### Prerequisites
- PHP 8.2+ | Node.js 18+ | MySQL 8+

### Development Setup

1. **Clone & Install**:
   ```bash
   git clone https://github.com/your-org/web-partai.git
   cd web-partai
   ```

2. **Backend**:
   ```bash
   cd backend
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan db:seed --class=ArticleSeeder # Important for News Data
   php artisan storage:link
   ```

3. **Frontend**:
   ```bash
   cd ../frontend
   npm install
   npm run build
   ```

4. **Run**:
   - Backend: `php artisan serve`
   - Frontend: `npm run dev`

---

## 🚢 Deployment

Run the automated script for production updates:
```bash
./deploy.sh
```

---

## 📄 License
This project is proprietary. &copy; 2026 **Partai Ibu IT Development Team**.

Designed with ❤️ for **Indonesia**.
