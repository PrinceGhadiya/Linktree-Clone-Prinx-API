
# Linktree-Clone-Prinx-API

Linktree-Clone-Prinx-API is a PHP and MySQL-based API that allows users to create and manage their personalized landing pages, similar to Linktree. Users can easily add, view, update, and delete links to their social media profiles, websites, and other relevant content.

## Features
- **User Management**: Create, view, update, and delete user profiles.
- **Link Management**: Add, update, or remove multiple links per user (social media, websites, etc.).
- **Secure API**: Uses prepared statements to prevent SQL injection attacks.
- **JSON Responses**: All API responses are in JSON format for easy integration with frontend applications.
- **Simple CRUD Operations**: Create, Read, Update, and Delete functionalities for users and links.

## API Endpoints

### Create User
- **POST `/api/v1/create_user.php`**
  - Create a new user with a name, description, and a list of links.
  
### Fetch All Users
- **GET `/api/v1/fetch_users.php`**
  - Retrieve a list of all users and their associated links.

### Fetch Single User
- **GET `/api/v1/fetch_user.php?name={name}`**
  - Fetch a specific user by their name.

### Update User
- **PUT `/api/v1/update_user.php`**
  - Update an existing user's profile information (name, description, links).

### Delete User
- **DELETE `/api/v1/delete_user.php`**
  - Delete a user by their ID.

## Technologies Used
- **PHP**: Server-side scripting language.
- **MySQL**: Database for storing user profiles and links.
- **JSON**: Format used for API responses.
- **Prepared Statements**: Used for secure database queries and to prevent SQL injection.

## Getting Started

### Prerequisites
1. PHP 7.0 or higher.
2. MySQL server.
3. A web server like Apache or Nginx.

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/Linktree-Clone-Prinx-API.git
   ```

2. Configure the database:
   - Create a MySQL database and configure the connection settings in the `config/config.php` file.
   - Import the SQL schema to create the necessary tables for users and links.

3. Deploy the API:
   - Upload the project to your server or run it locally using PHP's built-in server:
     ```bash
     php -S localhost:8000
     ```

4. You can now use the API by making HTTP requests to the defined endpoints.

## Usage

You can interact with the API using tools like [Postman](https://www.postman.com/) or via your frontend application.

### Example Request (POST - Create User)

- **URL**: `/api/v1/create_user.php`
- **Method**: POST
- **Body** (JSON):
  ```json
  {
    "name": "John Doe",
    "desc": "Flutter Developer",
    "links": {"twitter": "https://twitter.com/johndoe", "linkedin": "https://linkedin.com/in/johndoe"}
  }
  ```

### Example Response
```json
{
  "data": "User created successfully."
}
```

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
