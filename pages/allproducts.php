<?php
require_once ("models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/navigation.php");
require_once ("layout/footer.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['categoryid'] ?? "";
$q = $_GET['q'] ?? '';
$pageNo = $_GET['pageNo'] ?? '1';
$pageSize = $_GET['pageSize'] ?? '10';

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
    <!-- <input type="hidden" name="sortCol"  value="<?php echo $sortCol ?>" />       -->
</form>
<section class="allproducts-main__container">

    <table class="table">
        <thead>
            <tr>

                <th>Name<a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Category<a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>
                    <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Price<a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Stock level<a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php

            $result = $dbContext->searchProduct($sortCol, $sortOrder, $q, $categoryId, $pageNo, $pageSize);
            foreach ($result["data"] as $product) {
                ?>
                <tr class="table-info">
                    <td>
                        <a href='product?id=<?php echo $product->id ?>'>
                            <?php echo $product->title ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $product->categoryId ?>
                    </td>
                    <td>
                        <?php echo $product->price ?>
                    </td>
                    <td>
                        <?php echo $product->stockLevel ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
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