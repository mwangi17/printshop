<html>
<head>
  <?php include 'functions.php' ?>
<title>
  payment
</title>
</head>

<body>
  <form method="post" action="pay.php" autocomplete="off">

  <?php echo "payment processing"; ?>

  <?php echo display_error(); ?>
  <?php echo "<p style='text-align:center;font-size:50px;'>PayBill number 101010</p>"; ?>
  <?php echo "<p style='text-align:center;font-size:40px;'>Enter your transaction code below</p>"; ?>
  <input id="qnt_1" name="code" type="text"  value="1" >

  <button name="clk" id="clk">Enter</button>
</form>
<span id="result"></span>

<?php echo $ordid;?>
<script>
var id = <?php echo $ordid;?>;
document.cookie= "id="+id;
</script>
</body>
</html>
<?php

?>
