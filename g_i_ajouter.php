<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Immobilière</title>
</head>
<body>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./g_i.css">
    <title>Gestion Immobilière</title>
  </head>
  <body>
    <header>
    <nav class="navbar navbar-expand-lg mb-5 navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="./img/logoo (1).png" alt="" srcset="" style="width: 50px; margin-bottom: 10px; margin-right: 50px" />

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="./Accueil.php">Accueil</a>
                    </div>
                </div>
            </div>
        </nav>
  </header>

    <div class="container bg-dark" style="width: 50%; border: 2px solid #000; border-radius: 8px; box-shadow: 2px 2px 5px #000;">
      <h1 class="text-center my-5" style="text-shadow:  2px 2px 5px #000;">Formulaire d'Ajout</h1>
      <form  method="post">
        <div class="form-group">
          <label for="titre">Titre</label>
          <input type="text" class="form-control" id="titre" name="titre">
        </div>
        <div class="form-group">
          <label for="img">image</label>
          <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="form-group">
          <label for="superficie">Superficie</label>    
          <input type="number" class="form-control" id="superficie" name="superficie">
        <div class="form-group">
          <label for="adresse">Adresse</label>
          <input type="text" class="form-control" id="adresse" name="adresse">
        </div>
        <div class="form-group">
          <label for="montant">Montant</label>
          <input type="number" class="form-control" id="montant" name="montant">
        </div>
        <div class="form-group">
          <label for="dateAnnonce">Date d'annonce</label>
          <input type="date" class="form-control" id="dateAnnonce" name="dateA">
        </div>
        <div class="form-group">
          <label for="type">Type</label>
          <select class="form-control" id="type" name="type">
            <option>Vente</option>
            <option>Location</option>
          </select>
          <button type="submit" class="btn btn-dark-subtle m-4">Ajouter</button>
        </div>
        </div>
        </form>
        </div>

<?php
if (isset($_POST['titre']) && isset($_POST['image']) && isset($_POST['description']) &&
    isset($_POST['superficie']) && isset($_POST['adresse']) && isset($_POST['montant']) &&
    isset($_POST['dateA']) && isset($_POST['type'])) {

    $TitreContent = trim($_POST['titre']);
    $imgContent = trim($_POST['image']);
    $descriptionContent = trim($_POST['description']);
    $superficieContent = trim($_POST['superficie']);
    $adresseContent = trim($_POST['adresse']);
    $montantContent = trim($_POST['montant']);
    $dateAContent = trim($_POST['dateA']);
    $typeContent = trim($_POST['type']);

    // validate user inputs
    if (!empty($TitreContent) && !empty($imgContent) && !empty($descriptionContent) &&
        !empty($superficieContent) && !empty($adresseContent) && !empty($montantContent) &&
        !empty($dateAContent) && !empty($typeContent)) {
          
          $img="./img/";
          $imageContent=$img.$_POST['image']; 
          

        try {
            $conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
          

            $stmt = $conn->prepare("INSERT INTO annonce (titre, image, description, superficie, adresse, montant, dateA, type) 
                                    VALUES (:titre, :image, :description, :superficie, :adresse, :montant, :dateA, :type)");
            $stmt->bindParam(':titre', $TitreContent);
            $stmt->bindParam(':image', $imageContent);
            $stmt->bindParam(':description', $descriptionContent);
            $stmt->bindParam(':superficie', $superficieContent);
            $stmt->bindParam(':adresse', $adresseContent);
            $stmt->bindParam(':montant', $montantContent);
            $stmt->bindParam(':dateA', $dateAContent);
            $stmt->bindParam(':type', $typeContent);

            $stmt->execute();

        } catch (PDOException $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Tous les champs sont requis!";
        echo "<p style='color:red;'>$errorMessage</p>";

    }
}
?>


        </body>
        </html>


