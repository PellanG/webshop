<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/footer.php");
require_once ("layout/navigation.php");
require_once ("layout/sorttable.php");
require_once ("layout/singleproduct.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['categoryid'] ?? "";
$q = $_GET['q'] ?? '';
$pageNo = $_GET['pageNo'] ?? '1';
$pageSize = $_GET['pageSize'] ?? '10';



$dbContext = new DBContext();
$urlModifier = new UrlModifier();

header_layout("Plantshop")
    ?>



<body>

    <?php
    navigation_layout($dbContext)
        ?>
    <main>
        <form action="/allproducts" class="global-search__input"><input type="text" placeholder="Search" name="q"
                value="<?php echo $q; ?>" />
            <input type="hidden" name="sortCol" value="<?php echo $sortCol ?>" />
        </form>
        <div class="quotes-container">
            <h2>Shoppa loss hos oss!</h2>
        </div>

        <section class="product-selection">
            <h2>Topp 10 - populäraste produkterna</h2>
            <div class="product-selection-container">

                <?php
                foreach ($dbContext->getPopularProducts($sortCol, $sortOrder, $q, $categoryId) as $product) {
                    ?>
                    <?php
                    singleproduct_layout($product);
                    ?>

                    <?php
                }
                ?>
            </div>
        </section>
    </main>

    <?php
    footer_layout();
    ?>

</body>

</html>