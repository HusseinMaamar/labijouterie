<?php  require_once '../inc/header.inc.php'; 
if (isset($_GET['id'])) {
    // suppression du fichier d'upload de photo
    $requete = executeRequete("SELECT * FROM product WHERE id = :id", array(
        ':id' => $_GET['id'],
    ));
   $product = $requete->fetch(PDO::FETCH_ASSOC);
   //Dispaly avis client
   $req = executeRequete("SELECT * FROM rating r INNER JOIN user u 
     on u.id  = r.id_user 
     WHERE id_product = :id_product", array(
    ':id_product' => $_GET['id'],
  ));
  $requeteAvis = $req->fetchAll(PDO::FETCH_ASSOC);
}
// requet avis
//debug($_POST['comment']);
if(!empty($_POST))
{
  $error = false;
  if(empty($_POST['comment'])){
    $avis = 'champ obligatoire';
    $error = true;
  }
  if(empty($_POST['rate'])){
    $note = 'note obligatoire';
    $error = true;
  }
    if(!$error){
      $req =  executeRequete('INSERT  INTO rating(id_user, rate, comment, id_product,publish_date) values (:id_user,:rate,:comment, :id_product, :publish_date)', array(
        ':rate'=>$_POST['rate'],
        ':comment'=>$_POST['comment'],
        ':id_product'=>$product['id'],
        ':id_user'=>$_SESSION['user']['id'],
        ':publish_date'=>date("Y-m-d H:i:s"),
       ));
       if(!$req){
        $_SESSION['messages']['danger'][] = 'Un probleme.......';
        header('location:./detailProduit.php?id='.$product['id']);
        debug($_SESSION['messages']);
        exit();
       }else{
        $_SESSION['messages']['success'][] = 'OK envoyer';
           header('location:./detailProduit.php?id='.$product['id']);
           exit();
     }// message succes
    }
}
?> 
<div class="row">
<a href="../index.php" class="fs-1 text-muted  mt-1 text-decoration-none"><ion-icon name="backspace-outline"></ion-icon>Retour</a>
      <div class="card  col-md-3 border-primary m-3" style="max-width: 20rem;" bis_skin_checked="1">
        <div class="card-header" bis_skin_checked="1"><?=$product['title']; ?></div>
        <img src="<?=BASE.$product['picture'] ;?>" class="img-fluid" alt="">
        <div class="card-body" bis_skin_checked="1">
        <h4 class="card-title"><?=$product['price'];?>€</h4>
        <p class="card-text"><?=$product['description']; ?></p>
        </div>
      </div>
  <?php if(user()): ?>
    <div class="col-md-6 m-3">
  <form action=""  method="post">
  <fieldset>
    <legend class="fs-1">Laisser un avis</legend>
    <div class="form-group" bis_skin_checked="1">
      <label for="exampleTextarea" class="form-label mt-4">Avis</label>
      <textarea class="form-control" id="exampleTextarea" name='comment' rows="3"></textarea>
      <span class="text-primary"><?=$avis ?? '';?></span><br>
    </div>
    <!-- <div class="form-group" bis_skin_checked="1">
      <label for="exampleSelect1" class="form-label mt-4">Note</label>
      <select class="form-select" name="rate" id="exampleSelect1">
        <option selected>--NOTE--</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
      <span class="text-primary"><?=$note ?? '';?></span><br>
    </div> -->
    <?php for($i=1; $i<=5; $i++):?>
      <input class="star_input" id='star-<?=$i?>' type='checkbox'  name="rate" value='<?=$i?>'>
      <img class="starAvis" id='starSvg-<?=$i?>' src="../Photos/star-outline.svg" alt="" width="45">
    <?php endfor ?>
    <span class="text-primary"><?=$note ?? '';?></span><br>
    <script>
      var box_1 = document.querySelector('#star-1')
      var box_2 = document.querySelector('#star-2')
      var box_3 = document.querySelector('#star-3')
      var box_4 = document.querySelector('#star-4')
      var box_5 = document.querySelector('#star-5')
      var svg_1 = document.querySelector('#starSvg-1');
      var svg_2 = document.querySelector('#starSvg-2');
      var svg_3 = document.querySelector('#starSvg-3');
      var svg_4 = document.querySelector('#starSvg-4');
      var svg_5 = document.querySelector('#starSvg-5');
      box_1.addEventListener('change', function(){
           if(box_1.checked){
            box_1.checked
            svg_1.setAttribute('src','../Photos/star_gold.svg')
           }else{
            svg_2.setAttribute('src','../Photos/star-outline.svg')
            svg_3.setAttribute('src','../Photos/star-outline.svg')
            svg_4.setAttribute('src','../Photos/star-outline.svg')
            svg_5.setAttribute('src','../Photos/star-outline.svg')
           }
      })
      box_2.addEventListener('change', function(){
           if(box_2.checked){
            box_1.checked = true
            svg_1.setAttribute('src','../Photos/star_gold.svg')
            svg_2.setAttribute('src','../Photos/star_gold.svg')
           }else{
            svg_3.setAttribute('src','../Photos/star-outline.svg')
            svg_4.setAttribute('src','../Photos/star-outline.svg')
            svg_5.setAttribute('src','../Photos/star-outline.svg')
           }
      })
      box_3.addEventListener('change', function(){
           if(box_3.checked){
            box_1.checked = true
            box_2.checked = true
            svg_1.setAttribute('src','../Photos/star_gold.svg')
            svg_2.setAttribute('src','../Photos/star_gold.svg')
            svg_3.setAttribute('src','../Photos/star_gold.svg')
           }else{
            svg_4.setAttribute('src','../Photos/star-outline.svg')
            svg_5.setAttribute('src','../Photos/star-outline.svg')
           }
      })
      box_4.addEventListener('change', function(){
           if(box_4.checked){
            box_1.checked = true
            box_2.checked = true
            box_3.checked = true
            svg_1.setAttribute('src','../Photos/star_gold.svg')
            svg_2.setAttribute('src','../Photos/star_gold.svg')
            svg_3.setAttribute('src','../Photos/star_gold.svg')
            svg_4.setAttribute('src','../Photos/star_gold.svg')
           }else{
            svg_5.setAttribute('src','../Photos/star-outline.svg')
           }
      })
      box_5.addEventListener('change', function(){
           if(box_5.checked){
            box_1.checked = true
            box_2.checked = true
            box_3.checked = true
            box_4.checked = true
            svg_1.setAttribute('src','../Photos/star_gold.svg')
            svg_2.setAttribute('src','../Photos/star_gold.svg')
            svg_3.setAttribute('src','../Photos/star_gold.svg')
            svg_4.setAttribute('src','../Photos/star_gold.svg')
            svg_5.setAttribute('src','../Photos/star_gold.svg')
           }else{
            svg_5.setAttribute('src','../Photos/star-outline.svg')
           }
      })
    </script> 
    <button type="submit" class="btn btn-primary mt-4">Envoyer</button>
  </fieldset>
</form>
</div>
<?php endif; ?>
</div>
<?php if($requeteAvis!=null): ?>
<div class="list-group " bis_skin_checked="1">
<?php foreach($requeteAvis as $displayAvis): ?>
  <div  class="list-group-item list-group-item-action flex-column align-items-start ">
    <div class="d-flex w-100 justify-content-between" bis_skin_checked="1">
      <h5 class="mb-1"><?= $displayAvis['username'] ; ?>
      </h5>
      <small  class="text-muted" ><?= substr($displayAvis['publish_date'],0,10) ; ?></small>
    </div>
    <p class=""><?= $displayAvis['comment'] ; ?></p>
    <small  class="text-warning fs-2">
    <?php for($i=0; $i<$displayAvis['rate']; $i++):?>
      <ion-icon name="star-outline"></ion-icon>
    <?php endfor ?>
    </small>
</div>
 <?php endforeach ?>
 </div>
 <?php endif ?>
 <?php  require_once '../inc/footer.inc.php';  ?>
