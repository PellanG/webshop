<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$dbContext = new DbContext();
$message = "";
$username = "";
$registeredOk = false;
$passwordAgain = "";
$error = false;
$password = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordAgain = $_POST['passwordAgain'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($password === $passwordAgain) {
        $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username);
        $registeredOk = true;
    } else {
        $error = true;
        $emessage = "Fel lösenord";
    }
}

navigation_layout($dbContext);

header_layout("Registrera");
?>

<div class="register-main__container">
    <?php if ($registeredOk) {
        ?>
        <div>
            <h2>Tack för din registering!</h2>
        </div>
        <?php
    } else {
        ?>
        <?php
        if ($error) {
            echo "<script type='text/javascript'>alert('$emessage');</script>" ?>
            <?php
        }
        ?>

        <div class="register-header__container">
            <h2>Ny kund <?php echo $message; ?></h2>
        </div>
        <form method="POST" class="register-form">
            <input class="input-register__username" type="text" name="username" value="<?php echo $username ?>"
                placeholder="Användarnamn">

            <input class="input-register__password" type="password" name="password" required value="<?php echo $password ?>"
                placeholder="Lösenord">
            <input class="input-register__password" type="password" name="passwordAgain" required
                value="<?php echo $passwordAgain ?>" placeholder=" Lösenord igen">


            <div class="login-link__container">
                <input type="submit" class="listbutton" value="Registrera">


                <a href="/" class="listbutton">Tillbaka till startsidan</a>
            </div>
        </form>
        <?php
    }
    ?>
</div>
<?php
footer_layout();
?>