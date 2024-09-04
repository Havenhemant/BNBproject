<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 300px;
            margin: 0 auto;
            padding-top: 100px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>User Login</h1>
        <form method="POST" action="converted template/index.php">
            <p>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </p>
            <p>
                <input type="submit" name="login" value="Login">
            </p>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        include "config.php"; // Database connection details

        // Connect to the database
        $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

        if (!$DBC) {
            die("Error: Unable to connect to MySQL. " . mysqli_connect_error());
        }

        // Retrieve and sanitize the input data
        $email = mysqli_real_escape_string($DBC, trim($_POST['email']));
        $password = mysqli_real_escape_string($DBC, trim($_POST['password']));

        // Prepare the SQL query
        $query = "SELECT customerID, password FROM customer WHERE email = ?";
        $stmt = mysqli_prepare($DBC, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Check if the user exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $customerID, $stored_password);
            mysqli_stmt_fetch($stmt);

            // Verify the password
            if ($password === $stored_password) {  // Assuming passwords are stored in plain text (not recommended)
                echo "<p>Login successful! Welcome.</p>";
                // Here you can start a session and set session variables
                // Example: $_SESSION['customerID'] = $customerID;
            } else {
                echo "<p>Incorrect password. Please try again.</p>";
            }
        } else {
            echo "<p>Email not found. Please try again.</p>";
        }

        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($DBC);
    }
    ?>
</body>
</html>
