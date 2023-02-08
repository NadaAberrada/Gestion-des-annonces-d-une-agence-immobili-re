<?php
$conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = $conn->query("DELETE  FROM`annonce` WHERE `id`='$id'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time() ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <script>
        function confirmDelete(id) {
            let html = "";
            var modal = document.getElementById("cardsaffiche");
            html += "<div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>" +
                "<div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'>" +
                " <h1 class='modal-title fs-5' id='exampleModalLabel'>Assurance de décision</h1>" + "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Clos'></button></div>" +
                " <div class='modal-body'>êtes-vous sûr de vouloir supprimer celui-ci? </div>" +
                "<div class='modal-footer'>" + " <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>" +
                " <button type='button' class='btn btn-primary' id='confirmDeleteBtn'>Supprimer</button>" +
                "</div></div></div></div>";

            modal.insertAdjacentHTML("afterbegin", html);

            document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
                window.location = "Accueil.php?id=" + id;
            });
            // function edit(){
            //     window.location = "Accueil.php?id=" + id;
            // }
        }
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="./img/logoo (1).png" alt="" srcset="" style="width: 50px; margin-bottom: 10px; margin-right: 50px" />

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="./g_i_ajouter.php">Ajouter</a>

                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container" id="test">
        <div class="row justify-content-center mt-4" id="cardsaffiche"></div>




        <div class="cont p-3 mb-4" style="border-radius: 10px; background: #b8b5d5;">
            <form action="" method="post">
                <h2 class="text-center">Filtration</h2>
                <div class="form-group justify-content-center  gap-5 m-3 ps-2 d-flex">
                    <div class="form-group mr-2">
                        <label for="min">Minimum price:</label>
                        <input class="form-control ps-2" style="border: solid 1px black; background: #2b2f33; color: #fff" type="number" name="min_price" id="min">
                    </div>
                    <div class="form-group">
                        <label for="max">Maximum price:</label>
                        <input class="form-control  ps-2" style="border: solid 1px black; background: #2b2f33; color: #fff" type="number" name="max_price" id="max">
                    </div>
                </div>
                <div class="input-group justify-content-center mb-4 ps-2">
                    <select class="form-select" id="type" style="border: solid 1px black; background: #2b2f33; color: #fff" aria-label=".form-select-sm example" name="filter">
                        <option value="">Selectionné type d'annonce</option>
                        <option value=" ">Tous</option>
                        <option value="location">location</option>
                        <option value="Vente">Vente</option>
                    </select>
                    <input type="submit" value="filter" name="Submit" class="btn btn-warning">
                </div>
            </form>
        </div>
    </div>
    </div>





    <?php
    if (isset($_POST['Submit'])) {
        if (isset($_POST['min_price']) && isset($_POST['max_price']) && isset($_POST['filter'])) {
            $minValue = $_POST['min_price'];
            $maxValue = $_POST['max_price'];
            $filterValue = $_POST['filter'];
            try {
                $conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
                // set the PDO error mode to exception
                $content = $conn->prepare("SELECT * FROM `annonce` WHERE  `montant` >=:minValue AND`montant` <=:maxValue AND `type` = :typee");
                $content->bindParam(':minValue', $minValue);
                $content->bindParam(':maxValue', $maxValue);

                $content->bindParam(':typee', $filterValue);

                $content->execute();

                echo "<div class='container'>";
                echo "<div class='row'>";
                while ($ligne = $content->fetch()) {
                    echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-3'>
                        <div class='card text-center ' style='background-color: #212529;'>
                    <img src=" . $ligne['image'] . " class='card-img-top'style='width:100%; height: 200px; object-fit:cover;'>
                    <div class='card-body' style='color:white'> <h5>" . $ligne['titre'] . "</h5>
                    <p>" . $ligne['montant'] . "MAD</p>
                    <p style='color: orange;font-weight:bold;'>POUR :" . $ligne['type'] . "</p>
                    <a  onclick='confirmDelete(" . $ligne["id"] . ")'class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'style='background-color:#2b3178'>Delete</a>
                    <a  href='pageEdit.php?id=" . $ligne["id"] . "'class='btn btn-primary' style='background-color:#2b3178'>Edit</a>
                    </div></div></div>
                    ";
                }
                echo "</div> </div>";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=g_i;port=3306;charset=UTF8", 'root', '');
            // set the PDO error mode to exception
            $content = $conn->query('SELECT * FROM annonce');
            echo "<div class='container'>";
            echo "<div class='row'>";
            while ($ligne = $content->fetch()) {
                echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-3'>
                <div class='card text-center ' style='background-color: #212529;'>
               <img src=" . $ligne['image'] . " class='card-img-top'style='width:100%; height: 200px; object-fit:cover;'>
               <div class='card-body' style='color:white'> <h5>" . $ligne['titre'] . "</h5>
             <p>" . $ligne['montant'] . "MAD</p>
             <p style='color: orange;font-weight:bold;'>POUR :" . $ligne['type'] . "</p>
            <a  onclick='confirmDelete(" . $ligne["id"] . ")'class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'style='background-color:#2b3178'>Delete</a>
            <a  href='pageEdit.php?id=" . $ligne["id"] . "'class='btn btn-primary' style='background-color:#2b3178'>Edit</a>
              </div></div></div>
             ";
            }
            echo "</div> </div>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</body>

</html>