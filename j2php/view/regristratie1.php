<?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "inlogproject_fk";
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/regristratie.css">
</head>

<body>
    <div class="form-box">
        <form class="form" method="POST" action="../php/regristratie.php">
            <span class="title">regristratie</span>
            <span class="subtitle">regristreer</span>
            <div class ="form-container">
                <input type="email" class="input" placeholder="Email" name="email">
                <input type="password" class="input" placeholder="wachwoord" name="wachtwoord">
                <input type="text" class="input" placeholder="naam" name="naam">
                <input type="text" class="input" placeholder="achternaam" name="achternaam">
                <input type="text" class="input" placeholder="klas" name="klas">
            </div>
            <button type="submit">Inloggen</button>
        </form>
    </div>
</body>

</html>
</body>
</html>
