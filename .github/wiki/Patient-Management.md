# Patient Management

The Patient Management system allows healthcare professionals to manage patient records efficiently with full CRUD (Create, Read, Update, Delete) operations.

## Features Overview

### 📋 Patient List
- View all patients in card or table view
- Search by name, email, phone, or city
- Sort by any column (ascending/descending)
- Pagination (10, 25, 50, or 100 per page)
- Real-time search filtering

### ➕ Add New Patient
- Required fields: First name, Last name
- Optional fields: Address, phone, email, date of birth, city
- Form validation with error messages
- Automatic record timestamping

### ✏️ Edit Patient
- Update patient information
- View last update timestamp
- Validation ensures data integrity
- Success/error notifications

### 🗑️ Delete Patient
- Confirmation screen before deletion
- Shows patient details for review
- Cascading delete (removes associated notes)
- Transaction-safe deletion

### 📝 Patient Notes
- Add medical notes for each patient
- View note history with timestamps
- Edit or delete existing notes
- Track who created each note

## Dashboard Interface

### View Modes

#### Card View
- Visual card-based layout
- Shows patient avatar with initials
- Displays key information: age, contact, location
- Action buttons: Notes, Edit, Delete

#### Table View (Default)
- Compact tabular format
- Sortable columns
- Shows all patient data in rows
- Better for large datasets

### Search & Filter

**Search Box:**
- Type to filter patients
- Searches across multiple fields:
  - First name
  - Last name
  - Email
  - Phone number
  - City
- Real-time results
- Clear button to reset

**Sort Options:**
- Sort by: Last Name, First Name, Email, City
- Order: Ascending ↑ or Descending ↓
- Maintains search and pagination state

**Items Per Page:**
- Choose: 10, 25, 50, or 100 patients
- Setting persists across navigation
- Located in sidebar

## Adding a Patient

1. Click **"+ Nieuwe Patiënt"** in sidebar or header
2. Fill in required fields:
   - First name
   - Last name
3. Optional: Add contact info, address, DOB
4. Click **"Patiënt Toevoegen"**
5. Success message confirms creation
6. Redirects to patient list

**Validation Rules:**
- First/Last name: Required
- Email: Must be valid format
- Date of birth: Cannot be in future
- All text fields: Trimmed whitespace

## Editing a Patient

1. Click **"Bewerk"** button on patient card/row
2. Form pre-fills with current data
3. Modify desired fields
4. Click **"Wijzigingen Opslaan"**
5. Success message confirms update
6. Record shows new update timestamp

**Navigation:**
- Back to Dashboard
- View Notes
- Delete Patient

## Deleting a Patient

1. Click **"Verwijder"** button
2. Confirmation page displays:
   - Patient name and details
   - Number of associated notes
   - Warning about permanent deletion
3. Check confirmation checkbox
4. Click **"Ja, Verwijder Deze Patiënt"**
5. Success message on dashboard
6. Patient and notes removed from database

**Safety Features:**
- Two-step confirmation
- Shows full patient details
- Warns about note deletion
- Transaction-based (all-or-nothing)
- Option to edit instead

## Patient Notes

### Viewing Notes
1. Click **"Notities"** button on patient
2. View all notes chronologically
3. See who created each note and when

### Adding Notes
1. Click **"Nieuwe Notitie"** button
2. Enter note content (required)
3. Click **"Notitie Toevoegen"**
4. Note appears in list with timestamp

### Managing Notes
- Edit: Modify existing note content
- Delete: Remove note permanently
- Each note shows:
  - Creator's username
  - Creation date/time
  - Note content

## Statistics

The dashboard sidebar displays:
- **Total Patients**: Current patient count
- Auto-updates after add/delete operations

## Best Practices

### Data Entry
- Always verify patient information before saving
- Use consistent formatting for phone numbers
- Complete email addresses when possible
- Accurate date of birth for age calculations

### Search Tips
- Use partial names for broad searches
- Search by city to find local patients
- Combine with sorting for better results
- Clear search to return to full list

### Notes Management
- Add notes after each appointment
- Use clear, professional language
- Include relevant medical information
- Review note history before appointments

## Technical Details

### Database Tables
- `patients` - Patient records
- `notes` - Medical notes linked to patients
- Foreign key: `notes.patient_id → patients.patient_id`

### Security
- Authentication required for all operations
- Session-based access control
- SQL injection prevention via PDO
- XSS protection via htmlspecialchars()

### Performance
- Pagination prevents large data loads
- Indexed database columns for fast searches
- Prepared statements for efficiency
- Transaction-safe operations

## Troubleshooting

### Buttons Disappearing
- See [SVG Rendering Bug](SVG-Rendering-Bug)
- Ensure `whitespace-nowrap` is applied

### Search Not Working
- Check database connection
- Verify search parameter in URL
- Clear browser cache

### Cannot Delete Patient
- Check for database errors in logs
- Verify cascading delete permissions
- Ensure transaction support enabled

## Related Pages

- [Dashboard](Dashboard) - Dashboard overview
- [Search & Filter](Search-Filter) - Advanced search features
- [Database Schema](Database-Schema) - Database structure
