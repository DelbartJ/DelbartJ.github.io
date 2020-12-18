<?php

require_once("init.php");
    // idée générale : afficher les informations produit du logement sélectionné depuis index.php

    if(!isset($_GET["id_logement"])) { // si je n'ai pas de paramètre $_GET["id_produit"]
        header("location:liste-logement.php"); // je suis redirigé vers liste-logement.php
        exit();
    }

    // Je récupère mon paramètre $_GET["id_logement"]
    // je requête en base avec la valeur de id_logement récupéré
    if(isset($_GET["id_logement"])) {
        $stmt = $pdo->query("SELECT * FROM logement WHERE id_logement = '$_GET[id_logement]' ");
        if($stmt->rowCount() <= 0) {
           header("location:index.php"); // Si le produit n'éxiste pas en base je redirige
           exit();
        }  
        $logement = $stmt->fetch(PDO::FETCH_ASSOC); // Je récupère le produit
    }
require_once("header.php");

?>


<!-- BODY -->

<h1>Descriptif du logement - <?= $logement["titre"]?>: </h1>

<div class="row col-md-10 mx-auto justify-content-center pt-5 pb-5">
    <div class='card col-md-4 pt-3' style='width: 18rem;'>
        <img class='card-img-top' src='<?= $logement["photo"]?>' alt="<?= $logement["titre"]?>">
        <div class='card-body'>
            <h5 class='card-title text-center'><?= $logement["titre"]?> </h5>
            <h6 class='card-text text-center'><?= $logement["adresse"]?></h6>
            <p class='card-text text-center'><?= $logement["description"]?></p>
        </div>
    </div>

    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">Ville : <?= $logement["ville"]?> </li>

            <li class="list-group-item">Code Postal : 
            <?= $logement["cp"]?> </li>

            <li class="list-group-item">Surface : <?= $logement["surface"]?> m² </li>

            <li class="list-group-item">Prix : <?= $logement["prix"]?> € </li>
            
        </ul>
    </div>
</div>
<?php

require_once("footer.php");


?>