<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['categoryid'] ?? "";
$q = $_GET['q'] ?? '';

$dbContext = new DBContext();
$urlModifier = new UrlModifier();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aa7322f0de.js" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</head>

<body>
    <section class="video-container">
        <video class="myvideo" src="assets/nature-movie.mp4" type="video/mp4" autoplay muted loop>
        </video>

        <header class="header-container">
            <div class="header-container__title">
                <h1>Plant <i class="fa-brands fa-pagelines"></i> shoppen</h1>

            </div>
            <nav class="header-container__navigation">
                <li class="dropdown">Categories
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <?php
                        foreach ($dbContext->getAllCategories($categoryId) as $category) {
                            echo "<li><a class='dropdown-item' href='?categoryId=$category->id'>$category->title</a></li> ";
                        }
                        ?>

                    </ul>
                </li>
                <li>Login</li>
                <i class="fa-solid fa-cart-shopping">
                    <div class="cart-count-container"><span class="cart-count__content"><span></div>
                </i>
            </nav>
        </header>
    </section>
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
    <footer>
        <div><i class="fa-solid fa-envelope"></i> <span>E-mail</span></div>
        <div><i class="fa-solid fa-phone"></i> <span>Telephone</span></div>
        <div><i class="fa-brands fa-facebook"></i><span> Facebook</span></div>
        <div><i class="fa-solid fa-house"></i><span> Address</span></div>
    </footer>

</body>

</html>