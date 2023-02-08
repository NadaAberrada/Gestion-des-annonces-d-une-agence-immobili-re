<?php
$received_code = $_GET['id'];
// echo  $received_code;
try {
    $conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
    // set the PDO error mode to exception
    $content = $conn->query('SELECT * FROM annonce');

    while ($ligne = $content->fetch()) {
        if ($ligne['id'] == $received_code) {
            // echo $ligne['montant'];
            $titre = $ligne['titre'];
            $image = $ligne['image'];
            $description = $ligne['description'];
            $superficie = $ligne['superficie'];
            $adresse = $ligne['adresse'];
            $montant = $ligne['montant'];
            $date_dannonce = $ligne["dateA"];
            $type_annonce = $ligne['type'];
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="pageStyleEdit.css">
    <title>Gestion Immobilière</title>


</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark mb-5 bg-dark">
            <div class="container-fluid">
                <img src="./img/logoo (1).png" alt="" srcset="" style="width: 40px; margin-bottom: 10px; margin-right: 50px" />

                <button class="navbar-toggler" type="button" datea-bs-toggle="collapse" datea-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="Accueil.php">Accueil</a>
                        <a class="nav-link active" aria-current="page" href="./g_i_ajouter.php">Ajouter</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container bg-dark" style="width: 50%; border: 2px solid #000; border-radius: 8px; box-shadow: 2px 2px 5px #000;">
        <h1 class="text-center my-5" style="text-shadow:  2px 2px 5px #000;">Formulaire d'Édition</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>">
            </div>
            <div class="form-group">
                <label for="image">image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="superficie">Superficie</label>
                <input type="number" class="form-control" id="superficie" name="superficie" value="<?php echo $superficie; ?>">
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $adresse; ?>">
                </div>
                <div class="form-group">
                    <label for="montant">Montant</label>
                    <input type="text" class="form-control" id="montant" name="montant" value="<?php echo $montant; ?> ">
                </div>
                <div class="form-group">
                    <label for="dateAnnonce">dateA</label>
                    <input type="date" class="form-control" id="dateAnnonce" name="dateAnnonce" value="<?php echo $date_dannonce; ?>">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="<?php echo $type_annonce; ?>">Vous type était :<?php echo $type_annonce; ?> </option>
                        <option value="Vente">Vente</option>
                        <option value="Location">Location</option>
                    </select>
                    <button type="submit" class="btn btn-dark-subtle m-4">Modifier</button>
                </div>
            </div>
        </form>

    </div>

    <?php
    if (
        isset($_POST['titre']) && isset($_POST['image']) && isset($_POST['description'])
        && isset($_POST['superficie']) && isset($_POST['adresse']) && isset($_POST['montant'])
        && isset($_POST['dateAnnonce']) && isset($_POST['type'])
    ) {
        $img = "./img/";
        $TitreContent = $_POST['titre'];
        $imageContent = $_POST['image'];
        $descriptionContent = $_POST['description'];
        $superficieContent = $_POST['superficie'];
        $adresseContent = $_POST['adresse'];
        $montantContent = $_POST['montant'];
        $dateAnnonceContent = $_POST['dateAnnonce'];
        $typeContent = $_POST['type'];

        if (empty($imageContent)) {
            $imageContent = $image;
        } else {

            $imageContent = $img . $_POST['image'];
        }



        $received_code = $_GET['id'];
        // echo  $received_code;

        try {
            $conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("UPDATE `annonce` SET 
          `titre`=:titre,`image`=:image,
          `description`=:description,
          `superficie`=:superficie,`adresse`=:adresse,
          `montant`=:montant,
          `dateA`=:date_annonce,
          `type`=:type_annonce WHERE `id`=:id");

            $stmt->bindParam(':titre', $TitreContent);
            $stmt->bindParam(':image', $imageContent);
            $stmt->bindParam(':description', $descriptionContent);
            $stmt->bindParam(':superficie', $superficieContent);
            $stmt->bindParam(':adresse', $adresseContent);
            $stmt->bindParam(':montant', $montantContent);
            $stmt->bindParam(':date_annonce', $dateAnnonceContent);
            $stmt->bindParam(':type_annonce', $typeContent);
            $stmt->bindParam(':id', $received_code);

            $stmt->execute();


            header("Refresh:0");

            // echo "Record updated successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>





</body>

</html>