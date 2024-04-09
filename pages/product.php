<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");

$dbContext = new DBContext();
$id = $_GET['id'];

$urlModifier = new UrlModifier();

$product = $dbContext->getProduct($id);
?>

<h2>Du clickade på
    <?php echo $product->title ?>
</h2>