# Database Schema

## Overview

The Medical Practice Management System uses a MySQL/MariaDB database with the following structure.

## Database Name
`huisarts`

Character Set: `utf8mb4`  
Collation: `utf8mb4_unicode_ci`

## Tables

### 1. `patients`

Stores patient information and records.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `patient_id` | INT | NO | AUTO_INCREMENT | Primary key |
| `first_name` | VARCHAR(100) | NO | - | Patient's first name |
| `last_name` | VARCHAR(100) | NO | - | Patient's last name |
| `date_of_birth` | DATE | YES | NULL | Patient's birth date |
| `address` | VARCHAR(255) | YES | NULL | Street address |
| `house_number` | VARCHAR(20) | YES | NULL | House/building number |
| `postcode` | VARCHAR(20) | YES | NULL | Postal/ZIP code |
| `city` | VARCHAR(100) | YES | NULL | City name |
| `phone` | VARCHAR(20) | YES | NULL | Phone number |
| `email` | VARCHAR(100) | YES | NULL | Email address |
| `created_at` | TIMESTAMP | NO | CURRENT_TIMESTAMP | Record creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT_TIMESTAMP ON UPDATE | Last update time |

**Indexes:**
- PRIMARY KEY (`patient_id`)
- INDEX `idx_last_name` (`last_name`)
- INDEX `idx_email` (`email`)
- INDEX `idx_city` (`city`)

### 2. `notes`

Stores medical notes associated with patients.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `note_id` | INT | NO | AUTO_INCREMENT | Primary key |
| `patient_id` | INT | NO | - | Foreign key to patients |
| `user_id` | INT | YES | NULL | User who created note |
| `note_content` | TEXT | NO | - | Note text content |
| `created_at` | TIMESTAMP | NO | CURRENT_TIMESTAMP | Note creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT_TIMESTAMP ON UPDATE | Last update time |

**Indexes:**
- PRIMARY KEY (`note_id`)
- FOREIGN KEY (`patient_id`) REFERENCES `patients(patient_id)` ON DELETE CASCADE
- INDEX `idx_patient_id` (`patient_id`)
- INDEX `idx_created_at` (`created_at`)

### 3. `users`

Stores user accounts for authentication.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `user_id` | INT | NO | AUTO_INCREMENT | Primary key |
| `username` | VARCHAR(50) | NO | - | Login username |
| `password` | VARCHAR(255) | NO | - | Hashed password |
| `role` | ENUM('admin','doctor','nurse') | NO | 'doctor' | User role |
| `email` | VARCHAR(100) | YES | NULL | User email |
| `created_at` | TIMESTAMP | NO | CURRENT_TIMESTAMP | Account creation |
| `last_login` | TIMESTAMP | YES | NULL | Last login time |

**Indexes:**
- PRIMARY KEY (`user_id`)
- UNIQUE KEY `username` (`username`)
- INDEX `idx_role` (`role`)

## Entity Relationships

```
┌─────────────┐
│   users     │
│             │
│ user_id (PK)│
│ username    │
│ password    │
│ role        │
└─────────────┘
       │
       │ 1:N (creates)
       │
       ▼
┌─────────────┐          ┌─────────────┐
│  patients   │          │    notes    │
│             │          │             │
│ patient_id  │◄─────────│ note_id (PK)│
│ first_name  │   1:N    │ patient_id  │
│ last_name   │          │ user_id (FK)│
│ email       │          │ note_content│
│ ...         │          │ created_at  │
└─────────────┘          └─────────────┘
```

### Relationships

1. **patients ↔ notes** (One-to-Many)
   - One patient can have multiple notes
   - Each note belongs to one patient
   - CASCADE DELETE: Deleting a patient removes all their notes

2. **users ↔ notes** (One-to-Many)
   - One user can create multiple notes
   - Each note is created by one user
   - NULL allowed if user is deleted

## SQL Schema

### Create Database

```sql
CREATE DATABASE IF NOT EXISTS huisarts 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE huisarts;
```

### Create Tables

```sql
-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'nurse') NOT NULL DEFAULT 'doctor',
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Patients table
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE,
    address VARCHAR(255),
    house_number VARCHAR(20),
    postcode VARCHAR(20),
    city VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_last_name (last_name),
    INDEX idx_email (email),
    INDEX idx_city (city)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notes table
CREATE TABLE notes (
    note_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    user_id INT,
    note_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_patient_id (patient_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Sample Data

```sql
-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, role, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'admin@example.com');

-- Insert sample patients
INSERT INTO patients (first_name, last_name, date_of_birth, city, phone, email) VALUES
('John', 'Doe', '1980-05-15', 'Amsterdam', '0612345678', 'john.doe@example.com'),
('Jane', 'Smith', '1992-08-22', 'Rotterdam', '0687654321', 'jane.smith@example.com'),
('Bob', 'Johnson', '1975-03-10', 'Utrecht', '0611223344', 'bob.johnson@example.com');
```

## Database Migrations

### Version History

| Version | Date | Description |
|---------|------|-------------|
| 1.0 | 2025-01-01 | Initial schema with patients, notes, users |
| 1.1 | 2025-02-15 | Added indexes for performance |
| 1.2 | 2025-03-20 | Added CASCADE DELETE for notes |

## Performance Considerations

### Indexes
- `last_name`: Most common search/sort field
- `email`: Used for lookups and validation
- `city`: Geographic filtering
- `patient_id` in notes: Foreign key relationship
- `created_at` in notes: Chronological queries

### Query Optimization Tips

1. **Use prepared statements** (already implemented)
2. **Limit result sets** with pagination
3. **Index foreign keys** for JOIN operations
4. **Use transactions** for multi-table operations
5. **Avoid SELECT *** - specify columns needed

## Backup Recommendations

### Daily Backups
```bash
mysqldump -u root -p huisarts > backup_$(date +%Y%m%d).sql
```

### Restore from Backup
```bash
mysql -u root -p huisarts < backup_20250118.sql
```

## Security Notes

- **Passwords**: Hashed using `password_hash()` with bcrypt
- **SQL Injection**: Protected via PDO prepared statements
- **XSS Protection**: Output escaped with `htmlspecialchars()`
- **CSRF**: Consider adding CSRF tokens for forms
- **Permissions**: Limit database user permissions in production

## Related Documentation

- [Installation Guide](Installation-Guide) - Database setup instructions
- [Configuration](Configuration) - Database connection settings
- [Patient Management](Patient-Management) - How data is used
