# FocusNet — Open-Source Student Collaboration Platform 🚀

> A full-stack academic collaboration platform built using PHP, Firebase, MySQL, and VPS deployment.

## 📌 Overview

FocusNet is an open-source study collaboration platform designed to bring together everything students need into one unified ecosystem.

Modern students often rely on multiple disconnected platforms for communication, productivity, file sharing, and collaboration. FocusNet solves this problem by integrating all essential academic collaboration features into a single web application.

The platform enables students worldwide to:

* Create and join study communities
* Communicate in real-time
* Share academic resources securely
* Collaborate in structured learning environments
* Stay productive using Pomodoro focus sessions

This project was developed by a team of **6 undergraduate developers** as a large-scale learning experience in:

* Full-stack web development
* System design
* Real-time communication systems
* Backend engineering
* VPS deployment & DevOps

---

# ✨ Features

## 🔹 Community System

* Create subject-based communities
* Public and private communities
* Join request approval system
* Community-based collaboration

## 🔹 Real-Time Chat

* Firebase Realtime Database integration
* Dynamic chat rooms per community
* Instant message synchronization

## 🔹 Secure File Sharing

* Upload academic materials securely
* File type validation
* File size restrictions
* Backend upload filtering

## 🔹 Productivity Tools

* Built-in Pomodoro timer
* Focus-based study sessions

## 🔹 Authentication & Access Control

* User registration & login
* Session management
* Role-based access logic
* Public/private visibility control

---

# 🏗️ System Architecture

FocusNet follows a **Monolithic + Firebase Hybrid Architecture**.

## Backend

* PHP
* MySQL

Responsibilities:

* Authentication
* Community management
* File handling
* Access control
* Database operations

## Real-Time Layer

* Firebase Realtime Database

Responsibilities:

* Live chat system
* Community chat rooms
* Instant synchronization

## Frontend

* HTML
* CSS
* JavaScript

## Deployment

* DigitalOcean VPS
* Nginx server
* PHP runtime environment
* MySQL database hosting

---

# ⚙️ Tech Stack

| Technology                 | Purpose              |
| -------------------------- | -------------------- |
| PHP                        | Backend Development  |
| MySQL                      | Relational Database  |
| Firebase Realtime Database | Real-Time Chat       |
| HTML/CSS/JavaScript        | Frontend             |
| Nginx                      | Web Server           |
| DigitalOcean VPS           | Deployment & Hosting |

# 📚 Key Learnings

## Technical Skills

* PHP backend development
* MySQL database design
* Firebase integration
* Real-time communication systems
* VPS deployment
* File upload security

## System Design

* Monolithic architecture
* Real-time systems
* Access control systems
* Scalable chat structures

## Soft Skills

* Team collaboration
* Problem solving
* Production debugging
* Feature ownership

---

# 📉 Project Status

⚠️ The original deployment is currently inactive due to hosting limitations.

However, the project successfully achieved its primary goal:

> Helping us gain real-world experience in building and deploying full-stack systems.

---

# 🛠️ Installation Guide

## 1️⃣ Clone the Repository

```bash
git clone https://github.com/ManujaDemin-dev/Web_groupAE.git
cd focusnet
```

## 2️⃣ Configure the Database

* Create a MySQL database
* Import the provided SQL file
* Update database credentials in the PHP configuration file

## 3️⃣ Configure Firebase

* Create a Firebase project
* Enable Firebase Realtime Database
* Add Firebase configuration keys to the frontend configuration

## 4️⃣ Run the Project

Place the project inside your web server directory.

Example:

* XAMPP → `htdocs`
* Laragon → `www`

Then start:

* Apache/Nginx
* MySQL

Open in browser:

```bash
http://localhost/focusnet
```

---

