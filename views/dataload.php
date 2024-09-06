<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload SQL File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            margin-top: 0;
            font-size: 24px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input[type="file"] {
            margin-bottom: 15px;
        }
        .container form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Upload SQL File</h1>
    <form action="../upload.php" method="post" enctype="multipart/form-data">
        Select SQL file to upload:
        <input type="file" name="sqlfile" accept=".sql" required>
        <input type="submit" value="Upload and Import">
    </form>
    
</div>
</body>
</html>
