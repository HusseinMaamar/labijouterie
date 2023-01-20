<?php  require_once './inc/header.inc.php';
if(isset($_GET['action']) && $_GET['action']=='deco'){
 unset($_SESSION['user']);
 $_SESSION['messages']['info'][]='A bientôt';
 header('location:./');
 exit();
}
$resultat = executeRequete("SELECT * FROM product");

//debug($resultat);

$products = $resultat->fetchAll(PDO::FETCH_ASSOC);// 
//debug($products);
?> 
<div class="row">
<?php foreach($products as $product){?>
   <a class="col-md-3 text-decoration-none hover-zoom" href="front/detailProduit.php?id=<?=$product['id'];?>">
      <div class="card border-primary m-3" style="max-width: 20rem; max-height: 40rem;" bis_skin_checked="1">
        <div class="card-header p-2 fs-6 h-50" bis_skin_checked="1"><?= $product['title']; ?></div>
        <img src="<?=BASE.$product['picture'] ;?>" class="img-fluid " alt="">
        <div class="card-body" bis_skin_checked="1">
        <h4 class="card-title"><?= $product['price'];?>€</h4>
        <p class="card-text text-muted fs-5"><strong>Voir plus ></strong></p>
        </div>
      </div>
   </a>
<?php } ?>
</div>
 <?php  require_once './inc/footer.inc.php';  ?>

