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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO:Add validation - redan registrerad, password != passwordAgain
    $username = $_POST['username'];
    $password = $_POST['password']; // Hejsan123#
    $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username);
    $registeredOk = true;
    // try {
    //     $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) {
    //         $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    //         $mail->isSMTP();
    //         $mail->Host = 'smtp.ethereal.email';
    //         $mail->SMTPAuth = true;
    //         $mail->Username = 'raheem2@ethereal.email';
    //         $mail->Password = 'PdZkY2RvfRyZGrgNAT';
    //         $mail->SMTPSecure = 'tls';
    //         $mail->Port = 587;

    //         $mail->From = "stefans@superdupershop.com";
    //         $mail->FromName = "Hello"; //To address and name 
    //         $mail->addAddress($_POST['username']); //Address to which recipient will reply 
    //         $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
    //         $mail->isHTML(true);
    //         $mail->Subject = "Registrering";
    //         $url = 'http://localhost:8000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
    //         $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i> för att verifiera ditt konto";
    //         $mail->send();
    //     });
    //     $registeredOk = true;
    // } catch (\Delight\Auth\InvalidEmailException $e) {
    //     $message = "Ej korrekt email";
    // } catch (\Delight\Auth\InvalidPasswordException $e) {
    //     $message = "Invalid password";
    // } catch (\Delight\Auth\UserAlreadyExistsException $e) {
    //     $message = "Finns redan";
    // } catch (\Exception $e) {
    //     $message = "Ngt gick fel";
    // }
    //header('Location: /user/registerthanks');
    //exit;
//}
    // catch(Exception $e){
    //     throw $e;
    //     echo  $e->getMessage();
    //     exit;
    //     $message = "Error";
    // }

}

//$namn = $_POST['namn'];
navigation_layout($dbContext);

header_layout("Registrera");
?>



<div class="register-main__container">
    <?php if ($registeredOk) {

        ?>
        <div>Tack för din registerinbg, kolla mailet och klicka </div>

        <?php
    } else {
        echo "<h1>$message</h1>";
        ?>

        <div class="register-header__container">
            <h2>Ny kund <?php echo $message; ?></h2>
        </div>
        <form method="post" class="register-form">
            <input class="input-register__username" type="text" name="username" value="<?php echo $username ?>"
                placeholder="Användarnamn">

            <input class="input-register__password" type="password" name="password" placeholder="Lösenord">
            <input class="input-register__password" type="password" name="password" placeholder="Lösenord igen">


            <div class="login-link__container">
                <!-- <a href="/" class="listbutton">Cancel</a> -->
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