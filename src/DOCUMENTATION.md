# Portal Project Documentation

## Overview
This documentation provides a comprehensive guide to the folder and file structure of the Portal project, explaining the purpose of each file and subfolder. It also details the database schema found in `sql/portal.sql`, listing all tables and their columns.

---

## Folder & File Structure

```
portal/
│
├── app/
│   ├── app.js                # Main JavaScript logic for the app
│   └── service-worker.js     # Service worker for offline support/PWA
│
├── assets/
│   ├── css/
│   │   ├── all.min.css       # Minified CSS bundle
│   │   ├── bootstrap.min.css # Bootstrap framework styles
│   │   └── style.css         # Custom styles for the portal
│   ├── favicon/              # Favicon and icons for various devices
│   ├── fonts/
│   │   └── font-awesome.min.css # Font Awesome icons
│   └── js/
│       ├── bootstrap.bundle.min.js # Bootstrap JS bundle
│       ├── chart.js              # Chart.js library for charts
│       ├── checkin.js            # JS for check-in functionality
│       ├── jquery-3.6.0.min.js   # jQuery library
│       ├── main.js               # Main JS logic
│       └── modals.js             # JS for modal dialogs
│
├── bookshop/
│   ├── add-book.php          # Add new book to the shop
│   ├── login.php             # Bookshop login page
│   ├── logout.php            # Bookshop logout logic
│   └── view-books.php        # View available books
│
├── config/
│   ├── school-info.php       # School information configuration
│   ├── setup.php             # Initial setup/configuration
│   └── uploads/              # Uploaded files (e.g., photos)
│
├── controller/
│   ├── admin.php             # Admin-related logic
│   ├── assign_staff.php      # Assign staff to classes/roles
│   ├── checkin-code.php      # Check-in code generation/validation
│   ├── checkin-process.php   # Check-in process logic
│   ├── class.php             # Class management
│   ├── exam.php              # Exam management
│   ├── session.php           # Academic session management
│   ├── settings.php          # General settings
│   ├── staff.php             # Staff management
│   ├── student.php           # Student management
│   └── subject.php           # Subject management
│
├── includes/
│   └── database.php          # Database connection and utilities
│
├── logs/
│   ├── ad_error.log          # Admin error logs
│   ├── sd_error.log          # Student error logs
│   └── sf_error.log          # Staff error logs
│
├── public/
│   ├── admin/                # Admin dashboard and features
│   │   ├── add-admin.php
│   │   ├── admin-dashboard.php
│   │   ├── assign-staff.php
│   │   ├── attendance.php
│   │   ├── class-attendance.php
│   │   ├── delete.php
│   │   ├── fee-dashboard.php
│   │   ├── get_students.php
│   │   ├── notification.php
│   │   ├── results-upload.php
│   │   ├── settings.php
│   │   ├── staff.php
│   │   ├── students.php
│   │   ├── test.php
│   │   ├── view-attendance.php
│   │   ├── view.php
│   │   ├── fees/
│   │   │   ├── fee-collection.php
│   │   │   ├── fee-reminder.php
│   │   │   ├── fee-structure.php
│   │   │   └── transaction-history.php
│   │   └── include/
│   │       ├── header.php
│   │       ├── modals.php
│   │       └── side-bar.php
│   ├── staff/                # Staff dashboard and features
│   │   ├── attendance.php
│   │   ├── check-in.php
│   │   ├── delete.php
│   │   ├── mark-attendance.php
│   │   ├── notification.php
│   │   ├── results.php
│   │   ├── settings.php
│   │   ├── staff-dashboard.php
│   │   ├── upload.php
│   │   ├── view-students.php
│   │   ├── view.php
│   │   ├── include/
│   │   │   ├── header.php
│   │   │   ├── modals.php
│   │   │   └── side-bar.php
│   │   ├── result-directory/
│   │   └── result-upload/
│   ├── students/             # Student dashboard and features
│   │   ├── notification.php
│   │   ├── report.php
│   │   ├── setting.php
│   │   ├── settings.php
│   │   ├── student-dashboard.php
│   │   ├── view-result.php
│   │   └── include/
│   │       ├── header.php
│   │       └── side-bar.php
│
├── resultroom/
│   ├── 2024-2025 Fees Schedule.pdf # Fees schedule document
│   └── VIVOR OSCAR MAKAFUI(STD00001121) Report Sheet.pdf # Student report sheet
│
├── sql/
│   ├── GLP_installer_900223150_market.exe # Installer (not part of DB)
│   └── portal.sql                        # Database schema
│
├── src/
│   └── input.css                # Source CSS for Tailwind/PostCSS
│
├── templates/
│   ├── 404Error.php             # Custom 404 error page
│   ├── DOCUMENTATION.md         # Documentation file
│   ├── loader.php               # Loader/spinner template
│   └── uploads/                 # Uploaded images
│
├── DOCUMENTATION.md             # Main documentation file
├── index.php                    # Main login page and entry point
├── logout.php                   # Logout logic
├── manifest.json                # PWA manifest
├── package.json                 # Node.js dependencies
├── postcss.config.js            # PostCSS configuration
├── tailwind.config.js           # Tailwind CSS configuration
```

---

## File & Folder Explanations

### app/
- **app.js**: Main JavaScript logic for the portal, handles client-side interactions.
- **service-worker.js**: Enables offline support and caching for PWA features.

### assets/
- **css/**: Contains all CSS files (framework, custom, minified).
- **favicon/**: All favicon and icon files for browser and device compatibility.
- **fonts/**: Font Awesome CSS for icon support.
- **js/**: JavaScript libraries and custom scripts for UI, charts, modals, check-in, etc.

### bookshop/
- **add-book.php**: Form and logic to add new books.
- **login.php**: Bookshop login page.
- **logout.php**: Bookshop logout logic.
- **view-books.php**: Displays available books.

### config/
- **school-info.php**: School information settings.
- **setup.php**: Initial setup and configuration.
- **uploads/**: Uploaded files (e.g., photos).

### controller/
- **admin.php**: Handles admin operations.
- **assign_staff.php**: Assigns staff to classes/roles.
- **checkin-code.php**: Generates/validates check-in codes.
- **checkin-process.php**: Manages check-in process.
- **class.php**: Class management logic.
- **exam.php**: Exam management logic.
- **session.php**: Academic session management.
- **settings.php**: General settings logic.
- **staff.php**: Staff management logic.
- **student.php**: Student management logic.
- **subject.php**: Subject management logic.

### includes/
- **database.php**: Database connection and utility functions.

### logs/
- **ad_error.log**: Admin error logs.
- **sd_error.log**: Student error logs.
- **sf_error.log**: Staff error logs.

### public/
- **admin/**: Admin dashboard and features (attendance, fees, notifications, etc.).
- **staff/**: Staff dashboard and features (attendance, results, uploads, etc.).
- **students/**: Student dashboard and features (results, notifications, reports, etc.).

### resultroom/
- **2024-2025 Fees Schedule.pdf**: Fees schedule document.
- **VIVOR OSCAR MAKAFUI(STD00001121) Report Sheet.pdf**: Student report sheet.

### sql/
- **GLP_installer_900223150_market.exe**: Installer (not part of DB).
- **portal.sql**: Database schema and table definitions.

### src/
- **input.css**: Source CSS for Tailwind/PostCSS.

### templates/
- **404Error.php**: Custom 404 error page.
- **DOCUMENTATION.md**: Documentation file.
- **loader.php**: Loader/spinner template.
- **uploads/**: Uploaded images.

### Root Files
- **DOCUMENTATION.md**: Main documentation file.
- **index.php**: Main login page and entry point.
- **logout.php**: Logout logic.
- **manifest.json**: PWA manifest.
- **package.json**: Node.js dependencies.
- **postcss.config.js**: PostCSS configuration.
- **tailwind.config.js**: Tailwind CSS configuration.

---

## Database Schema (`sql/portal.sql`)

Below are the tables and columns required for the portal. Each table is listed with all its columns:

### administrator
- admin_id (PK)
- username
- password
- email
- full_name
- phone
- created_at

### students
- student_id (PK)
- username
- password
- email
- full_name
- gender
- dob
- address
- phone
- class_id (FK)
- photo
- created_at

### staff
- staff_id (PK)
- username
- password
- email
- full_name
- gender
- dob
- address
- phone
- role
- photo
- created_at

### class
- class_id (PK)
- class_name
- section
- created_at

### subject
- subject_id (PK)
- subject_name
- class_id (FK)
- teacher_id (FK)
- created_at

### exam
- exam_id (PK)
- exam_name
- class_id (FK)
- subject_id (FK)
- date
- total_marks
- created_at

### results
- result_id (PK)
- student_id (FK)
- exam_id (FK)
- marks_obtained
- grade
- remarks
- created_at

### attendance
- attendance_id (PK)
- student_id (FK)
- class_id (FK)
- date
- status
- recorded_by (FK to staff_id)
- created_at

### fees
- fee_id (PK)
- student_id (FK)
- amount
- due_date
- status
- paid_date
- recorded_by (FK to staff_id)
- created_at

### notifications
- notification_id (PK)
- title
- message
- recipient_id (FK to student_id or staff_id)
- recipient_type (student/staff/admin)
- created_at

### checkin
- checkin_id (PK)
- code
- student_id (FK)
- date
- status
- recorded_by (FK to staff_id)
- created_at

### settings
- setting_id (PK)
- key
- value
- updated_at

---

## Notes
- PK = Primary Key
- FK = Foreign Key
- All tables include `created_at` for record tracking.
- The schema supports admin, staff, student, class, subject, exam, results, attendance, fees, notifications, check-in, and settings management.

---

For further details, refer to the individual PHP files and the SQL schema in `sql/portal.sql`.
