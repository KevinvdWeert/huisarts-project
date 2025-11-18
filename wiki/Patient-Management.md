# Patient Management

Comprehensive guide to managing patient records in the Huisarts Project.

## 📋 Overview

The patient management system is the core feature of the Huisarts Project, allowing healthcare professionals to efficiently manage patient records with full CRUD (Create, Read, Update, Delete) capabilities.

## 👥 Patient List View

### Accessing Patient List

From the dashboard or home page, click **"Dashboard"** or **"Ga naar Dashboard"** to view all patients.

### Display Options

#### Table View (Default)
- Compact, data-dense layout
- Multiple patients visible at once
- Sortable columns
- Quick scanning of information

#### Card View
- Visual card-based layout
- Better for browsing individual records
- More detailed information per card
- Easier mobile navigation

**Switch views**: Click the view toggle button in the top-right corner.

### Column Information

The patient list displays:

| Column | Description |
|--------|-------------|
| Name | Full name (Last, First) |
| Date of Birth | Birth date and calculated age |
| Email | Contact email address |
| Phone | Contact phone number |
| Address | Full address with city |
| Last Updated | Date of last modification |
| Actions | Edit and Delete buttons |

## 🔍 Searching Patients

### Quick Search

The search box at the top of the list searches across:
- First name
- Last name
- Email address
- Phone number
- City
- Postal code

**Features**:
- Real-time results (updates as you type)
- Case-insensitive
- Partial matching
- Searches all fields simultaneously

**Example searches**:
```
"john"      → Finds John, Johnny, Johnson
"@gmail"    → Finds all Gmail addresses
"020"       → Finds all Amsterdam numbers (starts with 020)
"adam"      → Finds addresses in Amsterdam
```

### Clear Search

Click the **X** button in search box or delete all text to show all patients.

## 🔢 Sorting Patients

Click column headers to sort:

- **Name**: Alphabetical by last name, then first name
- **Date of Birth**: Oldest to youngest (or reverse)
- **Email**: Alphabetical
- **City**: Alphabetical
- **Last Updated**: Most recent first (or reverse)

Click again to reverse sort order.

**Sort indicators**:
- ▲ Ascending (A-Z, oldest-newest)
- ▼ Descending (Z-A, newest-oldest)

## ➕ Adding New Patients

### Step-by-Step Guide

1. **Navigate to Add Patient Form**
   - From Dashboard: Click **"Nieuwe Patiënt"** or **"Add New Patient"**
   - From Patient List: Click **"Add Patient"** button

2. **Fill Required Fields** (marked with *)
   
   **Personal Information**:
   - **First Name*** - Patient's given name
   - **Last Name*** - Patient's family name
   - **Date of Birth*** - Format: DD-MM-YYYY or use date picker

   **Contact Information**:
   - **Email** - Valid email address (validated)
   - **Phone** - Phone number (any format)

   **Address**:
   - **Street Address** - Street name
   - **House Number** - Building/apartment number
   - **Postal Code** - ZIP/postal code
   - **City** - City or municipality

3. **Validate Input**
   
   The form automatically validates:
   - Required fields are filled
   - Email format is correct (if provided)
   - Date of birth is valid date
   - All fields meet length requirements

4. **Save Patient**
   - Click **"Save Patient"** button
   - Success message appears
   - Redirected to patient list or details

### Field Specifications

| Field | Type | Max Length | Required | Validation |
|-------|------|------------|----------|------------|
| First Name | Text | 100 | Yes | Alphanumeric + spaces |
| Last Name | Text | 100 | Yes | Alphanumeric + spaces |
| Email | Email | 150 | No | Valid email format |
| Phone | Text | 50 | No | Any format |
| Address | Text | 255 | No | Any characters |
| House Number | Text | 20 | No | Alphanumeric |
| Postal Code | Text | 20 | No | Alphanumeric |
| City | Text | 100 | No | Letters + spaces |
| Date of Birth | Date | - | Yes | Valid date, not future |

### Input Tips

**Names**:
- Use proper capitalization
- Include prefixes (van, de, etc.)
- Example: "van den Berg"

**Email**:
- Must include @ and domain
- Example: patient@example.com

**Phone**:
- Any format accepted
- Examples: 020-1234567, +31 20 123 4567, 0201234567

**Address**:
- Be consistent with format
- Include street name
- Example: "Kalverstraat"

**Postal Code**:
- Dutch format: 1234AB
- International accepted
- No validation on format

## ✏️ Editing Patient Information

### How to Edit

1. **Locate Patient**
   - Find in patient list
   - Or search for patient

2. **Open Edit Form**
   - Click **"Edit"** button next to patient
   - Or click patient name, then click **"Edit"**

3. **Modify Information**
   - Update any fields
   - Same validation as adding patient
   - All fields editable

4. **Save Changes**
   - Click **"Update Patient"** button
   - Confirmation message appears
   - Changes reflect immediately

### Cancel Editing

Click **"Cancel"** button to discard changes and return without saving.

### Audit Trail

Changes are tracked:
- `updated_at` timestamp automatically updated
- Shows last modification date
- Consider implementing change log for medical compliance

## 🗑️ Deleting Patients

### ⚠️ Important Warning

**Patient deletion is permanent and includes**:
- Patient record
- All patient notes (CASCADE delete)
- Cannot be undone without database restore

### Deletion Process

1. **Initiate Deletion**
   - From patient list: Click **"Delete"** button
   - From patient details: Click **"Delete Patient"**
   - From edit form: Click **"Delete"** button

2. **Confirm Deletion**
   - Confirmation dialog appears
   - Review patient information carefully
   - May require typing patient name
   - May require administrator password

3. **Complete Deletion**
   - Click **"Confirm Delete"**
   - Patient removed from database
   - All notes automatically deleted (foreign key cascade)
   - Success message appears
   - Redirected to patient list

### Best Practices

Instead of deleting, consider:
- **Archiving**: Add "archived" status field
- **Soft Delete**: Mark as deleted but keep data
- **Export**: Export patient data before deletion
- **Notes Backup**: Save notes separately if needed

### Legal Considerations

⚠️ **Medical Data Retention**:
- Check local regulations (GDPR, HIPAA, etc.)
- Medical records often have minimum retention periods
- Some jurisdictions prohibit deletion
- Consult legal counsel before implementing deletion

## 📊 Patient Statistics

View patient statistics on dashboard:
- Total patients
- Patients added this month
- Average age
- City distribution

## 🔐 Security & Privacy

### Access Control

- Login required to view/edit patients
- Role-based access (admin, doctor)
- Session timeout for security
- Audit logging (if implemented)

### Data Protection

- Passwords hashed (bcrypt)
- SQL injection protected (prepared statements)
- XSS protection (output escaping)
- HTTPS recommended for production

### GDPR Compliance

Consider implementing:
- Patient consent tracking
- Data export functionality
- Right to erasure (deletion)
- Access logs
- Data minimization
- Privacy policy acknowledgment

## 📱 Mobile Usage

All patient management features work on mobile:
- Responsive design adapts to screen size
- Touch-friendly buttons and inputs
- Swipeable tables
- Mobile-optimized forms
- Pull-to-refresh support

## 🔄 Bulk Operations

### Future Features

Consider implementing:
- **Bulk Import**: CSV/Excel import
- **Bulk Export**: Export multiple patients
- **Bulk Edit**: Update multiple records
- **Bulk Delete**: Delete multiple patients (with caution)
- **Bulk Print**: Print patient lists

### Export Formats

Potential export options:
- CSV (Excel compatible)
- PDF (printable)
- JSON (data interchange)
- XML (HL7 compatibility)

## 🎯 Best Practices

### Data Entry

1. **Be Consistent**
   - Use same format for all entries
   - Consistent capitalization
   - Standard abbreviations

2. **Verify Information**
   - Double-check email addresses
   - Verify phone numbers
   - Confirm dates of birth

3. **Complete Records**
   - Fill all available fields
   - Add notes for context
   - Update regularly

4. **Use Search First**
   - Check for duplicates before adding
   - Search by email or phone
   - Verify patient identity

### Data Quality

- Regular audits of patient data
- Update outdated information
- Remove duplicate entries
- Validate contact information
- Keep notes current

## 📚 Related Documentation

- [User Guide](User-Guide) - Complete user manual
- [Notes System](Notes-System) - Managing patient notes
- [Database Schema](Database-Schema) - Patient table structure
- [Security Guidelines](Security-Guidelines) - Data protection

## 🆘 Common Issues

### Can't save patient
- Check all required fields filled
- Verify email format (if provided)
- Check date of birth is valid
- See [Troubleshooting](Troubleshooting)

### Patient not appearing in list
- Check search/filter settings
- Clear search box
- Verify patient was saved
- Check database connection

### Duplicate patients
- Search before adding new patient
- Check for variations in name
- Compare dates of birth
- Merge duplicates manually

---

**Need more help?** Check the [User Guide](User-Guide) or [FAQ](FAQ).
