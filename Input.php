

<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for XAMPP MySQL
$password = ""; // Default password for XAMPP MySQL
$database = "my_projec"; // Replace "your_database" with your actual database name

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
// Set PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Function to insert data into Farmers table
function insertFarmer($pdo, $firstName, $lastName, $contactNumber, $email, $location) {
    $stmt = $pdo->prepare("INSERT INTO Farmers (FirstName, LastName, ContactNumber, Email, Location) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $contactNumber, $email, $location]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Function to insert data into Fields table
function insertField($pdo, $farmerID, $fieldName, $fieldSize, $soilCondition) {
    $stmt = $pdo->prepare("INSERT INTO Fields (FarmerID, FieldName, FieldSize, SoilCondition) VALUES (?, ?, ?, ?)");
    $stmt->execute([$farmerID, $fieldName, $fieldSize, $soilCondition]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Function to insert data into Crops table
function insertCrop($pdo, $farmerID, $cropName, $cropType, $soilType, $idealTemperature, $idealHumidity) {
    $stmt = $pdo->prepare("INSERT INTO Crops (FarmerID, CropName, CropType, SoilType, IdealTemperature, IdealHumidity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$farmerID, $cropName, $cropType, $soilType, $idealTemperature, $idealHumidity]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Function to insert data into HarvestRecords table
function insertHarvestRecord($pdo, $cropID, $harvestDate, $quantityHarvested) {
    $stmt = $pdo->prepare("INSERT INTO HarvestRecords (CropID, HarvestDate, QuantityHarvested) VALUES (?, ?, ?)");
    $stmt->execute([$cropID, $harvestDate, $quantityHarvested]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Function to insert data into MarketPrices table
function insertMarketPrice($pdo, $cropID, $date, $marketName, $pricePerUnit) {
    $stmt = $pdo->prepare("INSERT INTO MarketPrices (CropID, Date, MarketName, PricePerUnit) VALUES (?, ?, ?, ?)");
    $stmt->execute([$cropID, $date, $marketName, $pricePerUnit]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Function to insert data into Pesticides table
function insertPesticide($pdo, $pesticideName, $applicationDate, $cropID, $quantityUsed) {
    $stmt = $pdo->prepare("INSERT INTO Pesticides (PesticideName, ApplicationDate, CropID, QuantityUsed) VALUES (?, ?, ?, ?)");
    $stmt->execute([$pesticideName, $applicationDate, $cropID, $quantityUsed]);
    return $stmt->rowCount() > 0 ? true : false;
}

// Check if form is submitted for Farmers table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert data into Farmers table
    if(isset($_POST['submit_farmer'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $contactNumber = $_POST['contactNumber'];
        $email = $_POST['email'];
        $location = $_POST['location'];
        $success = insertFarmer($pdo, $firstName, $lastName, $contactNumber, $email, $location);
        if ($success) {
            echo "<script>alert('Data inserted into Farmers table successfully.');</script>";
        } else {
            echo "Error inserting data into Farmers table.";
        }
    }

    // Insert data into Fields table
    if(isset($_POST['submit_field'])) {
        $farmerID = $_POST['farmerID'];
        $fieldName = $_POST['fieldName'];
        $fieldSize = $_POST['fieldSize'];
        $soilCondition = $_POST['soilCondition'];
        $success = insertField($pdo, $farmerID, $fieldName, $fieldSize, $soilCondition);
        if ($success) {
            echo "<script>alert('Data inserted into Field table successfully.');</script>";        
        } else {
            echo "Error inserting data into Fields table.";
        }
    }

    // Insert data into Crops table
    if(isset($_POST['submit_crop'])) {
        $farmerID = $_POST['farmerID'];
        $cropName = $_POST['cropName'];
        $cropType = $_POST['cropType'];
        $soilType = $_POST['soilType'];
        $idealTemperature = $_POST['idealTemperature'];
        $idealHumidity = $_POST['idealHumidity'];
        $success = insertCrop($pdo, $farmerID, $cropName, $cropType, $soilType, $idealTemperature, $idealHumidity);
        if ($success) {
            echo "<script>alert('Data inserted into Crops table successfully.');</script>";
        } else {
            echo "Error inserting data into Crops table.";
        }
    }

     // Insert data into HarvestRecords table
if(isset($_POST['submit_harvest'])) {
    $cropID = $_POST['cropID']; // Retrieve CropID from form submission
    $harvestDate = date('Y-m-d', strtotime($_POST['harvestDate'])); // Convert date format to YYYY-MM-DD

     $quantityHarvested = $_POST['quantityHarvested'];

    try {
        // Prepare the SQL query with placeholders
        $stmt = $pdo->prepare("INSERT INTO HarvestRecords (CropID, HarvestDate, QuantityHarvested) VALUES (?, ?, ?)");
        
        // Bind the parameters and execute the query
        $stmt->bindParam(1, $cropID);
        $stmt->bindParam(2, $harvestDate);
        $stmt->bindParam(3, $quantityHarvested);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Data inserted into HarvestRecords table successfully.');</script>";
        } else {
            echo "Error inserting data into HarvestRecords table.";
        }
    } catch (PDOException $e) {
        // Handle any potential errors
        echo "Error: " . $e->getMessage();
    }
}
 


 // Insert data into MarketPrices table
if(isset($_POST['submit_market'])) {
    $cropID = $_POST['cropID']; // Retrieve CropID from form submission
    $date = date('Y-m-d', strtotime($_POST['date']));
    $marketName = $_POST['marketName'];
    $pricePerUnit = $_POST['pricePerUnit'];

    try {
        // Prepare the SQL query with placeholders
        $stmt = $pdo->prepare("INSERT INTO MarketPrices (CropID, Date, MarketName, PricePerUnit) VALUES (?, ?, ?, ?)");
        
        // Bind the parameters and execute the query
        $stmt->bindParam(1, $cropID);
        $stmt->bindParam(2, $date);
        $stmt->bindParam(3, $marketName);
        $stmt->bindParam(4, $pricePerUnit);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Data inserted into MarketPrices table successfully.');</script>";
                } else {
            echo "Error inserting data into MarketPrices table.";
        }
    } catch (PDOException $e) {
        // Handle any potential errors
        echo "Error: " . $e->getMessage();
    }
}

 // Insert data into Pesticides table
if(isset($_POST['submit_pesticide'])) {
    $pesticideName = $_POST['pesticideName'];
    $applicationDate = date('Y-m-d', strtotime($_POST['applicationDate']));
    $cropID = $_POST['cropID']; // Retrieve CropID from form submission
    $quantityUsed = $_POST['quantityUsed'];

    try {
        // Prepare the SQL query with placeholders
        $stmt = $pdo->prepare("INSERT INTO Pesticides (PesticideName, ApplicationDate, CropID, QuantityUsed) VALUES (?, ?, ?, ?)");
        
        // Bind the parameters and execute the query
        $stmt->bindParam(1, $pesticideName);
        $stmt->bindParam(2, $applicationDate);
        $stmt->bindParam(3, $cropID);
        $stmt->bindParam(4, $quantityUsed);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Data inserted into Pesticides table successfully.');</script>";
        } else {
            echo "Error inserting data into Pesticides table.";
        }
    } catch (PDOException $e) {
        // Handle any potential errors
        echo "Error: " . $e->getMessage();
    }
}


    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Management System</title>
    
<style>
 /* styles.css */
/* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 10px;
     
}

.form {
    background-color: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.7);
    margin-bottom: 20px;
}

.form h2 {
    margin-top: 0;
    font-size: px;
}

/* Input styles */
input,
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #e7ebe7;
    color: rgb(0, 0, 0);
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.6s;
}

input[type="submit"]:hover {
    background-color: #45a049;
    color: white;
}

/* Label styles */
label {
    font-weight: bold;
    font-size: 14px;
}
h1{
    text-align: center;
    color: #12648f;
            text-align: center;
            padding: 20px;
             font-size: 50px;
             font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin: 0;
            transition: background-color 0.5s;
}
.button{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
   
}
button{
    background-color:white;
    color: black;
    border: none;
    transition: background-color 0.6s;
    height:  30px;
    width: 70%;
    

}
button:hover{
    background-color: #45a049;
    color: white;
}



</style>
</head>
<body>
    <h1>FARMING DETAILS</h1>
   
        <div class="all_forms">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>Farmer Information</h2>
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required><br>
    
    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" required><br>
    
    <label for="contactNumber">Contact Number:</label>
    <input type="text" id="contactNumber" name="contactNumber" value="<?php echo isset($_POST['contactNumber']) ? htmlspecialchars($_POST['contactNumber']) : ''; ?>" required><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required><br>
    
    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>" required><br>
    
    <input type="submit" name="submit_farmer" value="Submit Farmer Data">
</form>

        
       
        
        
        <!-- Form for Fields table -->
        
        
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h2>Field Information</h2>
            <label for="farmerID">Select Farmer:</label><br>
            <select id="farmerID" name="farmerID" required>
                <?php
                // Fetch all farmers from the database
                $stmt = $pdo->query("SELECT FarmerID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Farmers");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['FarmerID']}'>{$row['FullName']}</option>";
                }
                ?>
            </select><br>
        
            <label for="fieldName">Field Name:</label><br>
            <input type="text" id="fieldName" name="fieldName" required><br>
        
            <label for="fieldSize">Field Size:</label><br>
            <input type="text" id="fieldSize" name="fieldSize" required><br>
        
            <label for="soilCondition">Soil Condition:</label><br>
            <input type="text" id="soilCondition" name="soilCondition" required><br>
        
            <input type="submit" name="submit_field" value="Submit Field Data">
        </form>
        
      
        
         <!-- Form for Crops table -->
         
         
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h2>Crop Information</h2>
            <label for="farmerID">Select Farmer:</label><br>
            <select id="farmerID" name="farmerID" required>
                <?php
                // Fetch all farmers from the database
                $stmt = $pdo->query("SELECT FarmerID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Farmers");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['FarmerID']}'>{$row['FullName']}</option>";
                }
                ?>
            </select><br>
        
            <label for="cropName">Crop Name:</label><br>
            <input type="text" id="cropName" name="cropName" required><br>
        
            <label for="cropType">Crop Type:</label><br>
            <input type="text" id="cropType" name="cropType" required><br>
        
            <label for="soilType">Soil Type:</label><br>
            <input type="text" id="soilType" name="soilType" required><br>
        
            <label for="idealTemperature">Ideal Temperature:</label><br>
            <input type="text" id="idealTemperature" name="idealTemperature" required><br>
        
            <label for="idealHumidity">Ideal Humidity:</label><br>
            <input type="text" id="idealHumidity" name="idealHumidity" required><br>
        
            <input type="submit" name="submit_crop" value="Submit Crop Data">
        </form>
        
       
         <!-- Form for HarvestRecords table -->
        <section>
         
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h2>Harvest Record</h2>
            <label for="cropID">Crop:</label><br>
            <select id="cropID" name="cropID" required>
                <?php
                // Fetch crop ID and name from the Crops table
                $stmt = $pdo->query("SELECT CropID, CropName FROM Crops");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['CropID']}'>{$row['CropID']} - {$row['CropName']}</option>";
                }
                ?>
            </select><br>
        
            <label for="harvestDate">Harvest Date:</label><br>
            <input type="date" id="harvestDate" name="harvestDate" required><br>
        
        
            <label for="quantityHarvested">Quantity Harvested:</label><br>
            <input type="text" id="quantityHarvested" name="quantityHarvested" required><br>
        
            <input type="submit" name="submit_harvest" value="Submit Harvest Data">
        </form>
        
        
        
        
          
        
         <!-- Form for MarketPrices table -->
       
         
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h2>Market Price</h2>
            <label for="cropID">Crop:</label><br>
            <select id="cropID" name="cropID" required>
                <?php
                // Fetch crop ID and name from the Crops table
                $stmt = $pdo->query("SELECT CropID, CropName FROM Crops");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['CropID']}'>{$row['CropID']} - {$row['CropName']}</option>";
                }
                ?>
            </select><br>
        
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required><br>
        
            <label for="marketName">Market Name:</label><br>
            <input type="text" id="marketName" name="marketName" required><br>
        
            <label for="pricePerUnit">Price Per Unit:</label><br>
            <input type="text" id="pricePerUnit" name="pricePerUnit" required><br>
        
            <input type="submit" name="submit_market" value="Submit Market Price Data">
        </form>
        
       
        
        
         <!-- Form for Pesticides table -->
       
        
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h2>Pesticide Information</h2>
            <label for="pesticideName">Pesticide Name:</label><br>
            <input type="text" id="pesticideName" name="pesticideName" required><br>
        
            <label for="applicationDate">Application Date:</label><br>
            <input type="date" id="applicationDate" name="applicationDate" required><br>
        
            <label for="cropID">Crop:</label><br>
            <select id="cropID" name="cropID" required>
                <?php
                // Fetch crop ID and name from the Crops table
                $stmt = $pdo->query("SELECT CropID, CropName FROM Crops");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['CropID']}'>{$row['CropID']} - {$row['CropName']}</option>";
                }
                ?>
            </select><br>
        
            <label for="quantityUsed">Quantity Used:</label><br>
            <input type="text" id="quantityUsed" name="quantityUsed" required><br>
        
            <input type="submit" name="submit_pesticide" value="Submit Pesticide Data">
        </form>
         
    </div>
    <div class="button">
    <button id="goBackBtn">OverAll Submit</button>
    </div>
    <script>
        // Function to display success message and navigate to search page after a delay
        function displaySuccessAndRedirect() {
            alert('All records submitted successfully!');
            setTimeout(function() {
                window.location.href = 'search.php'; // Replace with the actual filename of your search page
            }, 3000); // Delay in milliseconds (e.g., 3000 milliseconds = 3 seconds)
        }

        // Attach an event listener to the button to trigger the function when clicked
        document.getElementById('goBackBtn').addEventListener('click', displaySuccessAndRedirect);
    </script>
       
        
        
        
        </body>
        </html>
        