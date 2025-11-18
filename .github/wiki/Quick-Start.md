# Quick Start Guide

Get up and running with the Medical Practice Management System in minutes.

## Prerequisites

✅ PHP 7.4+ installed  
✅ MySQL 5.7+ installed  
✅ Web server (Apache/Nginx/Laragon) running  
✅ Project files downloaded

## Step 1: Setup Database (2 minutes)

### Using phpMyAdmin
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Click "New" to create database
3. Database name: `huisarts`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Import" tab
6. Choose file: `database/huisarts.sql`
7. Click "Go"

### Using Command Line
```bash
mysql -u root -p
CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE huisarts;
SOURCE database/huisarts.sql;
EXIT;
```

## Step 2: Configure Database Connection (1 minute)

Edit `config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
define('DB_USER', 'root');
define('DB_PASS', '');  // Your MySQL password
```

## Step 3: Access the Application (30 seconds)

Open your browser:
- Laragon: `http://localhost/huisarts-project/`
- Custom: Your configured URL

## Step 4: Login (30 seconds)

**Default credentials:**
- Username: `admin`
- Password: `admin123`

⚠️ **Change this immediately after first login!**

## Step 5: Test Basic Features (2 minutes)

### Add Your First Patient
1. Click **"+ Nieuwe Patiënt"** in sidebar
2. Fill in:
   - First name: `Jan`
   - Last name: `Jansen`
   - Email: `jan@example.com`
   - Phone: `0612345678`
3. Click **"Patiënt Toevoegen"**
4. ✅ Patient appears in dashboard

### Search for Patients
1. Type `Jan` in search box
2. ✅ Filtered results appear instantly

### Add a Note
1. Click **"Notities"** on patient card
2. Type: `Eerste controle afspraak`
3. Click **"Notitie Toevoegen"**
4. ✅ Note appears with timestamp

### Edit Patient
1. Click **"Bewerk"** button
2. Change phone to: `0687654321`
3. Click **"Wijzigingen Opslaan"**
4. ✅ Updated information saved

## Common First-Time Issues

### Issue: "Database connection failed"
**Solution:**
```php
// Check config/config.php
define('DB_HOST', 'localhost');  // ✅ Correct
define('DB_PASS', 'YOUR_PASS');  // ✅ Add your password
```

### Issue: "Page not found"
**Solution:**
- Laragon: Access via `localhost/huisarts-project/`
- Check Apache/Nginx is running
- Verify document root path

### Issue: Cross symbols (❌) appear
**Solution:**
```powershell
# Run this command in project root
$files = Get-ChildItem -Filter "*.php" -Recurse
foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $content -replace '"></path>', '"/>' | 
        Set-Content $file.FullName -NoNewline
}
```

### Issue: "Cannot log in"
**Solution:**
- Username: `admin` (lowercase)
- Password: `admin123` (exact)
- Check database users table has records
- Clear browser cookies

## Quick Feature Overview

### Dashboard Views

**Card View:**
- Visual patient cards
- Shows avatar with initials
- Great for browsing

**Table View (Default):**
- Compact list format
- Sortable columns
- Better for searching

Toggle: Click view icons in sidebar

### Search & Filter

**Search:**
- Type in search box
- Searches: name, email, phone, city
- Real-time filtering

**Sort:**
- Click column headers (table view)
- Use sort dropdown (card view)
- Ascending ↑ / Descending ↓

**Pagination:**
- Choose: 10, 25, 50, or 100 per page
- Navigate: Previous / Next buttons

### Patient Management

**Add Patient:**
- Button in header or sidebar
- Required: First name, Last name
- Optional: Contact info, DOB, address

**Edit Patient:**
- Click "Bewerk" button
- Modify any field
- Auto-saves timestamp

**Delete Patient:**
- Click "Verwijder" button
- Confirmation required
- Removes patient + notes

**Patient Notes:**
- Click "Notities" button
- Add/edit/delete notes
- Timestamped with username

## Keyboard Shortcuts

- **Ctrl + K**: Focus search box (when implemented)
- **Esc**: Close modals (when implemented)
- **Tab**: Navigate form fields

## Mobile Access

The dashboard is fully responsive:
- 📱 Mobile phones: Card view recommended
- 📱 Tablets: Both views work well
- 💻 Desktop: Table view optimal

## Next Steps

Now that you're up and running:

1. **Change default password**
   - Edit users table in database
   - Or create password change page

2. **Add real patients**
   - Import from CSV (if available)
   - Or add manually

3. **Customize settings**
   - Check [Configuration](Configuration)
   - Adjust per-page defaults

4. **Explore features**
   - Try all CRUD operations
   - Test search and filters
   - Practice note-taking

5. **Read documentation**
   - [Patient Management](Patient-Management)
   - [Dashboard](Dashboard)
   - [Database Schema](Database-Schema)

## Getting Help

**Stuck? Check these resources:**

1. [FAQ](FAQ) - Common questions
2. [Common Issues](Common-Issues) - Troubleshooting
3. [GitHub Issues](https://github.com/KevinvdWeert/huisarts-project/issues) - Report bugs
4. [Wiki Home](Home) - All documentation

## Video Tutorial (Coming Soon)

A video walkthrough covering:
- ▶️ Installation
- ▶️ First login
- ▶️ Adding patients
- ▶️ Managing notes
- ▶️ Search & filter

## Quick Reference Card

```
┌─────────────────────────────────────┐
│  Quick Reference                    │
├─────────────────────────────────────┤
│ Add Patient    → + Nieuwe Patiënt  │
│ Search         → Type in search box │
│ Sort           → Click column/sort  │
│ View Mode      → Toggle icons       │
│ Per Page       → Sidebar buttons    │
│ Edit           → Bewerk button      │
│ Delete         → Verwijder button   │
│ Notes          → Notities button    │
│ Logout         → User menu → Logout │
└─────────────────────────────────────┘
```

## Success Checklist

After completing this guide, you should be able to:

- ✅ Access the application
- ✅ Log in successfully
- ✅ Add a new patient
- ✅ Search for patients
- ✅ Edit patient information
- ✅ Add patient notes
- ✅ Switch between views
- ✅ Navigate pagination
- ✅ Understand basic features

**All working? Congratulations! 🎉**

You're ready to use the Medical Practice Management System.

## Related Documentation

- [Installation Guide](Installation-Guide) - Detailed setup
- [Configuration](Configuration) - Advanced settings
- [Patient Management](Patient-Management) - Feature details
- [Dashboard](Dashboard) - Interface guide
