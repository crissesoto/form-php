<?php 

$msg = "";
$msgClass = "";

$email ="";
$street="";
$streetnumber="";
$city ="";
$zipcode="";
$normalShipping = "";
$expressShipping = "";
$_COOKIE['totalitems'] = 0;


if(filter_has_var(INPUT_POST, 'submit')){
session_start();
$_SESSION['email'] = htmlspecialchars($_POST['email']);
$_SESSION['street'] = htmlspecialchars($_POST['street']);
$_SESSION['streetnumber'] = htmlspecialchars($_POST['streetnumber']);
$_SESSION['city'] = htmlspecialchars($_POST['city']);
$_SESSION['zipcode'] = htmlspecialchars($_POST['zipcode']);


    $email = $_SESSION['email'];
    $street = $_SESSION['street'];
    $streetnumber = $_SESSION['streetnumber'];
    $city = $_SESSION['city'];
    $zipcode = $_SESSION['zipcode'];

    $normalShipping = "2 hours";
    $expressShipping = "45 minutes";
    //$products = htmlspecialchars($_POST['products']);

    if(!empty($email) && !empty($street) && !empty($streetnumber) && !empty($city) && !empty($zipcode)){

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "invalid email";
            $msgClass = "alert-danger";

        }elseif(is_numeric($streetnumber)=== false){
            $msg = "Street number has to be numbers!";
            $msgClass = "alert-danger";
        }elseif(is_numeric($zipcode)=== false){
            $msg = "Zipcode has to be numbers!";
            $msgClass = "alert-danger";
        }
        else{
            // $totalValue counter
            $checked_arr = $_POST["products"];
            $totalValue = count($checked_arr);
            setcookie('totalitems', $totalValue, time()+ 86400);

            // passed
            //$msg = "Email Sent";
            header('location: confirmation.php');
            /*
      $toMail = $email && "soto.crisse@hotmail.com";
      $subject = "Your order confirmation";
      $body = "
            <h3>Order Confirmation</h3>
            <h4>Name</h4><p>.$email.</p>
            <h4>Email</h4><p>.$street.' '.$streetnumber.</p>
            <h4>Email</h4><p>.$city.' '.$zipcode.</p>
            
      ";
      // email headers
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

      // from, additional in the header
      $headers .= "FROM: ". $name . "<".$email.">" . "\r\n";

      // send email
      if(mail($toMail, $subject, $body, $headers)){
        // succes -> email sent
        $msg = "Your order has been placed!";
        $msgClass = "alert-succes";
      }else{
        $msg = "Something went wrong with your order!";
        $msgClass = "alert-danger";
      }
      */
        }
    }else{
        $msg = "All fields are required!";
        $msgClass = "alert alert-danger";
    }
}

?>

<?php 
// show according products
$filename = basename($_SERVER['REQUEST_URI']);
//print_r( $filename);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" active href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>

    <?php if($msg != ""):?>
        <div class="alert <?php echo $msgClass; ?>"><p><?php echo $msg; ?></p></div>
    <?php else: ?>
        
    <?php endif ?>

    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:<span class="text-danger">*</span></label>
                <input type="text" id="email" name="email" value="<?php echo $email ?>" class="form-control"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:<span class="text-danger">*</span></label>
                    <input type="text" name="street" id="street" value="<?php echo $street ?>" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:<span class="text-danger">*</span></label>
                    <input type="text" id="streetnumber" name="streetnumber" value="<?php echo $streetnumber ?>" required class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:<span class="text-danger">*</span></label>
                    <input type="text" id="city" name="city" value="<?php echo $city ?>" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode:<span class="text-danger">*</span></label>
                    <input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode ?>" required class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php if($filename == "?food=1") :?>
            <?php foreach ($food AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
            <?php elseif ($filename == "?food=0") :?>
                <?php foreach ($drinks AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="0" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
            <?php endif; ?>
            <label for="shipping">Shipping:<span class="text-danger">*</span></label><br>
            <input type="checkbox" name="shipping" id="normal" value="normal">Normal (orders are fulfilled in 2 hours)<br>
            <input type="checkbox" name="shipping" id="express" value="express">Express (orders are fulfilled in 45 minutes)
        </fieldset>

        <button type="submit" name="submit" class="btn btn-primary">Order!</button>
    </form>
    
    <footer>You already ordered <strong> <?php echo $_COOKIE['totalitems']; ?></strong> items of food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>