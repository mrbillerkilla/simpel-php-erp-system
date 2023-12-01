<?php 
session_start();


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



if (isset($_SESSION['Email'])) {
    // Haal de e-mail op uit de sessie
    $email = $_SESSION['Email'];
    
    // Haal de naam en de rol van de gebruiker op basis van e-mail
    $stmt = $conn->prepare("SELECT g.voornaam, g.achternaam, r.naam AS rol_naam
                           FROM gebruiker AS g
                           JOIN rol AS r ON g.rolid = r.id
                           WHERE g.email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Weergave van de naam en de rol in een <div>
        echo '<div class="inloggegevens">';
        echo 'Voornaam: ' . $result['voornaam'] . '<br>';
        echo 'Rol: ' . $result['rol_naam'] . '<br>';
        echo '</div>';

    // Achtergrond variable declareren en initialeren     
    $backgroundStyle = '';
    // Als de rol naam 'admin' is dan wordt de kleur verandert
    if ($result['rol_naam'] === 'admin') {
        $backgroundStyle = 'background-color: rgb(154 213 136);;';
    } elseif ($result['rol_naam'] === 'gebruiker') {
        $backgroundStyle = 'background-color: rgb(121 171 215);;';
    }
    // Met behulp van JS wordt de  achtergrond kleur verandert in het body
    echo '<style>body { ' . $backgroundStyle . ' }</style>';
    }
} else {
    // Gebruiker is niet ingelogd, toon een foutmelding of stuur door naar de inlogpagina
    echo '<div class="geeninlog">';
    echo 'Niet ingelogd.';
    echo '</div>';
    header("Location: index.php");
}

//  Voer een query uit om gebruikersinformatie op te halen
$sql = "SELECT
g.id AS gebruiker_id,
g.email AS gebruiker_email,
g.wachtwoord AS gebruiker_wachtwoord,
g.voornaam AS gebruiker_voornaam,
g.achternaam AS gebruiker_achternaam,
g.klas AS gebruiker_klas,
r.naam AS rol_naam
FROM gebruiker AS g
JOIN rol AS r ON g.rolid = r.id";

// Bereid de query voor en voer deze uit
$stmt = $conn->prepare($sql);
$stmt->execute();

// Haal de resultaten op
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Controleer of er resultaten zijn en toon deze in een tabel
if (count($result) > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Gebruiker ID</th>';
    echo '<th>Email</th>';
    echo '<th>Wachtwoord</th>';
    echo '<th>Voornaam</th>';
    echo '<th>Achternaam</th>';
    echo '<th>Klas</th>';
    echo '<th>Rol</th>';
    echo '</tr>';

    foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . $row['gebruiker_id'] . '</td>';
        echo '<td>' . $row['gebruiker_email'] . '</td>';
        echo '<td>' . $row['gebruiker_wachtwoord'] . '</td>';
        echo '<td>' . $row['gebruiker_voornaam'] . '</td>';
        echo '<td>' . $row['gebruiker_achternaam'] . '</td>';
        echo '<td>' . $row['gebruiker_klas'] . '</td>';
        echo '<td>' . $row['rol_naam'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo "Geen resultaten gevonden.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rolgegevens</title>
    <link rel="stylesheet" href="../style/inloggevens.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <a href="../view/regristratie1.php"><button class="regristratie">regristratie</button></a>
</head>

<body>
</body>

</html>