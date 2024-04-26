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

    <?php
    singleproduct_layout($product)
        ?>
    <div class="single-product-info-container">
        <p class="single-product-info">

            <?php echo $product->longDesc ?>

            </h3>

        <p><?php echo $product->stockLevel ?> stycken i lager</p>



    </div>
</section>

<?php
footer_layout()
    ?>