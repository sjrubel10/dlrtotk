<?php
require  "main/init.php";
$conn = Db_connect();

$filename = 'managesite/siteInfo.json';
$siteInfoData = getDataFromJsonFile( $filename );
//var_test_die( $siteInfoData );
$buysale_rate = array(
        0=>array('method'=>'Skrill', 'buy_rate'=>$siteInfoData['todayDollerBuyRateskrill'], 'sale_rate'=> $siteInfoData['todayDollerSellRateskrill']),
        1=>array('method'=>'Neteller', 'buy_rate'=>$siteInfoData['todayDollerBuyRateNeteller'], 'sale_rate'=> $siteInfoData['todayDollerSellRateNeteller']),
        2=>array('method'=>'Perfect money', 'buy_rate'=>$siteInfoData['todayDollerBuyRatePerfectMoney'], 'sale_rate'=> $siteInfoData['todayDollerSellRatePerfectMoney']),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteInfoData['siteTitle']?></title>
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
            <h1><?php echo $siteInfoData['siteTitle']?></h1>
            <p><?php echo $siteInfoData['siteDescription']?></p>
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
                <tr class="ratetableColumnHolder">
                    <th class="ratetableColumn">Number</th>
                    <th class="ratetableColumn">Method</th>
                    <th class="ratetableColumn">Buy Rate</th>
                </tr>
                <?php foreach ( $buysale_rate as $key => $rate){
                    $number = $key+1;
                    ?>
                <tr class="ratetableColumnHolder">
                    <td class="ratetableColumn"><?php echo $number;?></td>
                    <td class="ratetableColumn"><?php echo $rate['method'];?></td>
                    <td class="ratetableColumn"><?php echo $rate['buy_rate'];?></td>
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

