<?php
function sorttable_layout($q)
{
    ?>
    <table class="popular-product__table">
        <thead class="popular-product__thead">
            <tr class="popular-product__tr">

                <th>Name<a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>"><i class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Category<a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>
                    <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Price<a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>"><i class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Stock level<a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-up"></i></a><a
                        href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>"><i
                            class="fa-solid fa-arrow-down"></i></a></th>
            </tr>
        </thead>
    </table>
    <?php
}
?>