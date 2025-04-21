<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
 body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #3498db, #2c3e50);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .login-container {
            background: linear-gradient(to right, #2c3e50, #4a6271);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
            zoom:1.5;
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 5px 4px white;
            font-size: 50px;

            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-shadow: 4px 3px black;


        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #eee;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f0f0f0;
            color: #333;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .forgot-password {
            margin-top: 15px;
            color: #eee;
        }

        .forgot-password a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #fff;
        }
        a{
            text-decoration: none;
            color: white;
        } 

    </style>
</head>
<body>
    <?php
    session_start();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "credentials1";

        // Create connection
        $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get username/email and password from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to fetch user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE (username = :username OR email = :username) AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists, start session and store user information
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Display alert message
            echo "<script>alert('Login successful! Welcome, " . $_SESSION['username'] . "!');</script>";
            // Redirect to the search page after a delay
            echo "<script>setTimeout(function() { window.location.href = 'search.php'; }, 200);</script>";
            exit();
        } else {
            // Display error message
            echo "<script>alert('Invalid username/email or password. Please try again.');</script>";
        }
    }
    ?>

    <h2>Login</h2>
    <div class="login-container">
    <form method="post">
        <label for="username">Username or Email:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    <div class="forgot-password">
                <a href="forgot.php">Forgot Password?</a>
            </div>
        </div>
</body>
</html>
