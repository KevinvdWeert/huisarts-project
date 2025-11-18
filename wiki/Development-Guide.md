# Development Guide

Guide for developers who want to contribute to or customize the Huisarts Project.

## 🚀 Getting Started

### Development Environment Setup

#### Prerequisites

- Git
- PHP 7.4+ (recommend 8.1+)
- MySQL 8.0+ or MariaDB
- Composer (optional)
- Code editor (VS Code, PHPStorm, Sublime)
- Web browser with DevTools

#### Clone Repository

```bash
git clone https://github.com/KevinvdWeert/huisarts-project.git
cd huisarts-project
```

#### Local Development Options

**Option 1: XAMPP/WAMP/MAMP** (Easiest for beginners)
- Install XAMPP/WAMP/MAMP
- Copy project to htdocs/www directory
- Start Apache and MySQL
- Import database

**Option 2: Docker** (Recommended for consistency)
```bash
# Create docker-compose.yml (see Installation Guide)
docker-compose up -d
```

**Option 3: Native LAMP/LEMP Stack**
```bash
# Install dependencies
sudo apt install apache2 php8.1 mysql-server php8.1-mysql

# Configure virtual host
# See Installation Guide for details
```

#### Configure for Development

```php
// config/config.php
define('APP_ENV', 'development');
define('APP_DEBUG', true);

// Enable error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Development database
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts_dev');
define('DB_USER', 'dev_user');
define('DB_PASS', 'dev_password');
```

## 📂 Project Structure

```
huisarts-project/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom styles
│   ├── img/                    # Images
│   └── js/
│       └── script.js           # JavaScript functionality
├── config/
│   └── config.php              # Configuration settings
├── database/
│   ├── connection.php          # Database connection
│   └── huisarts.sql            # Database schema & data
├── includes/
│   ├── header.php              # HTML head & navigation
│   ├── footer.php              # Footer & closing tags
│   ├── init.php                # Initialization script
│   └── security_helpers.php    # Security functions
├── wiki/                       # Documentation
├── index.php                   # Homepage
├── about.php                   # About page
├── services.php                # Services page
├── contact.php                 # Contact page
├── privacy.php                 # Privacy policy
├── login.php                   # Login page
├── logout.php                  # Logout handler
├── auth.php                    # Authentication functions
├── dashboard.php               # Main dashboard
├── add_patient.php             # Add patient form
├── edit_patient.php            # Edit patient form
├── delete_patient.php          # Delete patient handler
├── patient_notes.php           # Patient notes management
└── README.md                   # Project documentation
```

### Key Files Explained

**Configuration & Setup**
- `config/config.php` - Main configuration (database, app settings)
- `database/connection.php` - PDO database connection
- `includes/init.php` - Bootstrap and initialization

**Authentication**
- `auth.php` - Authentication functions (login, session management)
- `login.php` - Login form and handler
- `logout.php` - Logout and session cleanup

**Patient Management**
- `dashboard.php` - Patient list with search/sort
- `add_patient.php` - Add new patient
- `edit_patient.php` - Edit existing patient
- `delete_patient.php` - Delete patient with confirmation
- `patient_notes.php` - View and manage patient notes

**Layout & UI**
- `includes/header.php` - HTML head, CSS, navigation
- `includes/footer.php` - Footer, scripts, closing tags
- `assets/css/style.css` - Custom Tailwind extensions
- `assets/js/script.js` - JavaScript interactivity

## 🏗️ Architecture

### Design Pattern

The project uses a simple MVC-like structure:
- **Models**: Database queries in PHP files
- **Views**: PHP templates with embedded HTML
- **Controllers**: PHP logic at top of files

### Database Layer

Uses PDO with prepared statements:

```php
// Get database connection
$pdo = getDbConnection();

// Prepared statement
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch();
```

### Authentication Flow

```
1. User submits login form (login.php)
2. Credentials validated against database
3. Password verified with password_verify()
4. Session created with user data
5. User redirected to dashboard
6. Each page checks session (checkSession())
7. Logout destroys session (logout.php)
```

### Request Flow

```
Browser Request → Apache/Nginx → PHP
                                  ↓
                           Load config.php
                                  ↓
                           Check authentication
                                  ↓
                           Connect to database
                                  ↓
                           Execute business logic
                                  ↓
                           Render view (HTML)
                                  ↓
                           Send response
```

## 💻 Coding Standards

### PHP Style Guide

Follow PSR-12 coding standards where applicable:

```php
<?php
// Use strict types
declare(strict_types=1);

// Proper indentation (4 spaces)
function exampleFunction($param1, $param2) {
    if ($param1 === $param2) {
        return true;
    }
    return false;
}

// Meaningful variable names
$patientId = 123;
$patientData = [];

// Comments for complex logic
// Calculate patient age from date of birth
$age = calculateAge($dateOfBirth);
```

### Database Queries

Always use prepared statements:

```php
// Good: Prepared statement
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$id]);

// Good: Named parameters
$stmt = $pdo->prepare("SELECT * FROM patients WHERE email = :email");
$stmt->execute(['email' => $email]);

// BAD: Never concatenate user input (SQL injection risk)
// $query = "SELECT * FROM patients WHERE patient_id = " . $id;
```

### Security Best Practices

```php
// Always sanitize input
$input = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

// Validate data types
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

// Use password_hash for passwords
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verify passwords
if (password_verify($input, $hash)) {
    // Password correct
}

// Always check authentication
checkSession(); // At top of protected pages
```

### HTML/CSS Guidelines

```html
<!-- Semantic HTML -->
<section class="container">
    <h2>Patient Information</h2>
    <article class="patient-card">
        <!-- Content -->
    </article>
</section>

<!-- Accessible forms -->
<label for="first-name">First Name:</label>
<input type="text" id="first-name" name="first_name" required>

<!-- Tailwind CSS classes -->
<button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Save Patient
</button>
```

### JavaScript Guidelines

```javascript
// Use modern ES6+ syntax
const patientData = {
    firstName: 'John',
    lastName: 'Doe'
};

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Initialize code
});

// Async/await for API calls
async function fetchPatients() {
    try {
        const response = await fetch('/api/patients');
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching patients:', error);
    }
}
```

## 🔨 Common Development Tasks

### Adding a New Page

1. **Create PHP file**
   ```php
   <?php
   require_once 'config/config.php';
   require_once 'auth.php';
   checkSession(); // If authentication required
   require_once 'includes/header.php';
   ?>
   
   <div class="container mx-auto px-6 py-12">
       <h1>New Page Title</h1>
       <!-- Your content -->
   </div>
   
   <?php require_once 'includes/footer.php'; ?>
   ```

2. **Add to navigation** (includes/header.php)
   ```php
   <a href="newpage.php" class="nav-link">New Page</a>
   ```

### Adding a Database Table

1. **Create migration SQL**
   ```sql
   -- database/migrations/add_appointments_table.sql
   CREATE TABLE appointments (
       appointment_id INT PRIMARY KEY AUTO_INCREMENT,
       patient_id INT NOT NULL,
       appointment_date DATETIME NOT NULL,
       notes TEXT,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
   );
   ```

2. **Run migration**
   ```bash
   mysql -u username -p huisarts < database/migrations/add_appointments_table.sql
   ```

3. **Document in Database Schema wiki**

### Adding a Form Field

1. **Update database schema**
   ```sql
   ALTER TABLE patients ADD COLUMN gender ENUM('M', 'F', 'O') AFTER date_of_birth;
   ```

2. **Add to form** (add_patient.php, edit_patient.php)
   ```php
   <label for="gender">Gender:</label>
   <select name="gender" id="gender">
       <option value="">Select...</option>
       <option value="M">Male</option>
       <option value="F">Female</option>
       <option value="O">Other</option>
   </select>
   ```

3. **Update INSERT/UPDATE queries**
   ```php
   $stmt = $pdo->prepare("INSERT INTO patients (first_name, last_name, gender) VALUES (?, ?, ?)");
   $stmt->execute([$firstName, $lastName, $gender]);
   ```

### Implementing Search Feature

```php
// Build search query
$search = '%' . $_GET['search'] . '%';

$sql = "SELECT * FROM patients 
        WHERE first_name LIKE ? 
           OR last_name LIKE ? 
           OR email LIKE ?
        ORDER BY last_name";

$stmt = $pdo->prepare($sql);
$stmt->execute([$search, $search, $search]);
$results = $stmt->fetchAll();
```

### Adding Validation

```php
// validation.php
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    // Remove non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 10;
}

function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// Usage
if (!validateEmail($_POST['email'])) {
    $errors[] = "Invalid email address";
}
```

## 🧪 Testing

### Manual Testing Checklist

Before committing:

- [ ] Test all CRUD operations
- [ ] Verify form validation
- [ ] Check authentication/authorization
- [ ] Test search functionality
- [ ] Verify pagination
- [ ] Check mobile responsiveness
- [ ] Test in multiple browsers
- [ ] Review error handling
- [ ] Check security (SQL injection, XSS)

### Database Testing

```sql
-- Test queries
START TRANSACTION;

-- Your test queries here
INSERT INTO patients (first_name, last_name) VALUES ('Test', 'Patient');

-- Rollback to undo changes
ROLLBACK;
```

### Browser Testing

Test in:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (if on Mac)
- Mobile browsers (iOS Safari, Chrome Mobile)

Use browser DevTools:
- Console for JavaScript errors
- Network tab for failed requests
- Responsive design mode for mobile testing

## 🔧 Debugging Tips

### Enable Debug Mode

```php
// config/config.php
define('APP_DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Debug Database Queries

```php
// Enable query logging
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $stmt = $pdo->prepare($sql);
    echo "Query: " . $stmt->queryString . "\n";
    $stmt->execute($params);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
```

### Debug Variables

```php
// Print array structure
print_r($array);

// Detailed variable info
var_dump($variable);

// Stop execution
die("Debug point reached");

// JSON encode for JavaScript
echo json_encode($data, JSON_PRETTY_PRINT);
```

### Check PHP Errors

```bash
# View PHP error log
tail -f /var/log/php/error.log

# Check syntax
php -l filename.php
```

## 🤝 Contributing

### Workflow

1. **Fork the repository**
2. **Create feature branch**
   ```bash
   git checkout -b feature/new-feature
   ```

3. **Make changes**
   - Write clean code
   - Follow coding standards
   - Add comments where needed

4. **Test thoroughly**
   - Manual testing
   - Check all functionality

5. **Commit changes**
   ```bash
   git add .
   git commit -m "Add: New feature description"
   ```

6. **Push to fork**
   ```bash
   git push origin feature/new-feature
   ```

7. **Create Pull Request**
   - Describe changes
   - Reference any issues
   - Request review

### Commit Message Guidelines

```bash
# Format
Type: Short description (50 chars max)

Longer description if needed (wrap at 72 chars)

# Types
Add:      New feature or functionality
Fix:      Bug fix
Update:   Modify existing feature
Remove:   Delete code or files
Refactor: Code restructure without changing behavior
Docs:     Documentation only
Style:    Formatting, whitespace
Test:     Add or update tests
Chore:    Maintenance tasks

# Examples
git commit -m "Add: Patient search with autocomplete"
git commit -m "Fix: Session timeout issue in auth.php"
git commit -m "Update: Improve mobile navigation layout"
git commit -m "Docs: Add API documentation to wiki"
```

### Code Review Checklist

Before submitting PR:

- [ ] Code follows style guidelines
- [ ] No sensitive data (passwords, keys) in code
- [ ] All functions documented
- [ ] Error handling implemented
- [ ] Security best practices followed
- [ ] No console.log() or debug code left
- [ ] Tested in development environment
- [ ] Documentation updated if needed

## 📚 Resources

### PHP Resources
- [PHP Official Documentation](https://www.php.net/docs.php)
- [PHP The Right Way](https://phptherightway.com/)
- [PSR Standards](https://www.php-fig.org/psr/)

### MySQL Resources
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [SQL Tutorial](https://www.w3schools.com/sql/)

### Frontend Resources
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [MDN Web Docs](https://developer.mozilla.org/)
- [JavaScript.info](https://javascript.info/)

### Security Resources
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

## 🆘 Getting Help

- Review [Troubleshooting Guide](Troubleshooting)
- Check [FAQ](FAQ)
- Search [GitHub Issues](https://github.com/KevinvdWeert/huisarts-project/issues)
- Create new issue with detailed information

## 📖 Related Documentation

- [Installation Guide](Installation-Guide)
- [Configuration Guide](Configuration-Guide)
- [Database Schema](Database-Schema)
- [Security Guidelines](Security-Guidelines)

---

**Happy coding!** We appreciate your contributions to the Huisarts Project.
