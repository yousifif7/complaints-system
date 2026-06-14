# Complaints Management System

A white-label Laravel complaints and citizen requests portal — ready to deploy for municipalities, organizations, and service providers.

## Features

### Public Portal (Citizens)
- Browse departments and submit complaints/requests
- File attachments (images, PDF)
- Unique ticket numbers for every submission
- **Track complaint status** using ticket number + phone number
- Fully customizable branding (name, colors, logo, messages)

### Admin Panel
- Secure login with hashed passwords
- Dashboard with statistics and recent activity
- Manage complaints with search, filters, and pagination
- Status workflow: Active → Pending → Completed
- Priority levels (low, medium, high, urgent)
- Internal notes and activity log per complaint
- CSV export
- Department and request-type management
- White-label settings panel

## Requirements

- PHP 8.0+
- Composer
- MySQL 5.7+ / MariaDB
- Node.js (optional, for Vite assets)

## Installation

```bash
# 1. Clone and install dependencies
composer install

# 2. Environment setup
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env
DB_DATABASE=complaints
DB_USERNAME=root
DB_PASSWORD=your_password

# 4. Configure branding (optional)
COMPLAINTS_ORG_NAME="بلدية المدينة"
COMPLAINTS_ADMIN_EMAIL=admin@example.com
COMPLAINTS_ADMIN_PASSWORD=your_secure_password

# 5. Run migrations and seed demo data
php artisan migrate
php artisan db:seed

# 6. Create upload directory
mkdir -p public/userFiles
chmod 775 public/userFiles

# 7. Start the server
php artisan serve
```

## Default Access

| Role  | URL            | Credentials (after seed)        |
|-------|----------------|----------------------------------|
| Admin | `/admins`      | `admin@example.com` / `password` |
| Public| `/` or `/complaints` | No login required          |

**Change the default password immediately after first login.**

## URLs

| Path | Description |
|------|-------------|
| `/` | Public homepage — department selection |
| `/complaints/cat/{id}` | Submit a complaint for a department |
| `/track` | Citizen complaint tracking |
| `/admins` | Admin login |
| `/admins/dashboard` | Admin dashboard |
| `/admins/forms` | Complaints list |
| `/admins/settings` | Branding & system settings |

## White-Label Configuration

Configure via **Admin → Settings** or `.env`:

- `COMPLAINTS_ORG_NAME` — Organization name (Arabic)
- `COMPLAINTS_PRIMARY_COLOR` — Theme color (hex)
- `COMPLAINTS_WELCOME_MESSAGE` — Homepage message
- `COMPLAINTS_FOOTER_TEXT` — Footer copyright text

Upload logo and header image from the admin settings panel.

## Selling / Licensing

This project is structured as a **deployable bundle** per client:

1. Clone the repo for each client deployment
2. Run `php artisan db:seed` with client-specific `.env` values
3. Customize branding via admin settings
4. Deploy to client's server (shared hosting or VPS)

### Suggested pricing tiers

| Tier | Includes |
|------|----------|
| Starter | Single deployment, branding, 1 admin |
| Business | + CSV export, tracking portal, priority workflow |
| Enterprise | + Custom domain, SMS/email integration, API (roadmap) |

## Roadmap (Next Version)

- [ ] Email notifications on submission and status change
- [ ] SMS via Vonage (packages already included)
- [ ] Multi-tenant SaaS mode
- [ ] REST API with Sanctum
- [ ] Role-based permissions (agent, supervisor)
- [ ] Laravel 11 upgrade

## Tech Stack

- Laravel 9
- Bootstrap 5
- MySQL
- Blade templates (RTL Arabic UI)

## License

MIT — Free to use and resell as part of client projects.
