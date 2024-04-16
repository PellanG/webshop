<?php
function singleproduct_layout($product)
{
    ?>
    <div class="single-product-main-container">
        <h3 class="product-selection-container__title">

            <?php echo $product->title ?>

        </h3>

        <div class="popular-product-img__container">
            <a href='product?id=<?php echo $product->id ?>'>
                <img src="./assets/product-img/<?php echo $product->img; ?>">
            </a>
        </div>
        <p><?php echo $product->price ?> kr</p>
        <button>Köp</button>


    </div>
    <?php
}
?>