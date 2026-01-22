<!DOCTYPE html>
<html>
<head>
    <title>Upload Game - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/css/upload.css">
</head>
<body>

<h1><a href="index.php?action=home">GameStore</a></h1>
   
   <form action="index.php?action=uploadSubmit" method="POST" enctype="multipart/form-data">
       <h2>Upload a New Game</h2>
        
        <label>Game Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Price ($):</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Cover Image (JPG/PNG):</label><br>
        <input type="file" name="image" required accept="image/*"><br><br>

        <label>Free Demo File (.zip):</label><br>
        <input type="file" name="demo_file" required accept=".zip,.rar"><br><br>

        <label>Full Game File (.zip) [PROTECTED]:</label><br>
        <input type="file" name="full_file" required accept=".zip,.rar"><br><br>

        <button type="submit">Upload Game</button>
    </form>
    
    <br>
    <a href="index.php?action=logout">Logout</a>
</body>
</html>