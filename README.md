# AuthPro

> **Auth System Pro** - Enterprise-Level Authentication System

My Profile | Admin Dashboard | Sign Out

---

## About the Project

**Auth System Pro** is a modern, secure, full-stack authentication system with OTP 2FA, RBAC, adaptive authentication, secure sessions, and polished dashboards for users and admins. Designed to showcase professional full-stack development and enterprise-level security practices.

### Note

> This project is not AI-generated. AI was utilized as a specialized tool for learning, image creation, code review, and concept clarification. I maintain full ownership and can explain every single line of logic within this architecture.

---

## Demo Credentials

To explore the Admin features, use the following credentials:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@email.com` | `123456789` |

---

## Key Features

* **RBAC**: Role-Based Access Control ensures proper access for users and admins.
* **2FA / OTP**: Two-factor authentication for added login security and adaptive verification.
* **User Dashboard**: Edit profile, change password, view secure information in a responsive UI.
* **Admin Dashboard**: Manage users, reset passwords, update roles, and view login logs securely.

---

## Architecture & Security

* **Secure Sessions**: Implements robust session management to prevent hijacking.
* **Argon2id Hashed Passwords**: Uses strong, modern hashing algorithms for storing passwords.
* **Adaptive Auth**: Triggers additional security checks (like OTP) for logins from new devices or IPs.
* **Full System Architecture**: Built with a clear, scalable, and maintainable architecture.

---

## Core Stack

* **Secure PHP 8.3.29 core**
* **PSR-4 autoloading**
* **Middleware**
* **Strict session management**

---

## Architecture Diagram

Here is a high-level overview of the system's architecture:

<img width="1536" height="1024" alt="ArchitectureDiagram" src="https://github.com/user-attachments/assets/4ef56e2f-730a-41c1-9d69-2f28784439e6" />


---

## Screenshots

Explore the various components of the Auth System Pro:

### Registration

<img width="2880" height="1462" alt="register" src="https://github.com/user-attachments/assets/d2a0a464-212a-4ad4-bbdb-be21d7e6725c" />

### Login

<img width="2880" height="1570" alt="login" src="https://github.com/user-attachments/assets/9d367a9f-3fa5-4666-82fe-288cbe6383d3" />

### OTP Verification

<img width="2880" height="1462" alt="otp" src="https://github.com/user-attachments/assets/465a2c3a-30c1-413c-9d18-3784d31838e9" />

### User Dashboard (My Profile)

<img width="2880" height="1462" alt="user" src="https://github.com/user-attachments/assets/a2da615c-49c5-496d-a2e2-1d2d6c06ec32" />
<img width="2880" height="1462" alt="localhost_8000_public_user_dash php (1)" src="https://github.com/user-attachments/assets/9ff9d0b0-aaad-4e9e-96b2-fe4dce222d15" />


### Admin Dashboard

<img width="2880" height="1462" alt="admin" src="https://github.com/user-attachments/assets/35156943-96b2-470b-b23c-24c890be7102" />

---

## Demo Flow

1.  **Landing** → **Registration** → **Login** → **OTP Verification**
2.  **Role-based Dashboard Redirect** (User or Admin)
    * **User Dashboard**: Edit Profile, Change Password
    * **Admin Dashboard**: User Management & Login Logs
3.  **Adaptive Authentication** triggers OTP for new devices/IPs

---

## Check It Out

Explore the code or run the demo to see the full system in action.


[Run Live Demo](https://himu.byethost22.com/)
