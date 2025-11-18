# Notes System

Complete guide to the patient notes system in the Huisarts Project.

## 📝 Overview

The notes system allows healthcare professionals to document consultations, treatments, observations, and any medical information related to patient care. Each note is linked to a specific patient and user (author).

## 🎯 Features

- **Unlimited Notes**: Add as many notes as needed per patient
- **Chronological Display**: Notes sorted by date (newest first)
- **Rich Information**: Subject, date, detailed text, author tracking
- **Full CRUD**: Create, Read, Update, Delete operations
- **Search & Filter**: Find specific notes quickly
- **Timestamps**: Automatic creation and modification tracking
- **Author Attribution**: Track which user created each note

## 📋 Accessing Notes

### From Patient Details

1. Navigate to patient details page
2. Click **"View Notes"** or **"Notes"** tab
3. All notes for that patient display

### From Notes Page

1. Click **"Patient Notes"** in main menu
2. Select patient from list
3. View all notes for selected patient

### From Dashboard

- Recent notes widget (if implemented)
- Quick access to patients with recent notes

## ➕ Adding a Note

### Step-by-Step Process

1. **Navigate to Patient Notes**
   - From patient details: Click **"Add Note"** button
   - From notes list: Click **"New Note"** button

2. **Fill Note Fields**
   
   **Subject (Required)**
   - Brief description of note
   - Max 200 characters
   - Examples:
     - "Initial Consultation"
     - "Follow-up Visit"
     - "Lab Results Review"
     - "Treatment Plan Update"

   **Note Date (Required)**
   - Date of consultation/observation
   - Defaults to today
   - Can set past or future date
   - Format: DD-MM-YYYY or use date picker

   **Note Content (Required)**
   - Detailed medical information
   - Unlimited length
   - Support for:
     - Symptoms
     - Diagnosis
     - Treatment plans
     - Prescriptions
     - Test results
     - Observations
     - Follow-up instructions

3. **Save Note**
   - Click **"Save Note"** button
   - Validation checks:
     - Subject not empty
     - Note date valid
     - Content not empty
   - Success message appears
   - Note added to patient's note list

### Note Writing Tips

**Be Clear and Concise**:
```
Subject: Annual Physical Examination
Date: 15-11-2024
Content:
- Vital Signs: BP 120/80, HR 72, Temp 36.8°C
- Weight: 75kg, Height: 178cm, BMI: 23.7
- General: Good health, no complaints
- Cardiovascular: Regular rhythm, no murmurs
- Respiratory: Clear lungs
- Plan: Routine lab work ordered
- Follow-up: 6 months or as needed
```

**Use Structured Format**:
```
Subject: Cold Symptoms
Date: 10-11-2024
Content:
Chief Complaint: Cough and congestion for 3 days

Symptoms:
- Productive cough
- Nasal congestion
- Mild fever (37.8°C)
- No shortness of breath

Assessment: Upper respiratory infection

Treatment:
- Rest and fluids
- OTC decongestant
- Paracetamol for fever

Follow-up: Return if symptoms worsen or persist > 7 days
```

**Document Thoroughly**:
- Include all relevant information
- Note any changes from previous visits
- Record patient's concerns
- Document patient education provided
- Note follow-up plan

## 📖 Viewing Notes

### Notes List Display

Each note shows:
- **Subject**: Brief description
- **Date**: Date of consultation/note
- **Snippet**: First 100 characters of content
- **Author**: Username of note creator
- **Created**: When note was created
- **Updated**: Last modification time
- **Actions**: Edit and Delete buttons

### Chronological Order

Notes display by **note_date** (newest first):
- Today's notes at top
- Yesterday's notes next
- Older notes follow
- Future dates (scheduled) at top

### Full Note View

Click on note to see:
- Complete subject
- Full note date
- Entire note content
- Author information
- Creation timestamp
- Last update timestamp
- Edit and Delete options

### Note Details Page

Access by clicking note subject or title:
```
Subject: Follow-up Visit
Note Date: 15-11-2024
Author: Dr. Smith
Created: 15-11-2024 14:32:15
Last Updated: 15-11-2024 14:35:21

Content:
[Full note content displays here]

[Edit Button] [Delete Button] [Back to List]
```

## ✏️ Editing Notes

### Edit Process

1. **Open Note for Editing**
   - From notes list: Click **"Edit"** button
   - From note details: Click **"Edit Note"**

2. **Modify Fields**
   - **Subject**: Update if needed
   - **Date**: Change if incorrect
   - **Content**: Modify or add information
   - All fields editable

3. **Save Changes**
   - Click **"Update Note"** button
   - Validation applied
   - `updated_at` timestamp automatically set
   - Success message confirms update

4. **Cancel Editing**
   - Click **"Cancel"** to discard changes
   - Returns to previous page
   - No changes saved

### Edit Best Practices

**When to Edit**:
- Correct errors or typos
- Add forgotten information
- Clarify unclear statements
- Update incomplete information

**When NOT to Edit**:
- For new information (add new note instead)
- To hide mistakes (medical-legal reasons)
- After significant time has passed

**Consider Instead**:
- Add addendum note: "Addendum to [date] note: ..."
- Create follow-up note with references
- Maintain audit trail of changes

### Audit Trail

Notes track:
- `created_at`: Original creation time
- `updated_at`: Last modification time
- `user_id`: Original author

**Consider implementing**:
- Edit history table
- Track who made edits
- Log all changes
- Show modification history

## 🗑️ Deleting Notes

### ⚠️ Warning

**Note deletion is permanent**:
- Cannot be undone
- No built-in recovery
- Medical-legal implications
- Consider alternatives

### Deletion Process

1. **Initiate Deletion**
   - From notes list: Click **"Delete"** button
   - From note details: Click **"Delete Note"**

2. **Confirm Deletion**
   - Confirmation dialog appears
   - Review note content
   - Confirm you want to delete

3. **Complete Deletion**
   - Click **"Confirm Delete"**
   - Note removed from database
   - Success message appears
   - Return to notes list

### Alternatives to Deletion

Instead of deleting, consider:

**1. Edit to Clarify**
```
[CORRECTION] Original note stated X, should be Y.
```

**2. Add Corrective Note**
```
Subject: Correction to [Date] Note
Content: The note dated [date] incorrectly stated [X]. 
The correct information is [Y].
```

**3. Archive System**
- Add "archived" status field
- Hide from normal view
- Keep for legal compliance
- Searchable if needed

**4. Soft Delete**
- Add "deleted" flag
- Mark as deleted but keep data
- Allow restoration if needed
- Maintain audit trail

## 🔍 Searching Notes

### Basic Search

Search within patient's notes:
- By subject
- By date range
- By keywords in content
- By author

### Advanced Search (Future Enhancement)

Potential features:
- Full-text search across all notes
- Search by diagnosis code
- Search by medication name
- Search by date range
- Filter by author
- Tag-based search

### Full-Text Search Example

```sql
-- Add full-text index
ALTER TABLE notes ADD FULLTEXT(subject, text);

-- Search notes
SELECT * FROM notes 
WHERE patient_id = ? 
  AND MATCH(subject, text) AGAINST(? IN NATURAL LANGUAGE MODE)
ORDER BY note_date DESC;
```

## 📊 Notes Statistics

Track useful metrics:
- Total notes per patient
- Notes this month
- Average notes per patient
- Most active users
- Notes by type (if categorized)

## 🎨 Formatting Notes

### Current Support

Basic text entry:
- Plain text
- Line breaks preserved
- No HTML formatting

### Potential Enhancements

**Rich Text Editor**:
- Bold, italic, underline
- Lists (bulleted, numbered)
- Headers and subheaders
- Tables for test results
- Links to external resources

**Markdown Support**:
```markdown
# Follow-up Visit

## Symptoms
- Cough: Improved
- Fever: Resolved

## Plan
1. Continue medication
2. Follow-up in 2 weeks
```

**Template System**:
- Pre-defined note templates
- Common visit types
- Specialty-specific templates
- Customizable fields

## 📎 File Attachments (Future Feature)

Potential capability:
- Attach images (X-rays, photos)
- Attach PDFs (lab reports, referrals)
- Attach documents (consent forms)

Implementation considerations:
- File storage location
- File size limits
- Security and privacy
- File type restrictions
- Virus scanning

## 🔐 Security & Privacy

### Access Control

- Login required to view notes
- Only view notes for accessible patients
- Role-based permissions
- Audit logging recommended

### Data Protection

- Encrypted storage recommended
- Secure transmission (HTTPS)
- Regular backups
- Retention policies
- GDPR/HIPAA compliance

### Medical-Legal Considerations

**Documentation Standards**:
- Date all entries
- Sign electronically (user_id)
- Never alter after signing
- Corrections via addendum
- Maintain chronological order
- Keep permanently or per regulations

**Best Practices**:
- Objective and factual
- Professional language
- Complete and accurate
- Timely documentation
- Clear and legible
- Avoid abbreviations (or use standard ones)

## 📱 Mobile Usage

Notes system is mobile-friendly:
- Responsive design
- Touch-optimized inputs
- Swipeable lists
- Mobile keyboard support
- Voice input (device dependent)

### Mobile Tips

- Use landscape for longer notes
- Take advantage of autocorrect
- Save frequently
- Use note templates
- Dictation for longer entries

## 🔄 Integration Ideas

### Future Enhancements

**Electronic Health Records (EHR)**:
- HL7 message format
- FHIR API integration
- Standard terminology (SNOMED, ICD-10)

**Prescription System**:
- Link prescriptions to notes
- E-prescribing integration
- Medication reconciliation

**Lab Results**:
- Import lab results
- Link to relevant notes
- Trend analysis

**Appointment System**:
- Link notes to appointments
- Pre-visit notes
- Post-visit summaries

## 📚 Related Documentation

- [Patient Management](Patient-Management) - Managing patients
- [User Guide](User-Guide) - Complete user manual
- [Database Schema](Database-Schema) - Notes table structure
- [Security Guidelines](Security-Guidelines) - Data protection

## 🆘 Common Issues

### Can't save note
- Check all required fields filled
- Verify note date is valid
- Ensure patient exists
- Check database connection

### Note not appearing
- Refresh the page
- Check sort order
- Verify note was saved
- Check for error messages

### Lost note content
- Browser back button may lose data
- Use Save Draft feature (if available)
- Save frequently while typing
- Consider auto-save implementation

---

**Need more help?** Check the [User Guide](User-Guide) or [FAQ](FAQ).
