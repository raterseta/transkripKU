# TranskripKU

A web-based academic transcript management system for the Information Systems study program at the Faculty of Computer Science.

## Installation Guide

1. Clone the repository
```bash
git clone [repository-url]
cd transkripKU
```

2. Install PHP dependencies
```bash
composer install
```

3. Install Node.js dependencies
```bash
npm install
```

4. Set up environment variables
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env` file

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

6. Generate Role Policy
```bash
php artisan shield:generate -all
```

7. Start the development server
```bash
php artisan serve
npm run dev
```

## Database Structure

![TranskripKu Database Structure](https://xnv0w60lib.ufs.sh/f/Z1GE9qOlYjvbjWyH89T1nfgDOIWYitA3LQ64u5mekXCNESbJ)

## Features and Usage Flow

| User Role          | Feature Category            | Features and Capabilities                                                                                        |
| ------------------ | --------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| **Students**       | Document Request Submission | • Submit academic document requests<br>• Submit thesis-related requests<br>• Track request status                |
|                    | Consultation Management     | • Schedule consultations<br>• View consultation history<br>• Receive email notifications                         |
| **Staff**          | Request Processing          | • Review incoming requests<br>• Process document requests<br>• Update request status<br>• Schedule consultations |
|                    | Document Management         | • Generate documents<br>• Manage digital signatures<br>• Archive processed documents                             |
| **Administrators** | System Management           | • User management<br>• Role and permission control<br>• System configuration<br>• Activity logging               |
|                    | Request Processing          | • Review incoming requests<br>• Process document requests<br>• Update request status |
|                    | Document Management         | • Generate documents<br>• Manage digital signatures<br>• Archive processed documents                             |

## Development Changelog

| Version | Status  | Features                                                                                                                                                |
| ------- | ------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **1.0** | Past | • Initial release<br>• Basic request management system<br>• Email notification system<br>• Document processing pipeline<br>• Admin panel implementation |
| **1.1** | Current | • Calender invitation integration |