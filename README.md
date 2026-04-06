
# 🌊 Flood Donation Management System

A full-stack web application designed to coordinate relief efforts during floods and natural disasters. This platform connects people in need with donors and administrators by allowing users to request donations (Water, Food, Shelter, or Medications) and enabling admins to manage all requests and users efficiently.

## 👥 Team Members

| Role | Name | Contributions |
|------|------|----------------|
| **Backend Lead** | [Your Name] | PHP logic, MySQL database, CRUD operations, session handling, admin-user role separation, API integration |
| **Frontend Developer** | [Member 2 Name] | UI/UX design, Bootstrap framework, responsive layouts, CSS styling |
| **JavaScript Developer** | [Member 3 Name] | Form validation, dynamic content, user interactions, AJAX requests |
| **QA & Documentation** | [Member 4 Name] | Testing, bug fixes, README documentation, deployment support |

> *[Add LinkedIn profile links for each team member]*

## 🚀 Features

### For Users (Donation Seekers)
- ✅ Register a new donation request (Water, Food, Shelter, Medications)
- ✅ View all their submitted requests
- ✅ Update/edit existing requests
- ✅ Delete their own requests
- ✅ Provide personal details: Full Name, Location (where you live), Phone Number, Email

### For Admins
- ✅ View all registered users and their requests
- ✅ Delete any user account
- ✅ Monitor all donation requests across the system
- ✅ Track donation types distribution
- ✅ Full CRUD control over the platform

### General Features
- ✅ Responsive design (works on mobile, tablet, desktop)
- ✅ Role-based access (User vs Admin)
- ✅ Secure session management
- ✅ Form validation with JavaScript & PHP

## 🛠️ Tech Stack

| Layer | Technologies |
|-------|--------------|
| Frontend | HTML5, CSS3, JavaScript (ES6), Bootstrap 5 |
| Backend | PHP (Procedural & OOP) |
| Database | MySQL (Structured Query Language) |
| Server | Apache (XAMPP/WAMP recommended) |
| Version Control | Git & GitHub |

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/) (or WAMP/LAMP)
- Web browser (Chrome/Firefox/Edge recommended)
- Code editor (VS Code, Sublime Text, or PHPStorm)
- Git (optional, for cloning)

## ⚙️ Installation & Setup

Follow these steps to run the project locally:

### Step 1: Clone or Download
```bash
git clone https://github.com/yourusername/flood-donation-management.git
```
Or download the ZIP file and extract it.

### Step 2: Move to htdocs
```
Copy the project folder to: C:\xampp\htdocs\flood-donation-system\
```

### Step 3: Start Servers
- Open **XAMPP Control Panel**
- Start **Apache** (Port 80)
- Start **MySQL** (Port 3306)

### Step 4: Create Database
- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Click **New** to create a database
- Name it: `flood_donation_db`
- Select **utf8_general_ci** as collation
- Click **Create**

### Step 5: Import SQL File
- Select the `flood_donation_db` database
- Click on **Import** tab
- Click **Choose File** and select `database/flood_donation_db.sql`
- Click **Go** at the bottom

### Step 6: Configure Database Connection
- Open `config/db_connection.php`
- Update credentials if needed:
```php
$host = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$database = "flood_donation_db";
```

### Step 7: Run the Application
- Open your browser
- Navigate to: `http://localhost/flood-donation-system/`

## 📁 Project Structure

flood-donation-system/
│
├── index.php                 # Landing page
├── login.php                 # User/Admin login
├── register.php              # New user registration
│
├── user/
│   ├── dashboard.php         # User dashboard
│   ├── request_form.php      # Create new donation request
│   ├── my_requests.php       # View user's own requests
│   ├── edit_request.php      # Update a request
│   ├── delete_request.php    # Delete a request
│   └── logout.php            # User logout
│
├── admin/
│   ├── dashboard.php         # Admin dashboard
│   ├── view_users.php        # See all registered users
│   ├── view_requests.php     # See all donation requests
│   ├── delete_user.php       # Remove a user account
│   ├── delete_request.php    # Remove any request
│   └── logout.php            # Admin logout
│
├── config/
│   ├── db_connection.php     # Database connection
│   └── session.php           # Session management
│
├── includes/
│   ├── header.php            # Reusable header
│   └── footer.php            # Reusable footer
│
├── css/
│   └── style.css             # Custom styles
│
├── js/
│   ├── validation.js         # Form validation
│   └── main.js               # Interactive features
│
├── database/
│   └── flood_donation_db.sql # Database export file
│
├── assets/
│   └── images/               # Icons and images
│
└── README.md


## 🗄️ Database Schema

### Table: `users`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | Unique user ID |
| full_name | VARCHAR(100) | User's full name |
| email | VARCHAR(100) | Email address (unique) |
| phone | VARCHAR(15) | Contact number |
| location | TEXT | Address/area where user lives |
| password | VARCHAR(255) | Hashed password |
| role | ENUM('user','admin') | User type (default: 'user') |
| created_at | TIMESTAMP | Account creation date |

### Table: `donation_requests`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | Request ID |
| user_id | INT (FOREIGN KEY) | References users(id) |
| donation_type | ENUM('water','food','shelter','meds') | Type of donation needed |
| quantity | VARCHAR(50) | Amount needed (e.g., "10 bottles", "2 tents") |
| urgency | ENUM('low','medium','high','critical') | Priority level |
| status | ENUM('pending','approved','fulfilled','cancelled') | Request status |
| additional_notes | TEXT | Extra information |
| request_date | TIMESTAMP | When request was made |
| last_updated | TIMESTAMP | Last modification time |

### Table: `admin_logs` (Optional)
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Log ID |
| admin_id | INT | References users(id) |
| action | VARCHAR(255) | Action performed |
| target_user | INT | Affected user ID |
| timestamp | TIMESTAMP | Time of action |

## 🔄 CRUD Operations Implemented

| Operation | User Actions | Admin Actions |
|-----------|--------------|----------------|
| **Create** | Register account, Create donation request | Add admin notes |
| **Read** | View own profile, View own requests | View all users, View all requests |
| **Update** | Edit profile, Edit own requests | Update request status |
| **Delete** | Delete own account, Delete own requests | Delete any user, Delete any request |

## 👑 Admin Access

### Default Admin Credentials (After Setup)
```
Email: admin@floodrelief.com
Password: admin123
```
> *⚠️ Change these credentials immediately after first login*

### How to Make a User Admin
1. Log into phpMyAdmin
2. Open `flood_donation_db` → `users` table
3. Find the user and change `role` from 'user' to 'admin'


## 🧪 Testing Scenarios

### Test User Flow:
1. ✅ Register a new account
2. ✅ Login with credentials
3. ✅ Create a donation request (e.g., "Food for family of 4")
4. ✅ View all your requests
5. ✅ Edit an existing request
6. ✅ Delete a request
7. ✅ Logout

### Test Admin Flow:
1. ✅ Login as admin
2. ✅ View all registered users
3. ✅ View all donation requests
4. ✅ Delete a user account
5. ✅ Delete inappropriate requests
6. ✅ Monitor request statuses

## 🔮 Future Enhancements

- [ ] SMS/Email notifications for request updates
- [ ] Map integration to show affected areas
- [ ] Real-time chat between users and admins
- [ ] Volunteer registration module
- [ ] Donation tracking (who donated what)
- [ ] Report generation (PDF/Excel export)
- [ ] Mobile app version (React Native)
- [ ] Multi-language support

## 🐛 Known Issues & Fixes

| Issue | Solution |
|-------|----------|
| Session not starting | Check `session_start()` at top of all PHP files |
| Database connection fails | Verify credentials in `config/db_connection.php` |
| 404 errors | Ensure .htaccess is properly configured |
| Styling not loading | Check CSS file paths are correct |

## 🤝 How to Contribute

We welcome contributions! Follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request

### Coding Standards
- Use meaningful variable names
- Comment complex logic
- Follow PSR standards for PHP
- Test before pushing

## 📧 Contact

**Team FloodRelief**

| Member | Role | LinkedIn | Email |
|--------|------|----------|-------|
| [Nethmi Nimansana] | Backend Lead | [] | your.email@example.com |
| [Member 2] | Frontend Developer | [LinkedIn URL] | member2@example.com |
| [Member 3] | JavaScript Developer | [LinkedIn URL] | member3@example.com |
| [Member 4] | QA & Documentation | [LinkedIn URL] | member4@example.com |

**Project Repository:** [https://github.com/yourusername/flood-donation-management](https://github.com/yourusername/flood-donation-management)

**Live Demo:** [https://yourdemo.com/flood-donation](https://yourdemo.com/flood-donation) *(if hosted)*

## 🙏 Acknowledgments

- **Bootstrap** for responsive UI components
- **PHP & MySQL** community for excellent documentation
- **Local NGOs** for providing requirements insights
- **Our College/University** for guidance and support
- **Open source community** for inspiration

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## ⭐ Show Your Support

If this project helped you or inspired you, please give it a ⭐ on GitHub!

Made with ❤️ by Team FloodRelief | #FloodRelief #TechForGood

---

### 🚀 Quick Commands for Team Members

**To pull latest changes:**
```bash
git pull origin main
```

**To push your changes:**
```bash
git add .
git commit -m "Your message here"
git push origin your-branch-name
```

**To create a new branch:**
```bash
