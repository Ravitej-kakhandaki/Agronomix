<?php
// Define variables and initialize with empty values
$name = $username = $email = $password = $confirm_password = $phone_number = "";
$name_err = $username_err = $email_err = $password_err = $confirm_password_err = $phone_number_err = "";

// Database connection parameters
$servername = "localhost";
$username_db = "root"; // Replace with your MySQL username
$password_db = ""; // Replace with your MySQL password
$database = "credentials1"; // Replace with your MySQL database name

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$database", $username_db, $password_db);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate phone number
    if (empty(trim($_POST["phone_number"]))) {
        $phone_number_err = "Please enter your phone number.";
    } else {
        $phone_number = trim($_POST["phone_number"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_number_err)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO users (name, username, email, password, confirm_password, phone_number) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $username);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $password); // Creates a password hash
            $stmt->bindParam(5, $confirm_password); // Creates a password hash
            $stmt->bindParam(6, $phone_number);
           

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->closeCursor();
        }
    }

    // Close connection
    $pdo = null;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #2c3e50, #4a6271);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .registration-container {
            background: linear-gradient(to right, #2c3e50, #4a6271);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
            zoom: 1;
            width:400px;
        }

        h2 {
            color: #fff;
            margin-bottom: 15px;
            font-size: 30px;
            text-shadow: 4px 3px black;

        }

        label {
            display: block;
            margin: 8px 0 5px;
            color: #eee;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f0f0f0;
            color: #333;
        }

        button {
            margin-top: 30px;
            background-color: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }
        label {
            display: block;
            margin: 8px 0 5px;
            color: #eee;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f0f0f0;
            color: #333;
        }
        #phoneNumber{
            margin-bottom: 0;
        }

    
    </style>
</head>
<body>

    <div class="registration-container">
        <h2>SIGN UP</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"  value="<?php echo $name; ?>" required>
            <span class="error"><?php echo $name_err; ?></span>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            <span class="error"><?php echo $username_err; ?></span>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $email_err; ?></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>">
            <span class="error"><?php echo $password_err; ?></span>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $confirm_password; ?>">
            <span class="error"><?php echo $confirm_password_err; ?></span>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{10}" value="<?php echo $phone_number; ?>">
            <span class="error"><?php echo $phone_number_err; ?></span>
            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>
