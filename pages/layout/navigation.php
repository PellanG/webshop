<?php


function navigation_layout($dbContext)
{
    ?>

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
                        foreach ($dbContext->getAllCategories() as $category) {
                            ?>
                            <li><a class='dropdown-item' href='category?id=<?php echo $category->id ?>'>
                                    <?php echo $category->title ?>
                                </a></li>
                            <?php
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
    <?php
}
?>