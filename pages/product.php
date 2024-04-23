<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/navigation.php");
require_once ("layout/header.php");
require_once ("layout/footer.php");
require_once ("layout/singleproduct.php");

$dbContext = new DBContext();
$id = $_GET['id'];

$urlModifier = new UrlModifier();

$product = $dbContext->getProduct($id);
?>
<?php
header_layout('product')
    ?>
<?php
navigation_layout($dbContext);
?>

<section class="product-main__container">
    <!-- <h3>
        <?php echo $product->title ?>
    </h3>
    <div class="product-img__container"> <img src="./assets/product-img/<?php echo $product->img; ?>">
    </div>
    <p><?php echo $product->longDesc ?></p>
    <button class="product-buy__btn">Lägg i varukorg</button> -->
    <?php
    singleproduct_layout($product)
        ?>
</section>

<?php
footer_layout()
    ?>