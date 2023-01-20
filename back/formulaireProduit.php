    <?php require_once '../inc/header.inc.php';
    if(!admin()){
        header('location:../');
        exit();
      }
if (!empty($_POST)) {
    //debug($_POST);
    //debug($_FILES);
    if (!empty($_FILES) && !empty($_FILES['picture']['name'])) {
        $pic_bdd = date_format(new DateTime(), 'dmYHis').uniqid().$_FILES['picture']['name'];
        if (!file_exists('../assets') && !file_exists('../assets/upload')) {
            mkdir('../assets', 0777, true);
            mkdir('../assets/upload', 0777, true);
        }
        copy($_FILES['picture']['tmp_name'],'../assets/upload/'.$pic_bdd);
        $req = executeRequete('INSERT INTO product (title, price, description, picture)VALUES(:title, :price, :description, :picture)', array(
            ':title' => $_POST['title'],
            ':price' => $_POST['price'],
            ':description' => $_POST['description'],
            ':picture' =>'assets/upload/'.$pic_bdd
        ));
          debug($req);
        // message
        if (!$req){
            $_SESSION['messages']['danger'][] = 'Une serreur s\'est produite, veuillez recommencer';
            header('location:formulaireProduit.php');
            exit();
        } else {
            $_SESSION['messages']['success'][] = 'Produit ajouté';
            header('location:gestionProduit.php');
            exit();
        }
    } // fin condition de présence de fichier photo à l'ajout

    // update
    if (isset($_POST['id'])) {
        if (!empty($_FILES) && !empty($_FILES['editpicture']['name'])) {
            $pic_bdd = date_format(new DateTime(), 'dmYHis') . uniqid() . $_FILES['editpicture']['name'];
            /// on charge
            copy($_FILES['editpicture']['tmp_name'],'../assets/upload/'. $pic_bdd);
            // on supprime l'anncienne photo
            unlink(BASE.'assets/upload/'.$_POST['picture']);
        } else {
            $pic_bdd = $_POST['picture'];
        }
         $requete = executeRequete("UPDATE  product SET title = :title, price = :price, description= :description, picture= :picture where id = :id", array(
            ':title' => $_POST['title'],
            ':price' => $_POST['price'],
            ':description' => $_POST['description'],
            ':picture' => 'assets/upload/'.$pic_bdd,
            ':id' => $_GET['id'],
        ));
        // message
        if (!$requete) {
            $_SESSION['messages']['danger'][] = 'Une serreur s\'est produite, veuillez recommencer';
            header('location:formulaireProduit.php');
            exit();
        } else {
            $_SESSION['messages']['success'][] = 'Produit ajouté';
            header('location:gestionProduit.php');
            exit();
        }
    }// fin update

}// fin de condition de formulaire
  /// select produit qu'on veut modifier
  if (isset($_GET['id'])) {
    $requete = executeRequete("SELECT * FROM product WHERE id = :id", array(
        ':id' => $_GET['id'],
    ));
    $product = $requete->fetch(PDO::FETCH_ASSOC);
}//fin select par id
?>
    <form action="" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Ajouter produit</legend>
    <div class="form-group" bis_skin_checked="1">
      <label for="product" class="form-label mt-4">Nom produit</label>
      <input name="title" value="<?=$product['title'] ?? '';?>" type="text" class="form-control" id="exampleInputPassword1" placeholder="Saisissez le nom du produit">
    </div>
    <div class="form-group" bis_skin_checked="1">
      <label for="prix" class="form-label mt-4">Prix</label>
      <input type="text" name="price" class="form-control" id="prix" placeholder="Prix" value="<?=$product['price'] ?? '';?>">
    </div>
    <div class="form-group" bis_skin_checked="1">
      <label for="description " class="form-label mt-4">Description </label>
      <textarea class="form-control" name="description" id="description " rows="3"><?=$product['description'] ?? '';?></textarea>
    </div>
    <?php if (isset($product)): ?>
        <div class="form-group text-center">
            <label for="formFile" class="form-label mt-4">Modifier Photo</label>
            <input name="editpicture" class="form-control mb-2" type="file" id="formFile">
                <img src="<?=BASE.$product['picture'];?>" width="300" alt="">
            <input type="hidden" name="picture" value="<?=$product['picture'];?>">
            <input type="hidden" name="id" value="<?=$product['id'];?>">
        </div>
        <?php else: ?>
            <div class="form-group text-center">
                <label for="formFile" class="form-label mt-4">Photo</label>
                <input name="picture" class="form-control mb-2" type="file" id="formFile">
            </div>
     <?php endif;?>
     <button type="submit" class="btn btn-warning mt-3">Enregistrer</button>
  </fieldset>
</form>
<?php require_once '../inc/footer.inc.php';?>
