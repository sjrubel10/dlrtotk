<?php
?>

<div class="siteInfoUpdateHolder">
    <h2>Update Site Info</h2>
    <form action="update_json.php" method="post">
        <label for="siteName">Site Name:</label>
        <input type="text" name="siteName" value="<?php echo $siteInfoData['siteName']?>" required>

        <label for="siteTitle">Site Title:</label>
        <input type="text" name="siteTitle" value="<?php echo $siteInfoData['siteTitle']?>" required>

        <label for="siteDescription">Site Description:</label>
        <textarea name="siteDescription"  required><?php echo $siteInfoData['siteDescription']?></textarea>

        <label for="siteMobileNo">Site Mobile No:</label>
        <input type="text" name="siteMobileNo" value="<?php echo $siteInfoData['siteMobileNo']?>" required>

        <label for="siteEmail">Site Email:</label>
        <input type="email" name="siteEmail" value="<?php echo $siteInfoData['siteEmail']?>" required>

        <h2>Today Dollar Buy Rate:</h2>
        <label for="skrillBuyRate">Skrill:</label>
        <input type="number" name="todayDollerBuyRateskrill" value="<?php echo $siteInfoData['todayDollerBuyRateskrill']?>" required>

        <label for="netellerBuyRate">Neteller:</label>
        <input type="number" name="todayDollerBuyRateNeteller" value="<?php echo $siteInfoData['todayDollerBuyRateNeteller']?>" required>

        <label for="perfectMoneyBuyRate">Perfect Money:</label>
        <input type="number" name="todayDollerBuyRatePerfectMoney" value="<?php echo $siteInfoData['todayDollerBuyRatePerfectMoney']?>" required>

        <h2>Today Dollar Sell Rate:</h2>
        <label for="skrillSellRate">Skrill:</label>
        <input type="number" name="todayDollerSellRateskrill" value="<?php echo $siteInfoData['todayDollerSellRateskrill']?>" required>

        <label for="netellerSellRate">Neteller:</label>
        <input type="number" name="todayDollerSellRateNeteller" value="<?php echo $siteInfoData['todayDollerSellRateNeteller']?>" required>

        <label for="perfectMoneySellRate">Perfect Money:</label>
        <input type="number" name="todayDollerSellRatePerfectMoney" value="<?php echo $siteInfoData['todayDollerSellRatePerfectMoney']?>" required>

        <button type="submit">Update JSON Data</button>
    </form>
</div>


