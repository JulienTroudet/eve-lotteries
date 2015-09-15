<?php if (!empty($superLottery) && !empty($flashLottery)): ?>
    <div id="carousel-special-lotteries" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner" role="listbox">
            <div id="last-super-lottery">

                <?php echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal)); ?>
            </div><br/>

            <div  id="last-flash-lottery">

                <?php echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal)); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php if (!empty($flashLottery)): ?>

        <div id="last-flash-lottery">
            <?php echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal)); ?>
        </div>
    <?php elseif (!empty($superLottery)): ?>

        <div id="last-super-lottery">
            <?php echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal)); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script>
    $(document).ready(function() {

        var server_date = moment.utc("<?php echo date("c") ?>");

        updateFlashCountDown(server_date);
        updateSuperCountDown(server_date);


    });

    function updateFlashCountDown(server_date) {
        <?php if (!empty($flashLottery)): ?>

        var server_date_flash = moment(server_date);

        countdown.setLabels(
            'ms| sec| min| hr|| wk|| yr',
            'ms| secs| mins| hrs|| wk|| yrs',
            ' and ');
        var exp_date = "<?php echo $flashLottery['FlashLottery']['expiration_date'] ?>";

        if(moment.utc(exp_date).isAfter(server_date_flash)){
            server_date_flash.add(1, 'seconds');
            $('.flash-countdown').html("Ends in "+moment.utc(exp_date).countdown(server_date_flash).toString());
        }
        else{
            server_date_flash.add(1, 'seconds');
            $('.flash-countdown').html("Closed");
        }
        setTimeout(function () {updateFlashCountDown(server_date_flash)}, 1000 );
        <?php endif; ?>
    }

    function updateSuperCountDown(server_date) {
        <?php if (!empty($superLottery)): ?>

        var server_date_super = moment(server_date);

        countdown.setLabels(
            'ms| sec| min| hr|| wk|| yr',
            'ms| secs| mins| hrs|| wk|| yrs',
            ' and ');
        var exp_date = "<?php echo $superLottery['SuperLottery']['expiration_date'] ?>";

        if(moment.utc(exp_date).isAfter(server_date_super)){
            server_date_super.add(1, 'seconds');
            $('.super-countdown').html("Ends in "+moment.utc(exp_date).countdown(server_date_super).toString());
        }
        else{
            server_date_super.add(1, 'seconds');
            $('.super-countdown').html("Closed");
        }
        setTimeout(function () {updateSuperCountDown(server_date_super)}, 1000 );
        <?php endif; ?>
    }
</script>