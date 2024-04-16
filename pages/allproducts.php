<?php
require_once ("models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/navigation.php");
require_once ("layout/footer.php");
require_once ("layout/sorttable.php");
require_once ("layout/singleproduct.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['categoryid'] ?? "";
$q = $_GET['q'] ?? '';
$pageNo = $_GET['pageNo'] ?? '1';
$pageSize = $_GET['pageSize'] ?? '20';

$urlModifier = new UrlModifier();
$dbContext = new DBContext();
?>
<?php
header_layout("Alla produkter");
?>
<?php
navigation_layout($dbContext);
?>
<form class="global-search__input"><input type="text" placeholder="Search" name="q" value="<?php echo $q; ?>" />
    <input type="hidden" name="sortCol" value="<?php echo $sortCol ?>" />
</form>
<section class="product-selection">
    <div class="product-selection-container">

        <?php
        sorttable_layout($q)
            ?>
        <?php

        $result = $dbContext->searchProduct($sortCol, $sortOrder, $q, $categoryId, $pageNo, $pageSize);
        foreach ($result["data"] as $product) {
            ?>
            <?php
            singleproduct_layout($product);
            ?>
            <?php
        }
        ?>
    </div>
</section>
<div class="page-selector">
    <?php
    for ($i = 1; $i <= $result["num_pages"]; $i++) {
        if ($pageNo == $i) {
            echo "$i&nbsp;";    // &nbsp; = fusk space så Stefan slapp göra margin i CSS
        } else {
            echo "<a class='listbutton' href='?sortCol=$sortCol&sortOrder=$sortOrder&q=$q&pageNo=$i'>$i</a>&nbsp;";
        }
    }


    ?>
</div>

<?php
footer_layout();
?>