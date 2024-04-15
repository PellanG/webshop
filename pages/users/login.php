<?php
require 'vendor/autoload.php';
require_once ('models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Utils/UrlModifier.php");

$urlModifier = new UrlModifier();
$dbContext = new DbContext();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $dbContext->getUsersDatabase()->getAuth()
            ->login($username, $password);
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $message = "Could not login";

    }
}

?>

<?php
header_layout("Logga in");
?>
<?php navigation_layout($dbContext);
?>
<?php echo $dbContext->getUsersDatabase()->getAuth()->isLoggedIn(); ?>
<main>


    <div class="login-main__container">



        <div class="login-header__container">
            <h2>Logga in <?php echo $message; ?></h2>
        </div>
        <form method="post" class="login-form">
            <input class="input-login__username" type="text" name="username" value="<?php echo $username ?>"
                placeholder="Username">

            <input class="input-login__password" type="password" name="password" placeholder="Password">

            <input type="submit" class="listbutton" value="Login">
            <div class="login-link__container">
                <a href="/" class="listbutton">Cancel</a>
                <a href="/" class="listbutton">Forgot password?</a>
            </div>
        </form>

    </div>
</main>



<?php
footer_layout();
?>



</html>