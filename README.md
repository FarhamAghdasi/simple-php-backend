# Simple PHP Backend Project

This project is a simple backend system built with PHP and MySQL for practice purposes. It includes basic authentication, image upload functionality, and CRUD operations for posts.

## Folder Structure
```
[FILE] db.php
[FILE] helper.php
[DIR] images
    [FILE] list.php
    [FILE] upload.php
[FILE] login.php
[DIR] posts
    [FILE] create.php
    [FILE] delete.php
    [FILE] list.php
    [FILE] update.php
[DIR] sql
    [FILE] images.sql
    [FILE] posts.sql
    [FILE] users.sql
```

## Features
- User authentication (Sign Up & Login)
- JWT-based token authentication
- CRUD operations for posts
- Image upload functionality with validation

## Setup Instructions
### 1. Install XAMPP
Make sure you have XAMPP installed to run the PHP server and MySQL database.

### 2. Configure Database
- Create a database named `backend`.
- Import the SQL files located in the `sql` directory:
  - `users.sql`
  - `posts.sql`
  - `images.sql`

### 3. Start the Server
- Open XAMPP and start **Apache** and **MySQL**.
- Place the project inside `C:\xampp\htdocs\backend\`.
- Access the PHP scripts via `http://localhost/backend/`.

## API Endpoints

### Authentication
#### **Login/Register**
```
POST /login.php
Body (JSON):
{
    "username": "user",
    "password": "pass"
}
Response:
{
    "token": "your_generated_token"
}
```

### Image Management
#### **List Images**
```
POST /images/list.php?token=your_token
Response:
{
    "data": [
        { "address": "path/to/image", "size": 12345 }
    ]
}
```

#### **Upload Image**
```
POST /images/upload.php?token=your_token
Form-Data:
- file: (image file)
Response:
{
    "message": "image uploaded",
    "data": { "address": "path/to/image", "size": 12345 }
}
```

### Post Management
#### **Create Post**
```
POST /posts/create.php?token=your_token
Body (JSON):
{
    "title": "My Post",
    "description": "This is a test post."
}
Response:
{
    "data": { "id": 1, "title": "My Post", "description": "This is a test post." }
}
```

#### **List Post**
```
POST /posts/list.php?token=your_token&id=1
Response:
{
    "data": { "id": 1, "title": "My Post", "description": "This is a test post." }
}
```

#### **Update Post**
```
PATCH /posts/update.php?token=your_token&id=1
Body (JSON):
{
    "title": "Updated Post",
    "description": "Updated content."
}
Response:
{
    "data": { "id": 1, "title": "Updated Post", "description": "Updated content." }
}
```

#### **Delete Post**
```
DELETE /posts/delete.php?token=your_token&id=1
Response:
{
    "message": "post deleted"
}
```

## Notes
- The project uses **plain PHP and MySQL**, without any frameworks.
- The authentication system is basic and does not implement full JWT authentication.
- Image uploads are limited to 1MB and support PNG, JPG, and JPEG formats.

## Future Improvements
- Implement JWT properly for authentication.
- Use a framework like Laravel or Express.js for better security and structure.
- Add validation and error handling improvements.

This project is only for learning purposes and should not be used in production.
