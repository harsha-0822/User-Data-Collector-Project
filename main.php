<!DOCTYPE html>
<html>
<head>
    <title>User Data Collection</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 300;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        input[type="text"]:focus, input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        input[type="file"] {
            background: white;
            cursor: pointer;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-top: 10px;
        }
        
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // --- Database Configuration ---
            $servername = "192.168.0.151";
            $username = "udc";
            $password = "Bharath@9513";
            $dbname = "project";
            // Create a database connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // --- Process Form Data (SAFE WAY) ---
            // Collect user data from the form
            $name = $_POST["name"];
            $age = $_POST["age"];
            $country = $_POST["country"];
            // Use PREPARED STATEMENTS to prevent SQL Injection
            $stmt = $conn->prepare("INSERT INTO users (name, age, country) VALUES (?, ?, ?)");
            // 'ssi' means the variables are: String, String, Integer. Adjust if your 'age' is a number.
            // If 'age' is an INT in your database, use 'isi' for Integer, String, Integer.
            // Let's assume name and country are strings, age is an integer.
            $stmt->bind_param("sis", $name, $age, $country);
            if ($stmt->execute()) {
                echo '<div class="message success">User data has been successfully stored in the database.</div>';
            } else {
                echo '<div class="message error">Error storing data: ' . $stmt->error . '</div>';
            }
            // Close the statement and connection
    $stmt->close();
    $conn->close();
    // --- Handle File Upload (SAFER WAY) ---
    // Check if a file was actually uploaded without errors
    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '/var/udc/uploads/';
        // Sanitize the filename to prevent security issues
        $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['userfile']['name']));
        $uploadFile = $uploadDir . $fileName;
        // Check if upload directory exists and is writable
        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
             echo "File upload failed: Upload directory does not exist or is not writable.<br>";
        } else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile)) {
            echo "File has been successfully uploaded as " . htmlspecialchars($fileName) . "<br>";
        } else {
            echo "File upload failed. Possible permission error or server issue.<br>";
        }
    } else {
        // Handle different upload errors
        $upload_error = isset($_FILES['userfile']['error']) ? $_FILES['userfile']['error'] : 'No file uploaded';
        echo "File upload error code: " . $upload_error . "<br>";
    }
}
?>
        
        <h2>Enter User Information</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>
            </div>
            
            <div class="form-group">
                <label for="userfile">File Upload:</label>
                <input type="file" id="userfile" name="userfile">
            </div>
            
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>