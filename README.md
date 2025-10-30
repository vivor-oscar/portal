# Portal Project Documentation

## Files and Folder Structure

```
DOCUMENTATION.md
index.php
logout.php
manifest.json
package.json
postcss.config.js
tailwind.config.js
app/
	app.js
	service-worker.js
assets/
	css/
		all.min.css
		bootstrap.min.css
		style.css
	favicon/
		android-chrome-192x192.png
		android-chrome-512x512.png
		apple-touch-icon.png
		favicon-16x16.png
		favicon-32x32.png
		favicon.ico
		site.webmanifest
	fonts/
		font-awesome.min.css
	js/
		bootstrap.bundle.min.js
		chart.js
		checkin.js
		jquery-3.6.0.min.js
		main.js
		modals.js
bookshop/
	add-book.php
	login.php
	logout.php
	view-books.php
config/
	school-info.php
	setup.php
	uploads/
		photo.jpg
controller/
	admin.php
	assign_staff.php
	checkin-code.php
	checkin-process.php
	class.php
	exam.php
	session.php
	settings.php
	staff.php
	student.php
	subject.php
includes/
	database.php
logs/
	ad_error.log
	sd_error.log
	sf_error.log
public/
	admin/
		add-admin.php
		admin-dashboard.php
		assign-staff.php
		attendance.php
		class-attendance.php
		delete.php
		fee-dashboard.php
		get_students.php
		notification.php
		results-upload.php
		settings.php
		staff.php
		students.php
		test.php
		view-attendance.php
		view.php
		fees/
			fee-collection.php
			fee-reminder.php
			fee-structure.php
			transaction-history.php
		include/
			header.php
			modals.php
			side-bar.php
	staff/
		attendance.php
		check-in.php
		delete.php
		mark-attendance.php
		notification.php
		results.php
		settings.php
		staff-dashboard.php
		upload.php
		view-students.php
		view.php
		include/
			header.php
			modals.php
			side-bar.php
		result-directory/
		result-upload/
	students/
		notification.php
		report.php
		setting.php
		settings.php
		student-dashboard.php
		view-result.php
		include/
			header.php
			side-bar.php
resultroom/
	2024-2025 Fees Schedule.pdf
	VIVOR OSCAR MAKAFUI(STD00001121) Report Sheet.pdf
sql/
	GLP_installer_900223150_market.exe
	portal.sql
src/
	input.css
templates/
	404Error.php
	DOCUMENTATION.md
	loader.php
	uploads/
		photo.jpg
		photo.png
```

## Overview
This portal is a web-based management system designed for schools, featuring modules for administrators, staff, and students. It provides functionalities such as login authentication, bookshop management, attendance tracking, fee management, notifications, and result viewing.

## Project Structure

- **index.php**: Main entry point and login handler for all user roles.
- **logout.php**: Handles user logout.
- **manifest.json**: Web app manifest for PWA support.
- **package.json**: Project dependencies and scripts.
- **postcss.config.js / tailwind.config.js**: CSS build configuration.

### Key Folders
- **app/**: Contains main JavaScript logic and service worker for PWA features.
- **assets/**: Static assets including CSS, JS, fonts, and favicons.
- **bookshop/**: Bookshop management (add, view books, login/logout).
- **config/**: Configuration files and school info.
- **controller/**: PHP controllers for admin, staff, student, attendance, exams, sessions, settings, etc.
- **includes/**: Shared PHP includes (e.g., database connection).
- **logs/**: Error logs for different modules.
- **public/**: Public-facing pages for admin, staff, and students, including dashboards, attendance, fees, notifications, and results.
- **resultroom/**: Stores PDF reports and fee schedules.
- **sql/**: Database installer and SQL dump.
- **src/**: Source CSS files for custom styling.
- **templates/**: Error pages, documentation, loader, and uploads.

## Authentication Flow
- Users (admin, staff, student) log in via `index.php`.
- Credentials are checked against the database.
- On success, users are redirected to their respective dashboards.
- Sessions are used to manage authentication state.

## Main Features
- **Admin Dashboard**: Manage staff, students, fees, attendance, notifications, and results.
- **Staff Dashboard**: Mark attendance, upload results, view students, and manage notifications.
- **Student Dashboard**: View results, notifications, and reports.
- **Bookshop**: Add/view books, login/logout for bookshop users.
- **Attendance**: Track and view attendance for classes and staff.
- **Fee Management**: Fee collection, reminders, structure, and transaction history.
- **Notifications**: Send and view notifications for all user roles.
- **Results**: Upload and view student results.

## Assets
- **CSS**: Bootstrap, Font Awesome, custom styles.
- **JS**: jQuery, Bootstrap, Chart.js, custom scripts for modals and check-in.
- **Favicons**: Multiple sizes for cross-device compatibility.

## Error Logging
- Error logs are stored in the `logs/` directory for admin, staff, and student modules.

## Database
- SQL dump available in `sql/portal.sql`.
- Database connection handled in `includes/database.php`.

## Progressive Web App (PWA)
- Manifest and service worker included for offline support and installability.

## Customization
- Tailwind and custom CSS for modern UI.
- Easily extendable controllers and templates for new features.

## Getting Started
1. Import the SQL dump into your MySQL server.
2. Configure database credentials in `includes/database.php`.
3. Serve the project using XAMPP or a compatible PHP server.
4. Access the portal via `index.php`.

## Contact & Support
For further documentation, see `templates/DOCUMENTATION.md` or contact the project maintainer.
