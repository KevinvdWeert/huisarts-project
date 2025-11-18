# Architecture

## System Overview

The Medical Practice Management System follows a traditional **MVC-inspired** architecture with PHP, MySQL, and Tailwind CSS for styling.

## Architecture Diagram

```
┌─────────────────────────────────────────────────────┐
│                   Browser (Client)                   │
│  HTML • CSS (Tailwind) • JavaScript • SVG Icons     │
└───────────────────┬─────────────────────────────────┘
                    │ HTTP/HTTPS
                    ▼
┌─────────────────────────────────────────────────────┐
│                 Web Server Layer                     │
│           Apache / Nginx / Laragon                   │
└───────────────────┬─────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────┐
│              Application Layer (PHP)                 │
│ ┌─────────────────────────────────────────────────┐ │
│ │  Presentation (Views)                           │ │
│ │  • index.php, dashboard.php                     │ │
│ │  • add_patient.php, edit_patient.php            │ │
│ │  • includes/header.php, footer.php              │ │
│ └─────────────────┬───────────────────────────────┘ │
│                   │                                  │
│ ┌─────────────────▼───────────────────────────────┐ │
│ │  Business Logic                                 │ │
│ │  • auth.php - Authentication                    │ │
│ │  • security_helpers.php - Security functions    │ │
│ │  • config/config.php - Configuration            │ │
│ └─────────────────┬───────────────────────────────┘ │
│                   │                                  │
│ ┌─────────────────▼───────────────────────────────┐ │
│ │  Data Access Layer                              │ │
│ │  • database/connection.php                      │ │
│ │  • PDO prepared statements                      │ │
│ └─────────────────┬───────────────────────────────┘ │
└───────────────────┼─────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────┐
│              Database Layer (MySQL)                  │
│  • patients table                                   │
│  • notes table                                      │
│  • users table                                      │
└─────────────────────────────────────────────────────┘
```

## Directory Structure

```
huisarts-project/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styles
│   ├── img/
│   │   └── logo.svg           # Site logo
│   └── js/
│       └── script.js          # Client-side JavaScript
├── config/
│   └── config.php             # Database & app configuration
├── database/
│   ├── connection.php         # PDO database connection
│   ├── huisarts.sql           # Database schema
│   └── huisarts.csv           # Sample data (if any)
├── includes/
│   ├── header.php             # Reusable header
│   ├── footer.php             # Reusable footer
│   ├── init.php               # Initialization script
│   └── security_helpers.php   # Security functions
├── .github/
│   └── wiki/                  # GitHub wiki pages
├── index.php                  # Homepage
├── login.php                  # Login page
├── logout.php                 # Logout handler
├── dashboard.php              # Main dashboard
├── add_patient.php            # Add new patient
├── edit_patient.php           # Edit patient
├── delete_patient.php         # Delete patient
├── patient_notes.php          # Patient notes
├── about.php                  # About page
├── services.php               # Services page
├── contact.php                # Contact page
├── contact_handler.php        # Contact form handler
├── privacy.php                # Privacy policy
├── auth.php                   # Authentication logic
└── README.md                  # Project documentation
```

## Technology Stack

### Frontend
- **HTML5** - Semantic markup
- **Tailwind CSS 2.2.19** - Utility-first CSS framework
- **JavaScript (Vanilla)** - Client-side interactions
- **SVG** - Scalable vector icons
- **CSS3** - Custom styling

### Backend
- **PHP 7.4+** - Server-side scripting
- **PDO** - Database abstraction
- **Session Management** - User authentication
- **Password Hashing** - bcrypt algorithm

### Database
- **MySQL 5.7+** / **MariaDB 10.3+**
- **InnoDB** storage engine
- **UTF-8mb4** character encoding

### Development Tools
- **Laragon** - Local development environment
- **Git** - Version control
- **GitHub** - Repository hosting
- **VS Code** - Code editor (recommended)

## Design Patterns

### 1. Include Pattern
Reusable components via PHP includes:
```php
require_once 'includes/header.php';
// Page content
require_once 'includes/footer.php';
```

### 2. Configuration Pattern
Centralized configuration:
```php
// config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
```

### 3. Database Access Pattern
PDO with prepared statements:
```php
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch();
```

### 4. Session Management Pattern
Authentication state:
```php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function checkSession() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
```

### 5. Template Pattern
Dynamic page titles and content:
```php
$page_config = [
    'dashboard.php' => [
        'title' => 'Dashboard',
        'description' => '...'
    ]
];
```

## Security Architecture

### Authentication Flow

```
┌──────────┐
│  User    │
└────┬─────┘
     │ 1. Enter credentials
     ▼
┌──────────────┐
│  login.php   │
└────┬─────────┘
     │ 2. Verify password
     ▼
┌──────────────┐
│   auth.php   │
└────┬─────────┘
     │ 3. Create session
     ▼
┌──────────────┐
│ dashboard.php│
└────┬─────────┘
     │ 4. Check session on each request
     ▼
┌──────────────┐
│checkSession()│
└──────────────┘
```

### Security Layers

1. **Input Validation**
   - Required field checking
   - Data type validation
   - Email format validation
   - Date validation

2. **SQL Injection Prevention**
   - PDO prepared statements
   - Parameter binding
   - No direct query concatenation

3. **XSS Protection**
   - `htmlspecialchars()` on output
   - Content Security Policy (recommended)
   - Sanitized user input

4. **Authentication**
   - Password hashing (bcrypt)
   - Session-based auth
   - Login required for protected pages
   - Session timeout

5. **CSRF Protection** (To Be Implemented)
   - Token generation
   - Token validation
   - Form protection

## Data Flow

### Patient CRUD Operations

#### Create Patient
```
User → add_patient.php → Validation → PDO INSERT → patients table
                                    ↓
                              Success message → dashboard.php
```

#### Read Patients
```
dashboard.php → PDO SELECT → patients table
              ↓
         Format & display (cards/table)
              ↓
         Pagination, search, sort
```

#### Update Patient
```
edit_patient.php → Load patient → Form display
                 ↓
            User edits → Validation → PDO UPDATE
                                    ↓
                              Success → dashboard.php
```

#### Delete Patient
```
delete_patient.php → Confirmation page
                   ↓
              User confirms → Transaction BEGIN
                           → DELETE notes
                           → DELETE patient
                           → Transaction COMMIT
                           ↓
                     Success → dashboard.php
```

## Performance Optimization

### Database Level
- **Indexes** on frequently queried columns
- **Pagination** to limit result sets
- **Prepared statements** for query caching
- **Transactions** for data consistency

### Application Level
- **Session caching** for user data
- **Lazy loading** of resources
- **Minimized queries** per page
- **Efficient PHP code**

### Frontend Level
- **CDN** for Tailwind CSS
- **Deferred JavaScript** loading
- **Optimized SVG** icons
- **Browser caching** headers

## Scalability Considerations

### Current Architecture
- Single server deployment
- Suitable for small to medium practices
- 100-1000 concurrent users

### Future Enhancements
- **Load balancing** for multiple servers
- **Database replication** (master-slave)
- **Caching layer** (Redis/Memcached)
- **API layer** for mobile apps
- **Microservices** for specific features

## Deployment Architecture

### Development Environment
```
Local Machine (Laragon)
  ├── Apache/Nginx
  ├── PHP 7.4+
  ├── MySQL 5.7+
  └── Application files
```

### Production Environment
```
Web Server (Apache/Nginx)
  ├── SSL/TLS certificate
  ├── PHP-FPM
  ├── Application files
  └── .htaccess / server config

Database Server (MySQL)
  ├── Optimized configuration
  ├── Regular backups
  └── Restricted access

File Storage
  └── Uploads directory (if needed)
```

## Error Handling

### Logging Strategy
```php
error_log("Error message: " . $e->getMessage());
```

### User-Facing Errors
- Friendly error messages
- No sensitive information exposed
- Redirect to appropriate pages

### Development vs Production
- **Development**: Display detailed errors
- **Production**: Log errors, show generic messages

## Testing Strategy

### Manual Testing
- Browser testing (Chrome, Firefox, Safari, Edge)
- Mobile responsive testing
- Feature testing after changes

### Automated Testing (Recommended)
- Unit tests for PHP functions
- Integration tests for database operations
- End-to-end tests for user flows

## Related Documentation

- [Installation Guide](Installation-Guide) - Setup instructions
- [Database Schema](Database-Schema) - Database structure
- [Code Standards](Code-Standards) - Coding conventions
- [Deployment](Deployment) - Production deployment guide
