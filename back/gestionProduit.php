<?php require_once '../inc/header.inc.php';
if(!admin()){
  header('location:../');
  exit();
}
$resultat = executeRequete("SELECT * FROM product");
$products = $resultat->fetchAll(PDO::FETCH_ASSOC); //

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // suppression du fichier d'upload de photo
    $requete = executeRequete("SELECT * FROM product WHERE id = :id", array(
        ':id' => $_GET['id'],
    ));
    $product = $requete->fetch(PDO::FETCH_ASSOC);
    unlink(BASE.$product['picture']);
    header('location:./gestionProduit.php');
    //
    $req = executeRequete("DELETE  FROM product WHERE id = :id", array(':id' => $_GET['id'],
    ));
}
?>
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titre</th>
      <th scope="col">Prix</th>
      <th scope="col">Description</th>
      <th scope="col">Photo</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $products): ?>
    <tr>
      <th scope="row"><?=$products['id'];?></th>
      <td><?=$products['title'];?></td>
      <td><?=$products['price'];?></td>
      <td><?=$products['description'];?></td>
      <td><img src="<?=BASE.$products['picture'];?>" width="90"  alt=""></td>
      <td>
        <a href="<?=BASE.'back/formulaireProduit.php?id=' . $products['id'];?>" class="btn btn-warning">Modifier</a>
        <a onclick="return confirm('SUR?')" href="?action=delete&id=<?=$products['id'];?>" class="btn btn-danger">Supprimer</a>
    </td>
    </tr>
   <?php endforeach;?>
  </tbody>
</table>
 <?php require_once '../inc/footer.inc.php';?>