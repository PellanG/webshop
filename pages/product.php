<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/navigation.php");
require_once ("layout/header.php");
require_once ("layout/footer.php");

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
    <h3>Du clickade på
        <?php echo $product->title ?>
    </h3>
    <button class="product-buy__btn">Lägg i varukorg</button>

</section>
<?php
footer_layout()
    ?>