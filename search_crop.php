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
             
            overflow: auto;
            
        }

        form {
            margin-bottom: 20px;
        }

        form p {
            margin: 0;
            padding: 5px 0;
             

        }

        hr {
            border: none;
            border-top: 1px solid black;
            margin: 20px 0;
        }

        /* Button styles */
        button {
            background-color: #008080;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004040;
        }

        /* Crop result styles */
        .crop-result {
            background-color: #f0f8ff;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Styling for crop details */
        .crop-details {
            margin-bottom: 10px;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: 30px;
            
        }
        
        h1{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 50px;
        }
    </style>
</head>
<body>
    <h1>Crop Related Data</h1>
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

// Query to fetch crop details, market prices, harvest records, pesticides, and farmers growing the crop
$stmt = $pdo->prepare("SELECT crops.*, 
                            MarketPrices.Date AS MarketDate, MarketPrices.MarketName, MarketPrices.PricePerUnit, 
                            HarvestRecords.HarvestDate, HarvestRecords.QuantityHarvested, 
                            Pesticides.PesticideName, Pesticides.ApplicationDate, 
                            GROUP_CONCAT(Farmers.FirstName, ' ', Farmers.LastName) AS FarmersGrowingCrop
                        FROM Crops
                        LEFT JOIN MarketPrices ON Crops.CropID = MarketPrices.CropID
                        LEFT JOIN HarvestRecords ON Crops.CropID = HarvestRecords.CropID
                        LEFT JOIN Pesticides ON Crops.CropID = Pesticides.CropID
                        LEFT JOIN Farmers ON Crops.FarmerID = Farmers.FarmerID
                        WHERE Crops.CropName LIKE :searchQuery
                        GROUP BY Crops.CropID");
$stmt->execute(['searchQuery' => "%$searchQuery%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display search results
if(count($results)>0)
{
  foreach ($results as $row) {
    echo "<div class='crop-result'>";
    echo "<div class='crop-details'>";

    // Crop Name
    if (isset($row['CropName'])) {
        echo "<p>Crop Name: {$row['CropName']}</p>";
    } else {
        echo "<p>Crop Name: N/A</p>"; // Handle case where CropName is not set
    }

    // Ideal Temperature
    if (isset($row['IdealTemperature'])) {
        echo "<p>Ideal Temperature(&deg;C)
        : {$row['IdealTemperature']}</p>";
    } else {
        echo "<p>Ideal Temperature(&deg;C): N/A</p>";
    }

    // Ideal Humidity
    if (isset($row['IdealHumidity'])) {
        echo "<p>Ideal Humidity(%): {$row['IdealHumidity']}</p>";
    } else {
        echo "<p>Ideal Humidity(%): N/A</p>";
    }

    // Market Date
    if (isset($row['MarketDate'])) {
        echo "<p>Market Date: {$row['MarketDate']}</p>";
    } else {
        echo "<p>Market Date : N/A</p>";
    }

    // Market Name
    if (isset($row['MarketName'])) {
        echo "<p>Market Name: {$row['MarketName']}</p>";
    } else {
        echo "<p>Market Name: N/A</p>";
    }

    // Price Per Unit
    if (isset($row['PricePerUnit'])) {
        echo "<p>Price Per Unit(Rupees): {$row['PricePerUnit']}</p>";
    } else {
        echo "<p>Price Per Unit(Rupees): N/A</p>";
    }

    // Harvest Date
    if (isset($row['HarvestDate'])) {
        echo "<p>Harvest Date: {$row['HarvestDate']}</p>";
    } else {
        echo "<p>Harvest Date: N/A</p>";
    }

    // Quantity Harvested
    if (isset($row['QuantityHarvested'])) {
        echo "<p>Quantity Harvested(In Quintal): {$row['QuantityHarvested']}</p>";
    } else {
        echo "<p>Quantity Harvested(In Quintal): N/A</p>";
    }

    // Pesticide Name
    if (isset($row['PesticideName'])) {
        echo "<p>Pesticide Name: {$row['PesticideName']}</p>";
    } else {
        echo "<p>Pesticide Name: N/A</p>";
    }

    // Application Date
    if (isset($row['ApplicationDate'])) {
        echo "<p>Application Date: {$row['ApplicationDate']}</p>";
    } else {
        echo "<p>Application Date: N/A</p>";
    }

    // Farmers Growing Crop
    if (isset($row['FarmersGrowingCrop'])) {
        echo "<p>Farmers Growing Crop: {$row['FarmersGrowingCrop']}</p>";
    } else {
        echo "<p>Farmers Growing Crop: N/A</p>";
    }

    echo "</div>";
    echo "<hr>";
    echo "</div>";
 } 
}
if(count($results)<=0)
{
  echo "<center> No data Found </center>"; 
}

?>

    </div>
</body>
</html>
