<?php
require_once ("models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/navigation.php");
require_once ("layout/footer.php");

$categoryid = $_GET['id'];
$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$q = $_GET['q'] ?? '';


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
<div class="category-main__container">
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
                <th>Category<a
                        href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>
                    <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryid ?>"><i
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
        <tbody>
            <?php

            $result = $dbContext->searchProduct($sortCol, $sortOrder, $q, $categoryid);
            foreach ($result["data"] as $product) {
                ?>
                <tr>
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
                <!-- echo "<tr class='table-info'><td>$product->title</td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product?id=$product->id'>EDIT</a></td></tr>"; -->
                <?php
            }
            ?>
        </tbody>
    </table>

</div>
<?php
footer_layout();
?>