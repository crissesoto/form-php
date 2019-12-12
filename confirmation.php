
<?php 

// use session vars
session_start();

$email = $_SESSION['email'];
$street = $_SESSION['street'];
$streetnumber = $_SESSION['streetnumber'];
$city = $_SESSION['city'];
$zipcode = $_SESSION['zipcode'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Order Confimation</title>
</head>
<body>
  <h1>Congratulations on you order! <?php echo $email;?></h1>
  <h3> Your order will be send to the follow adress:</h3>
  <p><?php echo $street ?></p>
  <p><?php echo $streetnumber?></p>
  <p><?php echo $city?></p>
  <p><?php echo $zipcode?></p>
  <p>You ordered <?php echo $_COOKIE['totalitems']?> items</p>
</body>
</html>