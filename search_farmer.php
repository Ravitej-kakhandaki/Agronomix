
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:palegreen;
            margin: 0;
            
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            width: 800px;
            max-height: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 255, 1.9);
            display: flex;  
            flex-direction: column;
            align-items: center;
            overflow: auto;
        }

        form {
            margin-bottom: 20px;
        }

        form p {
            margin: 0;
            padding: 5px 0;
            font-size: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        hr {
            border: none;
            border-top: 1px solid black;
            margin: 20px 0;
        }
        h1{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 50px;
        }
 

         
        /* Farmer result styles */
        .farmer-result {
            background-color: #f0f8ff;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Styling for farmer details */
        .farmer-details {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Farmer Details</h1>
    <div class="container">
<?php

 
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "my_projec";

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve search query
$searchQuery = $_GET['name'];

// Query to fetch farmer details, field details, and crop names
$stmt = $pdo->prepare("SELECT Farmers.*, Fields.FieldName, Fields.FieldSize, COUNT(Crops.CropName) AS CropCount, GROUP_CONCAT(Crops.CropName) AS CropNames
                        FROM Farmers
                        LEFT JOIN Fields ON Farmers.FarmerID = Fields.FarmerID
                        LEFT JOIN Crops ON Farmers.FarmerID = Crops.FarmerID
                        WHERE Farmers.FirstName LIKE :searchQuery OR Farmers.LastName LIKE :searchQuery
                        GROUP BY Farmers.FarmerID"); // Group by farmer ID to concatenate crop names
$stmt->execute(['searchQuery' => "%$searchQuery%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any results
if (count($results) > 0) {
    // Loop through each result and output as forms
    foreach ($results as $row) {
        echo "<form method='post' action='#'>";
        echo "<p>Farmer Name: {$row['FirstName']} {$row['LastName']}</p>";
        echo "<hr>";
        echo "<p>Contact Number: {$row['ContactNumber']}</p>";
        echo "<hr>";
        echo "<p>Email: {$row['Email']}</p>";
        echo "<hr>";
        echo "<p>Location: {$row['Location']}</p>";
        echo "<hr>";
        echo "<p>Field Name: {$row['FieldName']}</p>";
        echo "<hr>";
        echo "<p>Field Size(in Acres): {$row['FieldSize']}</p>";
        echo "<hr>";
        echo "<p>Crop Name(s): {$row['CropNames']}</p>";
        echo "<hr>"; // Display the concatenated crop names
        echo "<p>Crop Count: {$row['CropCount']}</p>"; // Display the count of crops
        echo "<hr>";
    }
} else {
    // If no results found, display a message
    echo "No results found.";
}
?>
</div>
</body>
</html>
