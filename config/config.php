<?php


class Config
{
    private $HOST_NAME = "localhost";
    private $USER_NAME = "root";
    private $PASSWORD = "";
    private $DB_NAME = "prinx";
    public $connection;

    function initConnection()
    {
        $this->connection = mysqli_connect($this->HOST_NAME, $this->USER_NAME, $this->PASSWORD, $this->DB_NAME);
    }

    function closeConnection()
    {
        mysqli_close($this->connection);
    }

    public function checkUserExists($name)
    {
        $this->initConnection();
        $query = "SELECT COUNT(*) FROM users WHERE name = ?";
        if ($stmt = mysqli_prepare($this->connection, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $name); // "s" for string parameter
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userCount);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // If the user count is greater than 0, the user exists
            return $userCount > 0;
        } else {
            return false;
        }
    }


    function insertUser($name, $desc, $linkJson)
    {
        $this->initConnection();

        // Ensure the JSON is properly encoded without extra slashes
        $jsonData = json_encode($linkJson, JSON_UNESCAPED_SLASHES);

        // Prepare the SQL query
        $query = "INSERT INTO users (name, `desc`, links) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($this->connection, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $name, $desc, $jsonData);
            $res = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return $res;
        } else {
            return false;
        }
    }

    public function fetchUsers()
    {
        $this->initConnection();

        $query = "SELECT id, name, `desc`, links FROM users";
        $result = mysqli_query($this->connection, $query);

        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Decode the 'links' field to convert JSON string to an associative array
            $row['links'] = json_decode($row['links'], true);
            $users[] = $row;
        }

        return $users;
    }

    public function fetchUsersByName($name)
    {
        $this->initConnection();

        // Prepare a query to search for names that match the input pattern (case-insensitive)
        $query = "SELECT id, name, `desc`, links FROM users WHERE name LIKE ?";

        if ($stmt = mysqli_prepare($this->connection, $query)) {
            // Use "%" wildcards for partial matching
            $searchPattern = '%' . $name . '%';

            // Bind the parameter to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $searchPattern);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $users = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Decode the JSON links field before adding to the results
                $row['links'] = json_decode($row['links'], true);
                $users[] = $row;
            }

            mysqli_stmt_close($stmt);
            return $users;
        } else {
            return null;
        }
    }

    public function deleteUser($id)
    {
        $this->initConnection();

        // First, check if the user exists
        $checkQuery = "SELECT id FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($this->connection, $checkQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 0) {
                // If no user found with that ID
                mysqli_stmt_close($stmt);
                return false;  // User not found
            }

            mysqli_stmt_close($stmt);
        }

        // Prepare the SQL query to delete the user
        $query = "DELETE FROM users WHERE id = ?";

        if ($stmt = mysqli_prepare($this->connection, $query)) {
            // Bind the ID parameter to the prepared statement
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Execute the statement
            $res = mysqli_stmt_execute($stmt);

            // Close the statement
            mysqli_stmt_close($stmt);

            return $res;  // true if deletion successful, false if not
        } else {
            return false;  // Query preparation failed
        }
    }
}
