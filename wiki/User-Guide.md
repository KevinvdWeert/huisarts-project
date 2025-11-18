# User Guide

Complete guide for using the Huisarts Project medical practice management system.

## 🎯 Overview

The Huisarts Project is designed to help healthcare professionals manage patient records, notes, and appointments efficiently. This guide covers all features and workflows.

## 🔐 Logging In

### Accessing the System

1. Open your web browser
2. Navigate to your installation URL (e.g., `http://yourpractice.com`)
3. You'll be redirected to the login page

### Login Credentials

**Default Accounts** (Change passwords immediately after first login!):

- **Administrator**
  - Username: `admin`
  - Password: `password`
  - Access: Full system access

- **Doctor**
  - Username: `doctor`
  - Password: `password`
  - Access: Patient management

### First-Time Login

1. Enter your username and password
2. Click "Login" or press Enter
3. After successful login, you'll be directed to the dashboard
4. **Change your password immediately** via your profile settings

## 📊 Dashboard Overview

The dashboard provides a quick overview of your practice:

### Main Sections

1. **Quick Stats**
   - Total number of patients
   - Recent patient additions
   - Today's appointments
   - Pending tasks

2. **Recent Patients**
   - Last 10 patients added or modified
   - Quick access to patient records
   - Status indicators

3. **Quick Actions**
   - Add New Patient
   - Search Patients
   - View Appointments
   - Access Reports

4. **Notifications**
   - System alerts
   - Appointment reminders
   - Important updates

### Navigation Menu

The top navigation bar includes:
- **Home**: Return to dashboard
- **Patients**: Patient management
- **Notes**: Patient notes overview
- **About**: Practice information
- **Services**: Medical services offered
- **Contact**: Contact form
- **Profile**: User settings
- **Logout**: Sign out

## 👥 Patient Management

### Viewing Patients

#### Patient List View

1. Click **"Dashboard"** or **"Ga naar Dashboard"** from the home page
2. The patient list displays with the following information:
   - Patient Name
   - Date of Birth
   - Contact Information (Email, Phone)
   - Address
   - Last Updated Date

#### View Modes

Switch between two display modes:

**Table View** (Default)
- Compact, efficient data display
- Sortable columns
- Easy scanning of information

**Card View**
- Visual, card-based layout
- Better for browsing
- More whitespace

To switch: Click the **View** toggle button in the top-right

#### Sorting Patients

Click on column headers to sort:
- **Last Name** (A-Z or Z-A)
- **First Name** (A-Z or Z-A)
- **Date of Birth** (Oldest/Newest first)
- **City** (Alphabetical)
- **Created Date** (Newest/Oldest first)

### Searching Patients

#### Quick Search

1. Locate the search box at the top of the patient list
2. Enter search terms:
   - Name (first or last)
   - Email address
   - Phone number
   - City
   - Postal code
3. Results update automatically as you type
4. Clear search to view all patients

#### Search Tips

- **Partial matches work**: Searching "John" will find "Johnson" and "Johnny"
- **Case insensitive**: "SMITH" = "smith" = "Smith"
- **Multi-field search**: Searches across all patient fields simultaneously

### Adding a New Patient

1. **Navigate to Add Patient**:
   - From Dashboard: Click **"Nieuwe Patiënt"** or **"Add New Patient"**
   - From Patient List: Click **"Add Patient"** button

2. **Fill in Patient Information**:

   **Required Fields** (marked with *):
   - First Name *
   - Last Name *
   - Date of Birth *

   **Optional Fields**:
   - Email
   - Phone Number
   - Address
   - House Number
   - Postal Code
   - City

3. **Enter Contact Information**:
   - Email: Validated format (user@example.com)
   - Phone: Any format accepted

4. **Enter Address**:
   - Street Address
   - House Number
   - Postal Code
   - City

5. **Set Date of Birth**:
   - Use date picker or manual entry
   - Format: DD-MM-YYYY

6. **Save the Patient**:
   - Click **"Save Patient"** button
   - Confirmation message will appear
   - Redirected to patient details or list

#### Input Validation

The form validates:
- ✅ Required fields are filled
- ✅ Email format is correct
- ✅ Date of birth is valid
- ✅ No duplicate entries (optional check)

### Viewing Patient Details

1. From the patient list, click on a patient's name
2. Patient details page displays:
   - **Personal Information**
     - Full name
     - Date of birth and age
     - Contact information
   - **Address Information**
     - Complete address
     - City and postal code
   - **Administrative Data**
     - Patient ID
     - Registration date
     - Last updated date
   - **Quick Actions**
     - Edit Patient
     - Add Note
     - View Notes
     - Delete Patient

### Editing Patient Information

1. **Access Edit Form**:
   - From patient details: Click **"Edit"** button
   - From patient list: Click edit icon next to patient

2. **Modify Information**:
   - Update any fields as needed
   - All fields are editable
   - Changes are validated

3. **Save Changes**:
   - Click **"Update Patient"** button
   - Confirmation message appears
   - Changes reflect immediately

4. **Cancel Changes**:
   - Click **"Cancel"** to discard changes
   - Returns to previous page without saving

### Deleting a Patient

⚠️ **Warning**: Patient deletion is permanent and will also delete all associated notes.

1. **Initiate Deletion**:
   - From patient details: Click **"Delete Patient"** button
   - From edit page: Click **"Delete"** button

2. **Confirm Deletion**:
   - Confirmation dialog appears
   - Review patient information
   - Type patient name to confirm (if required)

3. **Complete Deletion**:
   - Click **"Confirm Delete"**
   - Patient and all associated data removed
   - Redirected to patient list

## 📝 Patient Notes

### Viewing Notes

1. **Access Patient Notes**:
   - From patient details: Click **"View Notes"** or **"Notes"** tab
   - From dashboard: Click **"Patient Notes"** menu item

2. **Notes Display**:
   - Chronological list (newest first)
   - Subject line
   - Note date
   - Snippet of note content
   - Author information
   - Last modified timestamp

### Adding a Note

1. **Open Note Form**:
   - From patient details: Click **"Add Note"**
   - From notes list: Click **"New Note"** button

2. **Fill Note Details**:
   - **Subject**: Brief description (required)
   - **Date**: Date of note (defaults to today)
   - **Note Content**: Detailed information (required)

3. **Save Note**:
   - Click **"Save Note"** button
   - Note appears in patient's note list
   - Confirmation message displayed

### Editing Notes

1. Click on note to view details
2. Click **"Edit"** button
3. Modify subject, date, or content
4. Click **"Update Note"** to save

### Deleting Notes

1. Open note details
2. Click **"Delete Note"** button
3. Confirm deletion
4. Note removed permanently

### Note Best Practices

- **Use Clear Subjects**: Make subjects descriptive
- **Date Accurately**: Use the correct consultation date
- **Be Comprehensive**: Include all relevant information
- **Regular Updates**: Keep notes current
- **Professional Language**: Maintain medical professionalism

## ⚙️ User Profile & Settings

### Accessing Profile

1. Click your username in the top-right corner
2. Select **"Profile"** or **"Settings"**

### Changing Password

1. Navigate to Profile Settings
2. Click **"Change Password"**
3. Enter:
   - Current Password
   - New Password
   - Confirm New Password
4. Password requirements:
   - Minimum 8 characters
   - At least one uppercase letter
   - At least one lowercase letter
   - At least one number
5. Click **"Update Password"**

### Updating Profile Information

- **Name**: Display name
- **Email**: Contact email
- **Language Preference**: Interface language
- **Notification Settings**: Email alerts, reminders

## 📄 Pagination & Results Per Page

### Changing Results Per Page

1. Locate the **"Per Page"** dropdown (top-right of list)
2. Select desired number:
   - 10 results
   - 25 results (default)
   - 50 results
   - 100 results
3. List updates automatically

### Navigating Pages

Use pagination controls at the bottom:
- **First**: Go to first page
- **Previous**: Go to previous page
- **Page Numbers**: Jump to specific page
- **Next**: Go to next page
- **Last**: Go to last page

Current page is highlighted.

## 🔍 Advanced Features

### Filtering Options

Some list views support filtering:
- **By Date Range**: Filter by registration date
- **By City**: Filter patients by location
- **By Status**: Active/Inactive patients

### Export Functions

Export patient data:
1. Select patients (if available)
2. Click **"Export"** button
3. Choose format:
   - CSV (Excel-compatible)
   - PDF (printable)
4. Download file

### Print Functions

Print patient lists or details:
1. Navigate to desired page
2. Use browser print (Ctrl+P / Cmd+P)
3. Optimized print layout applies automatically

## 📱 Mobile Usage

The system is fully responsive:

### Mobile Navigation

- **Hamburger Menu**: Access main navigation
- **Swipe Gestures**: Navigate between pages
- **Touch-Friendly**: Large tap targets
- **Responsive Tables**: Scroll horizontally if needed

### Mobile-Specific Features

- Simplified layouts for smaller screens
- Touch-optimized forms
- Quick action buttons
- Condensed information display

## 🔔 Notifications & Alerts

### Types of Notifications

- **Success Messages**: Confirmation of actions
- **Warning Messages**: Important information
- **Error Messages**: Issues requiring attention
- **Info Messages**: General information

### Notification Actions

- Automatically dismiss after few seconds
- Click to dismiss immediately
- Click for more details (if available)

## 🆘 Getting Help

### In-App Help

- **Tooltips**: Hover over elements for quick help
- **Help Icons**: Click for contextual help
- **Field Descriptions**: Explanations under form fields

### Contact Support

1. Click **"Contact"** in main menu
2. Fill out support form:
   - Name
   - Email
   - Subject
   - Detailed message
3. Submit form
4. Expect response within 24-48 hours

## ⌨️ Keyboard Shortcuts

Improve efficiency with keyboard shortcuts:

- **Ctrl/Cmd + K**: Quick search
- **Ctrl/Cmd + N**: New patient
- **Ctrl/Cmd + S**: Save form
- **Esc**: Close dialog/modal
- **Tab**: Navigate form fields
- **Enter**: Submit form

## 🔒 Security Tips

### Best Practices

1. **Change default password immediately**
2. **Use strong, unique passwords**
3. **Never share your login credentials**
4. **Log out when finished**
5. **Lock your computer when away**
6. **Use secure, private networks**
7. **Keep software updated**
8. **Report suspicious activity**

### Session Management

- Automatic logout after 1 hour of inactivity
- Warning appears 5 minutes before timeout
- Click anywhere to extend session

## 📚 Additional Resources

- **[FAQ](FAQ)**: Common questions and answers
- **[Troubleshooting](Troubleshooting)**: Solve common issues
- **[Patient Management](Patient-Management)**: Detailed patient management guide
- **[Notes System](Notes-System)**: Comprehensive notes documentation

---

**Need Help?** Contact your system administrator or check the [FAQ](FAQ).
