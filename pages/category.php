<?php
require_once ("models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/navigation.php");
require_once ("layout/footer.php");
require_once ("layout/singleproduct.php");

$categoryid = $_GET['id'];
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$q = $_GET['q'] ?? '';
$pageNo = $_GET['pageNo'] ?? '1';
$pageSize = $_GET['pageSize'] ?? '10';


$dbContext = new DBContext();
$urlModifier = new UrlModifier();

$category = $dbContext->getCategory($categoryid);
?>
<?php
header_layout("Category page");
?>

<?php
navigation_layout($dbContext);
?>
<form method="GET" class="global-search__input"><input type="text" placeholder="Search" name="q"
        value="<?php echo $q; ?>" />
    <input type="hidden" name="id" value="<?php echo $categoryid ?>" />
</form>
<section class="product-selection">
    <div class="product-selection-container">
        <h4>Produkter i
            <?php echo $category->title ?>
        </h4>
        <table class="table">
            <thead>
                <tr>

                    <th>Name<a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-up"></i></a><a
                            href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                    <th>Price<a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-up"></i></a><a
                            href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                    <th>Stock level<a
                            href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-up"></i></a><a
                            href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                                class="fa-solid fa-arrow-down"></i></a></th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <tbody>
            <?php

            $result = $dbContext->searchProduct($sortCol, $sortOrder, $q, $categoryid);
            foreach ($result["data"] as $product) {
                ?>

                <?php
                singleproduct_layout($product);
                ?>

                <?php
            }
            ?>

        </tbody>

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