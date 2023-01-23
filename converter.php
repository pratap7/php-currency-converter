<?php 
$output_currency = $from_amount = 0;
$allowed_currency = array('INR','USD','GBP','EUR','NPR');

function convertCurrency($in_amount, $in_currency, $to_currency){
  $EXCHANGE_RATES = array(
    'USD'=> 0.012,
    'EUR'=> 0.010,
    'GBP'=> 0.011,
    'INR'=> 1,
    'NPR'=> 1.6
  );
  $from_rate = $EXCHANGE_RATES[$in_currency];
  $inr_value = 1 / $from_rate;
  $to_rate = $EXCHANGE_RATES[$to_currency];
  $output = $inr_value  $in_amount  $to_rate;
  
  return $output;
}

if(isset($_REQUEST) && !empty($_REQUEST)){
  $from_currency = trim($_GET['from_currency']);
  $from_amount = trim($_GET['from_amount']);
  $to_currency = trim($_GET['to_currency']);
  if(is_numeric($from_amount) && in_array($from_currency, $allowed_currency)){
    $output_currency = convertCurrency($from_amount,$from_currency, $to_currency);
  }
}
?>  

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
  <select name="from_currency" onchange="form.output_amount.value = 0">
    <?php 
      foreach($allowed_currency as $ac){
        $selected = "";
        if($ac == $from_currency) $selected = "selected";
        echo "<option value='{$ac}' {$selected}>{$ac}</option>";
      }
    ?>
  </select> &nbsp; <input type="text" name="from_amount" onchange="form.output_amount.value = 0" value="<?php echo $from_amount;?>" /><br><br>
  <select name="to_currency" onchange="form.output_amount.value = 0"> 
    <?php 
      foreach($allowed_currency as $ac){
        $selected = "";
        if($ac == $to_currency) $selected = "selected";
        echo "<option value='{$ac}' {$selected}>{$ac}</option>";
      }
    ?>
  </select> &nbsp; <input type="text" value ="<?php echo $output_currency?>" name="output_amount" readonly />
  <br><br>
  <button type="submit" >
    Submit
  </button>
</form>
