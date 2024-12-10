# X-Balloon Backend

The **X-Balloon Backend** is the central module of the X-Balloon framework, responsible for managing datasets, user interactions, and API endpoints. It is built using the PHP Yii2 framework and provides a robust infrastructure for handling data related to image annotation and AI-driven workflows.

---

## Features
- Manages datasets, including training, validation, and testing sets.
- Handles user authentication and role-based access.
- Supports RESTful API for seamless interaction with frontend and AI modules.
- Integrates the **Image Annotator Module**, available in the `web/ai-parser/AttributeParser-X-Balloon` folder.

---

## Setup Instructions

### 1. Database Setup
1. Create a new database named **`x-balloon-test`** in your MySQL instance.
2. Import the `x-balloon.sql` file into the database:
   ```bash
   mysql -u [username] -p x-balloon-test < path/to/x-balloon.sql
   ```
### 2. Install Dependencies
Run the following command in the backend directory to install all necessary dependencies:

   ```bash
composer install
 ```
### 3. Application Configuration
   Update the database connection details in config/db.php to match your MySQL setup:

   ```bash
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=x-balloon-test',
    'username' => 'your-username',
    'password' => 'your-password',
    'charset' => 'utf8',
];
 ```

### 4. Login Credentials
   Default login credentials:

Username: ai-brain <br/>
Password: ai
### 5. Accessing the Application
   Once the setup is complete, you can access the backend application in your browser:
   ```bash
http://localhost/x-balloon-backend/web
```

# Image Annotator Module
The Image Annotator Module is included in the backend under the following directory:

```bash
web/ai-parser/AttributeParser-X-Balloon
```

## Licensing
This software is licensed under a free-to-use license. You are welcome to use, modify, and distribute it according to the terms provided in the LICENSE file.