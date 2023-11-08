<?php
require  "main/init.php";
$conn = Db_connect();

$buysale_rate = array(
        0=>array('method'=>'Skrill', 'buy_rate'=>100, 'sale_rate'=> 98),
        1=>array('method'=>'Neteller', 'buy_rate'=>100, 'sale_rate'=> 109),
        2=>array('method'=>'Perfect money', 'buy_rate'=>100, 'sale_rate'=> 110),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/buysellstyles.css">
    <link rel="stylesheet" href="assets/css/common.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/common.js"></script>
    <script src="assets/js/index.js"></script>
</head>
<body>
    <?php include_once "views/header.php"?>

    <div class="indexContentHolder">
        <div class="banner-text">
            <h1>Welcome to BDTTODLR Wallet !</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic autem harum eaque aut deserunt pariatur eum
                ea, sequi minus nam veniam atque et quisquam molestiae aperiam! Iusto, ipsum.</p>
            <div class="buySellButtonHolder" id="buySellButtonHolder">
                <div class="buyButton getBtnType" id="buyButton">Buy Dollar</div>
                <div class="sellButton getBtnType" id="sellButton">Sell Dollar</div>
            </div>
            <div class="buySellCardHolder" id="buySellCardHolder"></div>
        </div>
        <div class="buySellCardHolder" id="buySellCardHolder"></div>
    </div>

    <div class="dollerRateHolder">
        <h2>Todays Dollar Rate</h2>
        <div class="buySellRate">
            <table class="buyRatetable">
                <tr>
                    <th>Number</th>
                    <th>Method</th>
                    <th>Buy Rate</th>
                </tr>
                <?php foreach ( $buysale_rate as $key => $rate){
                    $number = $key+1;
                    ?>
                <tr>
                    <td class=""><?php echo $number;?></td>
                    <td class=""><?php echo $rate['method'];?></td>
                    <td class=""><?php echo $rate['buy_rate'];?></td>
                </tr>
                <?php }?>
            </table>
            <table class="saleRatetable">
                <tr>
                    <th>Number</th>
                    <th>Method</th>
                    <th>Sale Rate</th>
                </tr>
                <?php foreach ( $buysale_rate as $key => $rate){
                    $number = $key+1;
                    ?>
                <tr>
                    <td class=""><?php echo $number;?></td>
                    <td class=""><?php echo $rate['method'];?></td>
                    <td class=""><?php echo $rate['sale_rate'];?></td>
                </tr>
                <?php }?>
            </table>
        </div>
    </div>


</body>
</html>

