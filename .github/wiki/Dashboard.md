# Dashboard

The Dashboard is the central hub of the Medical Practice Management System where you manage all patient records.

## Overview

The dashboard features a modern sidebar layout with two view modes, advanced search capabilities, and comprehensive patient management tools.

## Layout Structure

```
┌─────────────────────────────────────────────────┐
│ Header (Logo, Navigation, User Menu)           │
├──────────┬──────────────────────────────────────┤
│          │                                      │
│ Sidebar  │  Main Content Area                   │
│          │                                      │
│ • Stats  │  • Search Bar                        │
│ • Add    │  • View Toggle                       │
│ • Views  │  • Sort Options                      │
│ • Sort   │  • Patient Cards/Table               │
│ • Items  │  • Pagination                        │
│          │  • Footer                            │
│          │                                      │
└──────────┴──────────────────────────────────────┘
```

## Sidebar Features

### User Profile
- Avatar with user initials
- Username display
- Role badge (Admin/Doctor/Nurse)

### Statistics
- **Total Patients**: Live count of all patients
- Updates automatically after add/delete

### Quick Actions
- **+ Nieuwe Patiënt**: Add new patient
- Direct link to add patient form

### View Mode Toggle
- **Cards View**: Visual grid layout
- **Table View**: Compact list (default)
- Click icons to switch

### Sort Options
Sort by:
- Last Name
- First Name
- Email
- City

Order:
- Ascending ↑
- Descending ↓

### Items Per Page
Choose display count:
- 10 patients
- 25 patients (default)
- 50 patients
- 100 patients

Grid of 4 buttons (2×2)  
Active selection highlighted in blue

## Main Content Area

### Search Bar
- **Placeholder**: "Zoek op naam, email, telefoon..."
- **Live Search**: Results filter as you type
- **Clear Button**: Reset search (×)
- **Search Icon**: Visual indicator

Searches across:
- First name
- Last name
- Email address
- Phone number
- City

### View Toggle (Top Right)
- Card icon for card view
- List icon for table view
- Active view highlighted

### Empty State
When no patients found:
- User icon (gray)
- Message: "Geen patiënten gevonden"
- Subtext: Search tips or add patient prompt

## Card View

### Card Layout
Each patient card displays:

**Header:**
- Avatar circle with initials
- Gradient background (blue to purple)

**Patient Name:**
- Full name in bold
- Large, readable font

**Age Badge:**
- Calculated from date of birth
- Format: "X jaar"
- Gray badge with pill shape

**Contact Information:**
- 📧 Email icon + address
- 📱 Phone icon + number
- 📍 Location icon + city

**Action Buttons:**
- **Notities**: Blue button (view/add notes)
- **Bewerk**: Green button (edit patient)
- **🗑️**: Red button (delete patient)

### Card Grid
- Responsive columns
- Auto-adjusts to screen size
- Even spacing between cards
- Hover effects on cards

## Table View

### Table Structure

| Column | Description | Features |
|--------|-------------|----------|
| Naam | Patient name + avatar | Sortable, with initials |
| Leeftijd | Calculated age | Shows "X jaar" |
| Contact | Email + phone | Truncated if long |
| Plaats | City name | Sortable |
| Acties | Action buttons | Fixed width (w-72) |

### Table Features
- **Hover Effect**: Row highlights on mouse over
- **Sortable Headers**: Click to sort (if implemented)
- **Fixed Column Widths**: Prevents layout shifts
- **Horizontal Scroll**: On small screens
- **Whitespace Control**: `whitespace-nowrap` prevents wrapping

### Action Buttons (Table)
- **Notities**: Blue badge
- **Bewerk**: Green badge
- **Verwijder**: Red badge

All buttons:
- Small size (text-xs)
- Rounded corners
- Hover color change
- Consistent spacing

## Pagination

Appears when total pages > 1

**Components:**
- **Vorige** (Previous): Navigate back
- **Page Indicator**: "Pagina X van Y"
- **Volgende** (Next): Navigate forward

**Behavior:**
- Previous disabled on page 1
- Next disabled on last page
- Maintains search/sort/view state
- Includes per_page parameter

## Search Functionality

### How It Works
1. User types in search box
2. Form submits on Enter or button click
3. Server searches database:
   ```sql
   WHERE (first_name LIKE '%term%' OR 
          last_name LIKE '%term%' OR 
          email LIKE '%term%' OR 
          phone LIKE '%term%' OR 
          city LIKE '%term%')
   ```
4. Results display immediately
5. Search term preserved in URL
6. Clear button removes filter

### Search Tips
- **Partial Matches**: "jan" finds "Jan Jansen"
- **Case Insensitive**: "SMITH" finds "Smith"
- **Multiple Fields**: Searches all at once
- **Reset**: Click × or clear input

## Sorting

### Sort Behavior
- Click sort dropdown in sidebar
- Choose field and order
- Page reloads with sorted results
- Sort state in URL: `?sort=last_name&order=asc`
- Maintains search and pagination
- Default: Last Name Ascending

### Available Sort Fields
- **Last Name**: Alphabetical by surname
- **First Name**: Alphabetical by given name
- **Email**: Alphabetical by email address
- **City**: Alphabetical by location

### Sort Orders
- **Ascending (↑)**: A-Z, 0-9
- **Descending (↓)**: Z-A, 9-0

## View Modes Comparison

### When to Use Card View
✅ Browsing patients visually  
✅ Mobile/touch devices  
✅ Less than 25 patients  
✅ Need to see contact info quickly  
✅ Prefer visual layout

### When to Use Table View
✅ Many patients (50+)  
✅ Desktop/large screens  
✅ Need to compare data  
✅ Sorting by multiple columns  
✅ Prefer compact layout

## URL Parameters

Dashboard uses these GET parameters:

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `view` | string | Display mode | `cards` or `table` |
| `page` | integer | Current page | `1`, `2`, `3` |
| `per_page` | integer | Items per page | `10`, `25`, `50`, `100` |
| `sort` | string | Sort field | `last_name`, `email` |
| `order` | string | Sort order | `asc` or `desc` |
| `search` | string | Search term | `john`, `smith` |

**Example URL:**
```
dashboard.php?view=table&page=2&per_page=50&sort=last_name&order=asc&search=jan
```

## Responsive Behavior

### Mobile (< 768px)
- Sidebar collapses (if implemented)
- Card view recommended
- Single column cards
- Touch-friendly buttons
- Larger tap targets

### Tablet (768px - 1024px)
- Sidebar visible
- 2-column card grid
- Table view scrolls horizontally
- Medium button sizes

### Desktop (> 1024px)
- Full sidebar always visible
- 3-4 column card grid
- Table view optimal
- Hover states active

## Performance Optimization

### Pagination
- Loads only `per_page` records
- Reduces database load
- Faster page renders
- Adjustable by user

### Prepared Statements
- SQL injection prevention
- Query caching
- Improved performance

### Indexed Columns
- Fast searches on:
  - `last_name`
  - `email`
  - `city`
- Database indexes speed up queries

## Keyboard Shortcuts (Future)

Planned shortcuts:
- `Ctrl + K`: Focus search
- `Ctrl + N`: New patient
- `Escape`: Close modals
- `Arrow Keys`: Navigate cards
- `/`: Focus search

## Accessibility

### Current Features
- Semantic HTML
- Proper heading hierarchy
- Alt text on icons (where applicable)
- Color contrast ratios

### Future Enhancements
- ARIA labels
- Keyboard navigation
- Screen reader support
- Focus indicators

## Troubleshooting

### Buttons Disappearing
**Cause**: SVG rendering bug or layout issues  
**Solution**: See [SVG Rendering Bug](SVG-Rendering-Bug)

### Search Not Working
**Cause**: Database connection or query error  
**Solution**:
1. Check database connection
2. Verify search term in URL
3. Check error logs

### Pagination Broken
**Cause**: Lost URL parameters  
**Solution**:
1. Ensure all links include parameters
2. Check page calculation logic
3. Verify `$total_pages` value

### Slow Loading
**Cause**: Too many records or missing indexes  
**Solution**:
1. Reduce `per_page` value
2. Add database indexes
3. Optimize queries

## Best Practices

### For Users
- Use table view for large datasets
- Adjust `per_page` to your preference
- Use search for quick access
- Sort by last name for easy scanning

### For Developers
- Always maintain URL parameters
- Use prepared statements
- Validate `per_page` values
- Handle empty states gracefully

## Related Documentation

- [Patient Management](Patient-Management) - Feature details
- [Search & Filter](Search-Filter) - Advanced search
- [Database Schema](Database-Schema) - Data structure
- [Architecture](Architecture) - System design
