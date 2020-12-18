<?php

require_once("init.php");


$stmt = $pdo->query("SELECT * FROM logement");


require_once("header.php");

?>


<!-- BODY -->

<h1>LISTER LES LOGEMENTS</h1>


<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Titre</th>
      <th scope="col">Adresse</th>
      <th scope="col">Ville</th>
      <th scope="col">Code Postal</th>
      <th scope="col">Surface</th>
      <th scope="col">Prix</th>
      <th scope="col">Photo</th>
      <th scope="col">Type</th>
      <th scope="col">Description</th>
      <th scope="col">Fiche produit</th>
    </tr>
  </thead>
  <tbody>

    <?php while($logement = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td> <?php echo substr($logement["titre"], 0, 10) . "..."; ?></th>
            <td> <?php echo substr($logement["adresse"], 0, 10) . "..."; ?></th>
            <td> <?php echo $logement["ville"]; ?></th>
            <td> <?php echo $logement["cp"]; ?></th>
            <td> <?php echo $logement["surface"]; ?></th>
            <td> <?php echo $logement["prix"]; ?></th>
            <td> <img style="width:50px" src="<?php echo $logement["photo"]; ?>" alt=""></th>
            <td> <?php echo $logement["type"]; ?></th>
            <td> <?php echo substr($logement["description"], 0, 10) . " ..."; ?></th>
            <td> <a href="descriptif-logement.php?id_logement=<?php echo $logement["id_logement"]; ?>"> Fiche logement </a></th>
        </tr>
    <?php } ?>

    </tbody>
</table>

<?php

require_once("footer.php");


?>