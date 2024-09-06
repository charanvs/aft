 <?php
     // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);//
    
   // Include the database constants
    require_once './config/dbconstant.php';

    // List of allowed IP addresses
    $allowed_ips = ['120.57.23.248']; // Add your IP address here

    // Check if the client IP is allowed
    $client_ip = $_SERVER['REMOTE_ADDR'];
    echo "<div class='message'>Your IP address: $client_ip</div>"; // Debugging output
    if (!in_array($client_ip, $allowed_ips)) {
        echo '<div class="message error">Access denied: Your IP address is not allowed.</div>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['sqlfile']) && $_FILES['sqlfile']['error'] == UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['sqlfile']['tmp_name'];

        // Check if the uploaded file is a valid SQL file
        $fileType = mime_content_type($uploadedFile);
        if ($fileType !== 'text/plain') {
            echo '<div class="message error">Invalid file type. Please upload a valid SQL file.</div>';
            exit;
        }

        // Create connection using constants
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Check connection
        if ($conn->connect_error) {
            echo '<div class="message error">Connection failed: ' . $conn->connect_error . '</div>';
            exit;
        }

        // Read the SQL file
        $sql = file_get_contents($uploadedFile);
        if ($sql === false) {
            echo '<div class="message error">Error reading the SQL file.</div>';
            exit;
        }

        // Split the SQL file into individual statements
        $queries = explode(';', $sql);

        // Execute each query
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if ($conn->query($query) === FALSE) {
                    echo '<div class="message error">Error executing query: ' . $conn->error . '</div>';
                }
            }
        }

        echo '<div class="message success">Data imported successfully.</div>';

        // Close the connection
        $conn->close();
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<div class="message error">No file uploaded or there was an upload error.</div>';
    }
    ?>