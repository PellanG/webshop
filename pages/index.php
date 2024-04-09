<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("layout/header.php");
require_once ("layout/footer.php");
require_once ("layout/navigation.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['categoryid'] ?? "";
$q = $_GET['q'] ?? '';

$dbContext = new DBContext();
$urlModifier = new UrlModifier();

header_layout("Plantshop")
    ?>



<body>

    <?php
    navigation_layout($dbContext)
        ?>
    <main>
        <form class="global-search__input"><input type="text" placeholder="Search" name="q" value="<?php echo $q; ?>" />
            <!-- <input type="hidden" name="sortCol"  value="<?php echo $sortCol ?>" />       -->
        </form>
        <div class="quotes-container">
            <h2>Shoppa loss hos oss!</h2>
        </div>

        <section class="product-selection">
            <div class="product-selection-container">
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
                        foreach ($dbContext->searchProduct($sortCol, $sortOrder, $q, $categoryId) as $product) {

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
                            <!-- echo "<tr class='table-info'><td>$product->title</td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product?id=$product->id'>EDIT</a></td></tr>"; -->
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="product-selection-container__img"></div>
                <h3 class="product-selection-container__title"></h3>
            </div>
        </section>
    </main>
    <?php
    footer_layout();
    ?>

</body>

</html>