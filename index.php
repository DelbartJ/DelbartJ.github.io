<?php

require_once("init.php");

if($_POST) {

    $erreur = "";


    // Vérifications des champs obligatoires

    foreach($_POST as $index => $valeur) {
      
      if(empty($valeur) && $index !== "description") {
        // echo "la valeur du champ $index est vide <br>";
        $erreur .= "<div class=\"alert alert-danger\" role=\"alert\">
        La valeur du champ $index est vide, veuillez saisir une donnée !
        </div>";
      }
    }

    // Vérifier le code postal : 5 chiffres, integer

    if(!is_numeric($_POST["cp"]) || strlen($_POST["cp"]) < 5) {

      $erreur .="<div class=\"alert alert-warning\" role=\"alert\">
        Veuillez renseiger un nombre à 5 chiffres pour le code postal !
      </div>";
    }
    
    if(!ctype_digit($_POST["surface"])){

      $erreur .="<div class=\"alert alert-warning\" role=\"alert\">
        Veuillez renseiger un nombre entier dans le champ surface!
      </div>";
    }

    if(!ctype_digit($_POST["prix"])){

      $erreur .="<div class=\"alert alert-warning\" role=\"alert\">
        Veuillez renseiger un nombre entier dans le champ prix !
      </div>";
    }


    //Géré la taille d'une photo

    $sizeMax = 1000000;

    if(!empty($_FILES) && !empty($_FILES["photo"]["name"])) {

      if($_FILES["photo"]["size"] > $sizeMax) {
        $erreur .="<div class=\"alert alert-warning\" role=\"alert\">
          Veuillez charger un fichier moins volumineux (1 MO max)
        </div>";
      }

      $extensions = [".png",".jpg",".jpeg"];
      $extension = strrchr($_FILES["photo"]["name"], ".");
      
      if(!in_array($extension, $extensions)) {
        $erreur .="<div class=\"alert alert-warning\" role=\"alert\">
          Veuillez charger un fichier au bon format (jpg, jpeg ou png) !
        </div>";
      }
    }
    
    $content .= $erreur;

    // Si j'ai pas d'erreur j'insert mon logement

    if(empty($erreur)) {

      // PHOTO

      if(!empty($_FILES) && !empty($_FILES["photo"]["name"])) {

          // Récupérer le nom de la photo
          $nomPhoto = "logement_" . time();

          // chemin vers la photo en URL
          $cheminPhoto = URL . "/photo/" . $nomPhoto;

          // le chemin de la photo à copier sur le serveur
          $cheminServer = RACINE_SITE . "/photo/" . $nomPhoto;
          copy($_FILES["photo"]["tmp_name"], $cheminServer);

      }

      foreach($_POST as $index => $valeur) {
          $_POST[$index] = addslashes($valeur);
      }


      $count = $pdo->exec("INSERT INTO logement 
      (titre, adresse, ville, cp, surface, prix, type, description, photo) 
      VALUES (
        '$_POST[titre]',
        '$_POST[adresse]',
        '$_POST[ville]',
        '$_POST[cp]',
        '$_POST[surface]',
        '$_POST[prix]',
        '$_POST[type]',
        '$_POST[description]',
        '$cheminPhoto'  
      )");

      if($count > 0) {
          $content .= "<div class=\"alert alert-success\" role=\"alert\">
          Votre logement a bien été inséré en BDD.
          </div>";
      }
    }
}

require_once("header.php");

?>


<!-- BODY -->

<h1>Insérer un logement en BDD</h1>


    <?php echo $content; ?>

<form class="row" action="" method="post" enctype="multipart/form-data">
  <div class="form-group col-md-4">
    <label for="titre">Titre *</label>
    <input type="text" class="form-control" id="titre" name="titre" aria-describedby="titre">
  </div>

<div class="form-group col-md-4">
    <label for="adresse">Adresse *</label>
    <input type="text" class="form-control" id="adresse" name="adresse" aria-describedby="adresse">
  </div>

<div class="form-group col-md-4">
    <label for="ville">Ville *</label>
    <input type="text" class="form-control" id="ville" name="ville" aria-describedby="ville">
  </div>

<div class="form-group col-md-4">
    <label for="cp">Code Postal *</label>
    <input type="number" class="form-control" id="cp" name="cp" aria-describedby="cp">
  </div>

<div class="form-group col-md-4">
    <label for="surface">Surface *</label>
    <input type="text" class="form-control" id="surface" name="surface" aria-describedby="surface">
  </div>
<div class="form-group col-md-4">
    <label for="prix">Prix *</label>
    <input type="text" class="form-control" id="prix" name="prix" aria-describedby="prix">
  </div>


  <div class="form-group col-md-4">
    <label for="photo">Photo</label>
    <input type="file" class="form-control-file" name="photo" id="photo" >
  </div>

<div class="form-group col-md-4">
    <label for="location"> TYPE *</label>
    <div class="custom-control custom-radio">
        <input type="radio" id="location" name="type" class="custom-control-input" value="location" checked>
        <label class="custom-control-label" for="location">Location</label>
    </div>
</div>
<div class="form-group col-md-4">
    <label for="vente" style="color:transparent">TYPE</label>
    <div class="custom-control custom-radio">
        <input type="radio" id="vente" name="type" class="custom-control-input" value="vente">
        <label class="custom-control-label" for="vente">Vente</label>
    </div>
</div>


<div class="form-group col-md-6">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
</div>


<div class="form-group col-md-6">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>

<?php

require_once("footer.php");


?>