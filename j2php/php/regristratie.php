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

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST['email'];
    $blootWachtwoord = $_POST['wachtwoord'];
    $naam = $_POST['naam'];
    $achternaam = $_POST['achternaam'];
    $klas = $_POST['klas'];

    if (empty($email) || 
        empty($blootWachtwoord) ||
        empty($naam) || 
        empty($achternaam) || 
        empty($klas)) {
        header('location: regristratie1.php');
        echo "<script>alert('Alle velden invullen!!');</script>";
    } else {
        // Wachtwoord wordt gehasht met bcrypt (standaard PHP hash algoritme)
        $hashWachtwoord = password_hash($blootWachtwoord, PASSWORD_BCRYPT);

        // Voeg de nieuwe gebruiker toe aan de database en laat de database een nieuw rolid genereren (ai)
        $sql = "INSERT INTO rol (naam) VALUES ('gebruiker');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // laatst gebruikte id wordt gebruikt in de volgende sql statement 
        $rolID = $conn->lastInsertId();

        // Voeg de nieuwe gebruiker toe aan de database met het gegenereerde rol-ID
        $sql = "INSERT INTO gebruiker (email, wachtwoord, voornaam, achternaam, klas, rolid) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $hashWachtwoord, $naam, $achternaam, $klas, $rolID]);

        if ($stmt) {
            $succesMessage = "Medewerker toegevoegd";
            $email = "";
            $blootWachtwoord = "";
            $naam = "";
            $achternaam = "";
            $klas = "";
            header("location: ../view/index1.php");
            echo "<script>alert('gelukt');</script>";
            exit();
        } else {
            header("location: ../view/index1.php");
            $errorMessage = "Fout bij het toevoegen van de medewerker.";
            echo "<script>alert('Fout opgetreden!!');</script>";
            exit();
        }
    }
    
}


?>
