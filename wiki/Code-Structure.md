# Code Structure

Detailed explanation of the Huisarts Project codebase organization and architecture.

## 📂 Directory Structure

```
huisarts-project/
│
├── assets/                    # Static assets (CSS, JS, images)
│   ├── css/
│   │   └── style.css         # Custom Tailwind extensions
│   ├── img/                  # Images and graphics
│   └── js/
│       └── script.js         # Client-side JavaScript
│
├── config/                    # Configuration files
│   └── config.php            # Main configuration
│
├── database/                  # Database files
│   ├── connection.php        # PDO database connection
│   ├── huisarts.sql          # Database schema with sample data
│   └── huisarts.csv          # CSV export of sample data
│
├── includes/                  # Reusable components
│   ├── header.php            # HTML head, navigation, CSS
│   ├── footer.php            # Footer, scripts, closing tags
│   ├── init.php              # Initialization and bootstrap
│   └── security_helpers.php  # Security utility functions
│
├── wiki/                      # Documentation (Wiki pages)
│   ├── Home.md
│   ├── Installation-Guide.md
│   ├── User-Guide.md
│   └── ... (other wiki pages)
│
├── .htaccess                  # Apache configuration
├── README.md                  # Project overview
│
├── index.php                  # Homepage / Landing page
├── about.php                  # About the practice
├── services.php               # Medical services offered
├── contact.php                # Contact form
├── privacy.php                # Privacy policy
├── contact_handler.php        # Contact form processing
│
├── login.php                  # Login form and authentication
├── logout.php                 # Logout and session cleanup
├── auth.php                   # Authentication functions
│
├── dashboard.php              # Main patient dashboard
├── add_patient.php            # Add new patient form
├── edit_patient.php           # Edit patient form
├── delete_patient.php         # Delete patient handler
└── patient_notes.php          # Patient notes management
```

## 🏗️ Architecture Overview

### Three-Tier Architecture

```
┌─────────────────────────────────────┐
│      Presentation Layer             │
│  (HTML, CSS, JavaScript, PHP Views) │
└────────────────┬────────────────────┘
                 │
┌────────────────▼────────────────────┐
│       Business Logic Layer          │
│    (PHP Controllers, Functions)     │
└────────────────┬────────────────────┘
                 │
┌────────────────▼────────────────────┐
│        Data Access Layer            │
│      (PDO, Database Queries)        │
└────────────────┬────────────────────┘
                 │
┌────────────────▼────────────────────┐
│          Database Layer             │
│         (MySQL/MariaDB)             │
└─────────────────────────────────────┘
```

### Request Flow

```
1. Browser Request
         ↓
2. Web Server (Apache/Nginx)
         ↓
3. PHP Processor
         ↓
4. Load Configuration (config/config.php)
         ↓
5. Check Authentication (auth.php)
         ↓
6. Database Connection (database/connection.php)
         ↓
7. Business Logic (page-specific PHP)
         ↓
8. Render View (includes/header.php + content + includes/footer.php)
         ↓
9. Send Response to Browser
```

## 📄 Page Structure

### Typical Page Layout

```php
<?php
// 1. Configuration and Dependencies
require_once 'config/config.php';
require_once 'auth.php';
require_once 'database/connection.php';

// 2. Authentication Check (if protected)
checkSession();

// 3. Get Current User
$current_user = getCurrentUser();

// 4. Database Connection
$pdo = getDbConnection();

// 5. Business Logic
// - Handle form submissions
// - Process data
// - Query database
// - Prepare data for display

// 6. Include Header
require_once 'includes/header.php';
?>

<!-- 7. HTML Content -->
<div class="container mx-auto px-6 py-12">
    <h1>Page Title</h1>
    <!-- Page content -->
</div>

<?php
// 8. Include Footer
require_once 'includes/footer.php';
?>
```

## 🔧 Core Files Explained

### config/config.php

**Purpose**: Central configuration file

**Contents**:
- Database credentials
- Application settings
- Session configuration
- Timezone settings
- Error reporting

**Usage**:
```php
require_once 'config/config.php';
// Now all constants are available
echo DB_HOST; // 'localhost'
```

### database/connection.php

**Purpose**: Database connection management

**Key Function**:
```php
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed.");
    }
}
```

**Usage**:
```php
$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT * FROM patients");
$stmt->execute();
```

### auth.php

**Purpose**: Authentication and session management

**Key Functions**:
```php
// Start session securely
function startSession() { }

// Check if user is logged in
function isLoggedIn() { }

// Require login (redirect if not logged in)
function checkSession() { }

// Get current user information
function getCurrentUser() { }

// Logout user
function logout() { }
```

**Usage**:
```php
require_once 'auth.php';
checkSession(); // Redirects to login if not authenticated
$user = getCurrentUser(); // Get user data
```

### includes/header.php

**Purpose**: Common HTML head and navigation

**Contents**:
- DOCTYPE declaration
- HTML head (meta tags, title, CSS)
- Navigation menu
- Opening body tag

**Customization**:
- Modify navigation links
- Change page title
- Add/remove CSS files
- Update meta tags

### includes/footer.php

**Purpose**: Common footer and closing tags

**Contents**:
- Footer content
- JavaScript files
- Closing body and html tags

**Customization**:
- Modify footer content
- Add/remove JavaScript files
- Add analytics tracking

## 🔐 Authentication Flow

```
┌──────────────┐
│  User visits │
│  login.php   │
└──────┬───────┘
       │
       ▼
┌──────────────────────┐
│ Enter credentials    │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ POST to login.php    │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐     ┌─────────────┐
│ Validate username    │────▶│ User exists?│
└──────┬───────────────┘     └─────┬───────┘
       │                            │ No
       │ Yes                        ▼
       │                     ┌──────────────┐
       │                     │Show error msg│
       │                     └──────────────┘
       ▼
┌──────────────────────┐
│ Verify password with │
│ password_verify()    │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ Password correct?    │
└──────┬───────────────┘
       │ Yes
       ▼
┌──────────────────────┐
│ Create session       │
│ Store user_id, role  │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ Redirect to          │
│ dashboard.php        │
└──────────────────────┘
```

## 📊 Data Flow Example: Adding Patient

```
1. User fills form in add_patient.php
         ↓
2. Form submitted (POST) to add_patient.php
         ↓
3. PHP receives $_POST data
         ↓
4. Validate input
   - Check required fields
   - Validate email format
   - Sanitize data
         ↓
5. Prepare SQL INSERT statement
   $stmt = $pdo->prepare("INSERT INTO patients ...");
         ↓
6. Execute with parameters
   $stmt->execute([$first_name, $last_name, ...]);
         ↓
7. Check for errors
         ↓
8. Set success message in session
   $_SESSION['success'] = "Patient added successfully";
         ↓
9. Redirect to dashboard or patient list
   header("Location: dashboard.php");
```

## 🎨 Frontend Architecture

### CSS Structure

**Tailwind CSS**: Primary styling framework
- Utility-first approach
- Responsive design
- Customizable via CDN

**Custom CSS** (`assets/css/style.css`):
- Extend Tailwind classes
- Custom animations
- Gradient definitions
- Component-specific styles

**Example**:
```css
/* Custom gradient backgrounds */
.gradient-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Custom animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}
```

### JavaScript Structure

**Vanilla JavaScript** (`assets/js/script.js`):
- No jQuery or heavy frameworks
- ES6+ syntax
- Event-driven
- Modular functions

**Common Functions**:
```javascript
// Mobile menu toggle
function toggleMobileMenu() { }

// Form validation
function validateForm() { }

// Search functionality
function handleSearch() { }

// Animations on scroll
function initScrollAnimations() { }

// Confirmation dialogs
function confirmDelete() { }
```

## 🗄️ Database Interaction Patterns

### Query Pattern

```php
// 1. Prepare statement
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");

// 2. Execute with parameters
$stmt->execute([$patient_id]);

// 3. Fetch results
$patient = $stmt->fetch(); // Single row
// or
$patients = $stmt->fetchAll(); // Multiple rows

// 4. Use data
if ($patient) {
    echo $patient['first_name'];
}
```

### Insert Pattern

```php
try {
    $sql = "INSERT INTO patients (first_name, last_name, email) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email]);
    
    $patient_id = $pdo->lastInsertId();
    $_SESSION['success'] = "Patient added successfully";
} catch (PDOException $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "Error adding patient";
}
```

### Update Pattern

```php
try {
    $sql = "UPDATE patients SET first_name = ?, last_name = ?, email = ? WHERE patient_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email, $patientId]);
    
    $_SESSION['success'] = "Patient updated successfully";
} catch (PDOException $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "Error updating patient";
}
```

### Delete Pattern

```php
try {
    $sql = "DELETE FROM patients WHERE patient_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$patientId]);
    
    $_SESSION['success'] = "Patient deleted successfully";
} catch (PDOException $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "Error deleting patient";
}
```

## 🔒 Security Patterns

### Input Sanitization

```php
// Sanitize string input
$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

// Validate email
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Validate integer
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

// Validate date
$date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
```

### Output Escaping

```php
// Always escape when outputting user data
<p><?php echo htmlspecialchars($patient['name'], ENT_QUOTES, 'UTF-8'); ?></p>

// For attributes
<input type="text" value="<?php echo htmlspecialchars($patient['name'], ENT_QUOTES, 'UTF-8'); ?>">
```

### CSRF Protection (Implementation Example)

```php
// Generate token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// In form
<input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

// Validate on submission
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die('Invalid CSRF token');
}
```

## 📱 Responsive Design Patterns

### Mobile-First Approach

```html
<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/2">Column 1</div>
    <div class="w-full md:w-1/2">Column 2</div>
</div>

<!-- Hide on mobile, show on desktop -->
<div class="hidden md:block">Desktop only content</div>

<!-- Show on mobile, hide on desktop -->
<div class="block md:hidden">Mobile only content</div>
```

### Breakpoints

Tailwind CSS breakpoints used:
- `sm:` - Small devices (640px+)
- `md:` - Medium devices (768px+)
- `lg:` - Large devices (1024px+)
- `xl:` - Extra large devices (1280px+)

## 🔄 Session Management

### Session Data Structure

```php
$_SESSION = [
    'user_id' => 1,
    'username' => 'admin',
    'role' => 'admin',
    'logged_in' => true,
    'last_activity' => 1234567890,
    'ip' => '192.168.1.1',
    'user_agent' => 'Mozilla/5.0...',
    'csrf_token' => 'abc123...'
];
```

### Flash Messages

```php
// Set message
$_SESSION['success'] = "Operation successful";
$_SESSION['error'] = "An error occurred";

// Display and clear
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
```

## 📚 Related Documentation

- [Development Guide](Development-Guide) - Contribution guidelines
- [Database Schema](Database-Schema) - Database structure
- [Security Guidelines](Security-Guidelines) - Security practices
- [Configuration Guide](Configuration-Guide) - Configuration options

---

**Understanding the code structure helps you**:
- Navigate the codebase efficiently
- Make targeted modifications
- Follow best practices
- Contribute effectively
