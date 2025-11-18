# Database Schema

Complete documentation of the Huisarts Project database structure.

## 📊 Overview

The database uses MySQL 8.0+ / MariaDB 10.3+ with InnoDB engine and UTF-8MB4 character encoding.

**Database Name**: `huisarts`
**Character Set**: `utf8mb4`
**Collation**: `utf8mb4_unicode_ci`

## 📋 Table Overview

The database consists of three main tables:

1. **`patients`** - Patient information
2. **`notes`** - Patient medical notes
3. **`users`** - System users (doctors, administrators)

## 🏥 Patients Table

### Schema

```sql
CREATE TABLE `patients` (
  `patient_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `house_number` varchar(20) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`patient_id`),
  KEY `idx_patients_lastname` (`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Field Descriptions

| Field | Type | Null | Description |
|-------|------|------|-------------|
| `patient_id` | INT | NO | Primary key, auto-increment |
| `first_name` | VARCHAR(100) | NO | Patient's first name |
| `last_name` | VARCHAR(100) | NO | Patient's last name |
| `address` | VARCHAR(255) | YES | Street address |
| `house_number` | VARCHAR(20) | YES | House/building number |
| `postcode` | VARCHAR(20) | YES | Postal/ZIP code |
| `city` | VARCHAR(100) | YES | City/municipality |
| `phone` | VARCHAR(50) | YES | Contact phone number |
| `email` | VARCHAR(150) | YES | Email address |
| `date_of_birth` | DATE | YES | Date of birth |
| `created_at` | DATETIME | YES | Record creation timestamp |
| `updated_at` | DATETIME | YES | Last update timestamp |

### Indexes

- **Primary Key**: `patient_id`
- **Index**: `idx_patients_lastname` on `last_name` (improves search performance)

### Constraints

- `patient_id`: AUTO_INCREMENT
- `first_name`: NOT NULL
- `last_name`: NOT NULL
- `created_at`: DEFAULT CURRENT_TIMESTAMP
- `updated_at`: DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

### Example Data

```sql
INSERT INTO patients (first_name, last_name, address, house_number, 
                      postcode, city, phone, email, date_of_birth) 
VALUES 
  ('John', 'Doe', 'Main Street', '123', '1234AB', 'Amsterdam', 
   '020-1234567', 'john.doe@example.com', '1980-05-15'),
  ('Jane', 'Smith', 'Oak Avenue', '456', '5678CD', 'Rotterdam', 
   '010-9876543', 'jane.smith@example.com', '1975-09-22');
```

## 📝 Notes Table

### Schema

```sql
CREATE TABLE `notes` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `note_date` date DEFAULT NULL,
  `text` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_notes_patient_date` (`patient_id`,`note_date`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`patient_id`) 
    REFERENCES `patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Field Descriptions

| Field | Type | Null | Description |
|-------|------|------|-------------|
| `note_id` | INT | NO | Primary key, auto-increment |
| `patient_id` | INT | NO | Reference to patient |
| `user_id` | INT | YES | User who created the note |
| `subject` | VARCHAR(200) | YES | Note subject/title |
| `note_date` | DATE | YES | Date of consultation/note |
| `text` | TEXT | YES | Note content |
| `created_at` | DATETIME | YES | Record creation timestamp |
| `updated_at` | DATETIME | YES | Last update timestamp |

### Indexes

- **Primary Key**: `note_id`
- **Foreign Key**: `patient_id` → `patients(patient_id)`
- **Foreign Key**: `user_id` → `users(user_id)`
- **Composite Index**: `idx_notes_patient_date` on `patient_id, note_date` (improves note queries)

### Foreign Key Constraints

1. **`notes_ibfk_1`**: `patient_id` → `patients(patient_id)`
   - **ON DELETE CASCADE**: Deleting a patient deletes all their notes
   - **ON UPDATE CASCADE**: Updating patient_id updates in notes

2. **`notes_ibfk_2`**: `user_id` → `users(user_id)`
   - **ON DELETE SET NULL**: Deleting a user sets user_id to NULL in notes
   - **ON UPDATE CASCADE**: Updating user_id updates in notes

### Example Data

```sql
INSERT INTO notes (patient_id, user_id, subject, note_date, text) 
VALUES 
  (1, 1, 'Initial Consultation', '2024-11-15', 
   'Patient presented with mild symptoms. Prescribed medication.'),
  (1, 2, 'Follow-up Visit', '2024-11-22', 
   'Condition improved. Continue current treatment.');
```

## 👤 Users Table

### Schema

```sql
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'doctor',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Field Descriptions

| Field | Type | Null | Description |
|-------|------|------|-------------|
| `user_id` | INT | NO | Primary key, auto-increment |
| `username` | VARCHAR(100) | NO | Unique username |
| `password_hash` | VARCHAR(255) | NO | Hashed password (bcrypt) |
| `role` | VARCHAR(50) | YES | User role (admin, doctor) |
| `created_at` | DATETIME | YES | Account creation timestamp |

### Indexes

- **Primary Key**: `user_id`
- **Unique Key**: `username` (ensures unique usernames)

### Constraints

- `user_id`: AUTO_INCREMENT
- `username`: NOT NULL, UNIQUE
- `password_hash`: NOT NULL
- `role`: DEFAULT 'doctor'
- `created_at`: DEFAULT CURRENT_TIMESTAMP

### User Roles

- **`admin`**: Full system access, can manage users
- **`doctor`**: Can manage patients and notes

### Example Data

```sql
-- Password for both is 'password' (should be changed!)
INSERT INTO users (username, password_hash, role) 
VALUES 
  ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
  ('doctor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor');
```

## 🔗 Entity Relationships

### ER Diagram (Text Format)

```
┌─────────────────┐
│     USERS       │
├─────────────────┤
│ user_id (PK)    │
│ username        │
│ password_hash   │
│ role            │
│ created_at      │
└─────────────────┘
         │
         │ (1:N)
         ▼
┌─────────────────┐       ┌─────────────────┐
│     NOTES       │       │    PATIENTS     │
├─────────────────┤       ├─────────────────┤
│ note_id (PK)    │ (N:1) │ patient_id (PK) │
│ patient_id (FK) ├───────┤ first_name      │
│ user_id (FK)    │       │ last_name       │
│ subject         │       │ address         │
│ note_date       │       │ house_number    │
│ text            │       │ postcode        │
│ created_at      │       │ city            │
│ updated_at      │       │ phone           │
└─────────────────┘       │ email           │
                          │ date_of_birth   │
                          │ created_at      │
                          │ updated_at      │
                          └─────────────────┘
```

### Relationships

1. **Users → Notes**: One-to-Many
   - One user can create many notes
   - Each note has one author (or NULL)

2. **Patients → Notes**: One-to-Many
   - One patient can have many notes
   - Each note belongs to one patient

## 📈 Database Statistics

Sample database includes:
- **1000 patients** (with diverse international data)
- **2 users** (admin and doctor)
- **Variable notes** per patient

## 🔍 Common Queries

### Get All Patients

```sql
SELECT * FROM patients 
ORDER BY last_name, first_name;
```

### Search Patients

```sql
SELECT * FROM patients 
WHERE first_name LIKE '%John%' 
   OR last_name LIKE '%Smith%'
   OR email LIKE '%example.com%'
ORDER BY last_name;
```

### Get Patient with Notes

```sql
SELECT 
    p.patient_id,
    p.first_name,
    p.last_name,
    p.email,
    COUNT(n.note_id) as note_count
FROM patients p
LEFT JOIN notes n ON p.patient_id = n.patient_id
GROUP BY p.patient_id
ORDER BY p.last_name;
```

### Get Notes for Specific Patient

```sql
SELECT 
    n.note_id,
    n.subject,
    n.note_date,
    n.text,
    n.created_at,
    u.username as author
FROM notes n
LEFT JOIN users u ON n.user_id = u.user_id
WHERE n.patient_id = 1
ORDER BY n.note_date DESC;
```

### Get Recent Patients

```sql
SELECT * FROM patients 
ORDER BY created_at DESC 
LIMIT 10;
```

### Count Patients by City

```sql
SELECT city, COUNT(*) as patient_count
FROM patients
WHERE city IS NOT NULL
GROUP BY city
ORDER BY patient_count DESC
LIMIT 10;
```

## 🔧 Maintenance Queries

### Optimize Tables

```sql
OPTIMIZE TABLE patients, notes, users;
```

### Check Table Status

```sql
SHOW TABLE STATUS FROM huisarts;
```

### Analyze Tables

```sql
ANALYZE TABLE patients, notes, users;
```

### Repair Tables (if needed)

```sql
REPAIR TABLE patients, notes, users;
```

## 💾 Backup & Restore

### Backup Database

```bash
# Full backup
mysqldump -u username -p huisarts > huisarts_backup.sql

# Structure only
mysqldump -u username -p --no-data huisarts > huisarts_structure.sql

# Data only
mysqldump -u username -p --no-create-info huisarts > huisarts_data.sql
```

### Restore Database

```bash
# Restore full backup
mysql -u username -p huisarts < huisarts_backup.sql

# Restore structure
mysql -u username -p huisarts < huisarts_structure.sql

# Restore data
mysql -u username -p huisarts < huisarts_data.sql
```

## 🔐 Security Considerations

### Password Storage

Passwords are stored using PHP's `password_hash()` function:
- **Algorithm**: bcrypt (PASSWORD_BCRYPT)
- **Cost**: 10 (default)
- **Never store plain text passwords**

```php
// Hashing a password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verifying a password
if (password_verify($password, $hash)) {
    // Password is correct
}
```

### Data Sanitization

Always use prepared statements:

```php
// Good: Using prepared statements
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patient_id]);

// Bad: Direct query (SQL injection risk)
$query = "SELECT * FROM patients WHERE patient_id = " . $patient_id;
```

## 📊 Indexing Strategy

### Current Indexes

1. **Primary Keys**: All tables (automatic)
2. **`idx_patients_lastname`**: Improves patient search by last name
3. **`idx_notes_patient_date`**: Optimizes note queries by patient and date
4. **`username` Unique**: Ensures unique usernames

### Adding New Indexes

```sql
-- Add index for email searches
CREATE INDEX idx_patients_email ON patients(email);

-- Add index for phone searches
CREATE INDEX idx_patients_phone ON patients(phone);

-- Add full-text index for note content
CREATE FULLTEXT INDEX idx_notes_fulltext ON notes(subject, text);
```

## 🔄 Migration Examples

### Add New Column

```sql
-- Add gender column to patients
ALTER TABLE patients 
ADD COLUMN gender ENUM('M', 'F', 'O') DEFAULT NULL 
AFTER date_of_birth;
```

### Modify Column

```sql
-- Increase phone field length
ALTER TABLE patients 
MODIFY COLUMN phone VARCHAR(100);
```

### Add Foreign Key

```sql
-- Add foreign key if not exists
ALTER TABLE notes
ADD CONSTRAINT fk_notes_patient
FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
ON DELETE CASCADE ON UPDATE CASCADE;
```

## 📚 Related Documentation

- [Installation Guide](Installation-Guide) - Database setup instructions
- [Configuration Guide](Configuration-Guide) - Database configuration
- [API Reference](API-Reference) - Database interaction via API
- [Development Guide](Development-Guide) - Working with the database

---

**Need Help?** Check the [Troubleshooting](Troubleshooting) guide for database issues.
