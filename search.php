 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('green.jpg');
            background-size: cover;
            background-position: center;
        }
        

        h1 {
            color: #fff;
            padding: 20px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            position: relative; /* Added position property */
        }

        label {
            font-weight: bold;
            margin-right: 10px;
            color: #333;
        }

        select, input {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        button {
            background-color: #008080;
            color: #ffffff;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004040;
        }

        a {
            text-decoration: none;
            color: white;
        }

        /* Styles for the Logout and Add Details buttons */
        .button-container {
            display: flex;
            justify-content: flex-end;
            position: absolute;
            top: 10px;
            right: 10px;
            gap: 10px;
        }

        .logout-button,
        .add-details-button {
            background-color: #008080;
            color: #ffffff;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-button:hover,
        .add-details-button:hover {
            background-color: #004040;
        }
        .ff{
            display: flex;
            justify-content: flex-end;
            position: absolute;
            right: 450px;
            bottom: 230px;
            align-items: center;
            gap:5px;
            
        

        }
        #id{
            color: white;
            font-size: 20px;
        }
        
	
	.market-review-button {
    background-color: #008080;
    color: #ffffff;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.market-review-button:hover {
    background-color: #004040;
}

         


       
    </style>
    <script>
        
    // Function to handle form submission
    function submitForm() {
        var searchType = document.getElementById('searchType').value;
        var searchQuery = document.getElementById('searchQuery').value;

        // Set different actions based on the selected search type
        if (searchType === 'farmer') {
            window.location.href = 'search_farmer.php?name=' + searchQuery; // Redirect to PHP script for farmer search
        } else if (searchType === 'crop') {
            window.location.href = 'search_crop.php?name=' + searchQuery; // Redirect to PHP script for crop search
        }
    }


    </script>
</head>
<body>

    <!-- Container for Logout and Add Details buttons at the top right -->
    <div class="button-container">
       
        <button class="add-details-button"><a href="Input.php">Add Details</a></button>
        <button class="market-review-button"><a href="MarketReview.html">Market Review</a></button>
	 <button class="logout-button"><a href="logout.php">Logout</a></button>
    </div>

     <div class="form">
    <form action="#" id="searchForm">
        <h1>Search Page</h1>
        <label for="searchType">Search by:</label>
        <select id="searchType" name="searchType">
            <option value="farmer">Farmer</option>
            <option value="crop">Crop</option>
        </select>

        <label for="searchQuery">Search query:</label>
        <input type="text" id="searchQuery" name="searchQuery" placeholder="Enter search term" required>

        <button type="button" onclick="submitForm()" required>Search</button>
    </form>
</div>
    

        
    </button>
</div>


</body>
</html>
