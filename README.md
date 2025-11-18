# School Management Portal

A modern, responsive web-based school management system built with PHP, Tailwind CSS, and JavaScript. Designed for administrators, staff, and students with comprehensive features for academic management, attendance tracking, fee management, and more.
---
## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Key Components](#key-components)
- [Recent Enhancements](#recent-enhancements)
- [Installation & Setup](#installation--setup)
- [Usage](#usage)
- [Database](#database)
- [Authentication](#authentication)
- [UI/UX Highlights](#uiux-highlights)
- [Contributing](#contributing)

---

## 🎯 Overview

This is a comprehensive school management portal that streamlines administrative tasks, facilitates staff operations, and provides students with easy access to their academic information. The system features modern UI design with dark mode support, responsive layouts, and progressive web app (PWA) capabilities.

**Institution**: Royal Websters Academy

---

## ✨ Features

### Admin Dashboard
- 👥 Staff and student management
- 📊 Attendance tracking and reporting
- 💰 Fee collection and management
- 📄 Student promotion and results administration
- 📧 Notification system
- 🎓 Class and subject management
- ⚙️ System settings and configuration

### Staff Features
- ✅ Mark student attendance (class and individual)
- 📈 Upload and manage student results
- 🎬 Check-in system with QR codes
- 👓 View assigned students
- 📢 Send notifications to students
- 📋 Terminal report sheet generation with PDF export
- 📊 View class statistics and performance

### Student Portal
- 📖 View academic results
- 🔍 **PDF Result Preview** (in-page viewer)
- 📥 Download result PDFs
- 📧 View notifications
- ⚙️ Profile and account settings
- 📱 Responsive mobile design

### General Features
- 🔐 Role-based access control (Admin/Staff/Student)
- 🌓 Dark mode support across all pages
- 📱 Fully responsive design (mobile, tablet, desktop)
- 🔔 Real-time notifications
- 📊 Automated grade calculation and remarks
- 🎓 Attendance tracking
- 💾 LocalStorage data persistence
- 🚀 Progressive Web App (PWA) support

---

## 🛠 Technology Stack

### Backend
- **PHP 7.4+** - Server-side logic
- **MySQL** - Database management
- **Session Management** - User authentication

### Frontend
- **Tailwind CSS** - Utility-first CSS framework
- **Vanilla JavaScript** - Client-side interactivity
- **Alpine.js** - Lightweight JavaScript framework (optional)
- **Font Awesome 6.0+** - Icon library
- **Bootstrap** - Component framework

### PDF & Image Processing
- **html2canvas** - HTML to Canvas conversion
- **jsPDF** - PDF generation
- **PDF.js** - PDF rendering and viewing

### Build Tools
- **PostCSS** - CSS processing
- **Tailwind CSS CLI** - Utility generation

---

## 📁 Project Structure

```
portal/
├── index.php                 # Login entry point
├── logout.php               # Logout handler
├── manifest.json            # PWA manifest
├── package.json             # Dependencies
├── tailwind.config.js       # Tailwind configuration
├── postcss.config.js        # PostCSS configuration
│
├── app/                     # App logic & PWA
│   ├── app.js
│   └── service-worker.js
│
├── assets/                  # Static assets
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript libraries
│   ├── fonts/               # Font files
│   └── favicon/             # App icons
│
├── config/                  # Configuration files
│   ├── school-info.php
│   └── setup.php
│
├── controller/              # Business logic controllers
│   ├── admin.php
│   ├── staff.php
│   ├── student.php
│   ├── attendance.php
│   ├── exam.php
│   └── ...
│
├── includes/                # Shared includes
│   ├── database.php         # DB connection
│   └── logger.php           # Error logging
│
├── public/                  # Public-facing pages
│   ├── admin/               # Admin dashboard & pages
│   ├── staff/               # Staff pages (including results.php)
│   └── students/            # Student dashboard & pages
│
├── resultroom/              # Generated PDFs & reports
│
├── sql/                     # Database files
│   └── portal.sql
│
├── templates/               # General templates
│   ├── 404Error.php
│   └── DOCUMENTATION.md
│
└── README.md               # This file
```

---

## 🔑 Key Components

### Student Dashboard Pages
All pages feature modern UI with Tailwind CSS, dark mode support, and responsive design:

- **student-dashboard.php** - Overview with quick actions and statistics
- **view-result.php** - Results list with PDF preview modal and download options
- **notification.php** - Numbered notification cards with formatting
- **settings.php / setting.php** - Profile and password management

### Staff Pages
- **results.php** - Terminal report sheet generator with:
  - Multi-student workflow
  - Automatic grade & aggregate calculation
  - PDF generation with professional template
  - LocalStorage data persistence
  - Student auto-selection from class roster
  
- **upload.php** - Result file upload with drag-drop and progress tracking

### Authentication
- Role-based login (Admin/Staff/Student)
- Session management
- Secure logout

---

## 🎨 Recent Enhancements

### 1. **Modern UI Redesign** ✨
- Applied Tailwind CSS gradient system across all student pages
- Implemented dark mode support with proper contrast
- Created responsive card-based layouts
- Added Font Awesome icons throughout

### 2. **PDF Result Preview** 🔍
- Added in-page PDF viewer using PDF.js
- Students can preview results before downloading
- Includes:
  - Page navigation (Previous/Next)
  - Zoom In/Out controls
  - Direct download from preview modal
  - Keyboard shortcuts (arrow keys, ESC)

### 3. **Report Sheet Generator** 📊
- Professional terminal report sheet creation
- Features:
  - Multi-student batch processing
  - Automatic student selection from class
  - Auto-calculation of grades and remarks
  - Academic aggregate calculation (core + best 2 electives)
  - Professional PDF template with:
    - School header with logo
    - Student information grid
    - Subject scores table
    - Behavioral assessment
    - Teacher remarks section
    - Dual signature blocks with dates
    - Confidentiality footer

### 4. **Smart Student Selection** 🎓
- Dropdown populated with students from staff's assigned class
- Automatic Student ID population
- Prevents manual entry errors
- Seamless multi-student workflow

### 5. **Enhanced File Upload** 📤
- Drag-and-drop file input
- File preview with type detection
- Progress indicators
- Professional error handling
- Process step visualization

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx web server
- XAMPP or equivalent (for local development)

### Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/vivor-oscar/schoolmanagement.git
   cd portal
   ```

2. **Database Setup**
   ```bash
   # Import the SQL dump
   mysql -u root -p < sql/portal.sql
   ```

3. **Place in Web Root**
   ```bash
   # For XAMPP
   cp -r portal C:\xampp\htdocs\
   ```

4. **Access the Portal**
   - Navigate to: `http://localhost/portal/`
   - Use default credentials (set during setup)

---

## 💻 Usage

### Admin Login
1. Visit the portal homepage
2. Select "Admin" role
3. Enter credentials
4. Access admin dashboard with all management features

### Staff Login
1. Select "Staff" role
2. Enter credentials
3. Access staff dashboard
4. Generate report sheets, upload results, track attendance

### Student Login
1. Select "Student" role
2. Enter credentials
3. View results with preview functionality
4. Check notifications and manage settings

---

## 🗄 Database

**SQL Dump**: `sql/portal.sql`

---

## 🔐 Authentication

### Flow
1. User submits credentials via login form
2. System verifies against database
3. Role-based session established
4. User redirected to role-specific dashboard
5. Session used for authorization checks

### Security Features
- Password hashing
- Session validation
- CSRF token support
- SQL injection prevention (parameterized queries)

---

## 🎨 UI/UX Highlights

### Design System
- **Color Scheme**: Gradient-based (Blue, Purple, Emerald, Orange)
- **Typography**: Roboto font family
- **Spacing**: Tailwind CSS spacing scale
- **Icons**: Font Awesome 6.0+

### Responsive Breakpoints
- **Mobile**: 320px - 640px
- **Tablet**: 641px - 1024px
- **Desktop**: 1025px+

### Dark Mode
- Automatic detection of system preference
- Manual toggle support
- Proper contrast ratios (WCAG AA)
- Consistent styling across all pages

### Accessibility
- Semantic HTML structure
- ARIA labels where appropriate
- Keyboard navigation support
- Color-independent information

---

## 📧 Contact & Support

**Project Owner**: Vivor Oscar
**Website**: www.infinititechub.unaux.com
**WhatsApp**: +233533519466
**Email**: oscarvivor@gmail.com

For issues, feature requests, or documentation questions, please visit the GitHub repository.

---

## 📜 License

This project is part of the school management initiative. All rights reserved.

---

## 🎓 Acknowledgments

- **Tailwind CSS** - For the amazing utility-first CSS framework
- **Font Awesome** - For the comprehensive icon library
- **PDF.js** - For reliable PDF rendering
- **Royal Websters Academy** - For the partnership

---

**Last Updated**: November 17, 2025
**Version**: 2.0 (Modern UI & Enhanced Features)
