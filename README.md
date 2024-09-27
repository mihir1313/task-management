# Task Management System Workflow

## 1. Authentication and Role Assignment

### **Manager Login**
- A manager logs in using their credentials.
- Upon successful authentication, the manager is granted access to manage users and projects.

### **User Login**
- A user logs in using their credentials.
- Upon successful authentication, the user is granted access to view projects and associated tasks.

---

## Manager Role Workflow

### 2. Creating Users

#### **Create User**
- The manager accesses the user management interface.
- The manager fills in the necessary details (e.g., name, email, role).
- Upon submission, the application validates the input data.
- If validation passes, a new user is created in the database.
- The system generates credentials (username/password) for the new user.
- The credentials are sent to the user via email.

### 3. Creating Projects

#### **Create Project**
- The manager accesses the project management interface.
- The manager fills in project details (e.g., project name, description).
- The application validates the project data.
- If validation passes, the project is created in the database.

### 4. Managing Tasks within a Project

#### **Create Task**
- The manager selects a project to work on.
- The manager accesses the task management interface for that project.
- The manager fills in task details (e.g., title, description, due date).
- The application validates the task data.
- If validation passes, the task is created and assigned to a user.

#### **Read Tasks**
- The manager can view all tasks associated with the project.

#### **Update Task**
- The manager can edit existing tasks (e.g., change title, update status).
- The application validates the updated task data.
- If validation passes, the task is updated in the database.

#### **Delete Task**
- The manager can delete a task associated with the project.
- The application confirms the deletion action before removing the task from the database.

---

## User Role Workflow

### 5. Viewing Projects and Tasks

#### **Accessing Projects**
- Upon login, the user is presented with a list of projects assigned to them.
- The user selects a project to view associated tasks.

### 6. Managing Own Tasks

#### **Read Own Tasks**
- The user can view tasks assigned to them within the selected project.

#### **Create Task**
- The user can create a new task for themselves.
- The user fills in task details (e.g., title, description, due date).
- The application validates the input data.
- If validation passes, the task is created in the database, assigned to the user.

#### **Update Own Tasks**
- The user can edit tasks assigned to them.
- The application validates the updated task data.
- If validation passes, the task is updated in the database.

#### **Delete Own Tasks**
- The user can delete tasks assigned to them.
- The application confirms the deletion action before removing the task from the database.

---

## Summary of the Workflow

### **Manager Actions:**
- **Create User** → Validate → Store in Database → Send Email
- **Create Project** → Validate → Store in Database
- **Create Task** → Validate → Store in Database (assign to user)
- **Read Tasks** → **Update Tasks** → **Delete Tasks** (associated with the project)

### **User Actions:**
- **Read Projects** → **Select Project** → **Read Own Tasks**
- **Create Task** → Validate → Store in Database (for themselves only)
- **Update Own Tasks** → **Delete Own Tasks**

---

This workflow ensures that managers can manage users and tasks effectively while users can manage only their tasks, maintaining the integrity and security of the application.
