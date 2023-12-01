<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "inlogproject_fk";

// PDO-verbinding
try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Inlogfunctie
function loginUser($email, $password, $conn) {
  $sql = "SELECT id, email, wachtwoord, rolid FROM gebruiker WHERE email = :email";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  

  if ($result && password_verify($password, $result['wachtwoord'])) {
    // Als het wachtwoord overeenkomt, start de sessie en stel de e-mail in
    session_start();
    $_SESSION['Email'] = $email;
    header("Location: ../view/inloggegevens.php");
    exit();
  } else {
    echo "<script>alert('Fout bij inloggen');</script>";
  }
  return false; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    loginUser($email, $password, $conn);
  }
}

?>