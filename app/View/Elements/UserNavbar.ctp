<?php if(isset($userGlobal)): ?>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" style="padding:8px 15px;">
                    <img src="https://image.eveonline.com/Character/<?php echo $userGlobal['id']; ?>_32.jpg">
                    <?php echo $userGlobal['eve_name']; ?> management account
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                        if ($userGlobal['group_id'] == 3 || $userGlobal['group_id'] == 5 || $userGlobal['group_id'] == 6) {
                            echo $this->Html->link(
                                'My Wages',
                                array('controller' => 'wages', 'action' => 'index'));
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($userGlobal['group_id'] == 3 || $userGlobal['group_id'] == 6) {
                            echo $this->Html->link(
                                'Banking',
                                array('controller' => 'transactions', 'action' => 'banking')
                            );
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($userGlobal['group_id'] == 3 || $userGlobal['group_id'] == 5) {
                            echo $this->Html->link(
                                'Give Withdrawals',
                                array('controller' => 'withdrawals', 'action' => 'management', 'admin' => false, 'plugin' => false)
                            );
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($userGlobal['group_id'] == 3) {
                            echo $this->Html->link(
                                'Manager',
                                array('controller' => 'withdrawals', 'action' => 'index', 'admin' => true)
                            );
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($userGlobal['group_id'] == 3) {
                            echo $this->Html->link(
                                'Admin',
                                array('controller' => 'statistics', 'action' => 'index', 'admin' => true, 'plugin' => false)
                            );
                        }
                        ?>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


    <?php if ($userGlobal['group_id'] != 5 && $userGlobal['group_id'] != 6): ?>
    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <p class="brand hidden-xs hidden-sm" style="margin-right:3px;"> <img src="https://image.eveonline.com/Character/<?php echo $userGlobal['id']; ?>_64.jpg"></p>
                <h2 class="brand hidden-md hidden-lg"> <?php echo $userGlobal['eve_name']; ?></h2>
            </div>
            <div class="navbar-collapse collapse navbar-user">
                <div class="nav navbar-nav hidden-xs hidden-sm">
                    <h2><?php echo $userGlobal['eve_name']; ?></h2>
                    <p>Next API Check in <span class='api-countdown'></span></p>

                </div>
                <div class="nav navbar-nav navbar-right navbar-user-info">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-user-navbar">
                            <div class="well">
                                <p>
                                    <span id="wallet"><?php echo number_format($userGlobal['wallet'],2); ?></span>
                                    <i class="fa fa-money"></i>
                                    <a id="button-deposit" href="#" onclick="CCPEVE.showInfo(2, 98342107);"><i class="fa fa-plus-square"></i></a>
                                </p>
                                <p><span id="points"><?php echo number_format(floor($userGlobal['tokens'])); ?></span> <span class="badge">Points</span></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-user-navbar">
                            <div class="btn-group-vertical btn-block">
                                <?php $label = 'My Wallet';
                                echo $this->Html->link(
                                    $label,
                                    array('controller' => 'transactions', 'action' => 'index'),
                                    array('class' => 'btn btn-block btn-success', 'escape' => false));
                                ?>
                                <?php $label = 'My Messages';
                                if($userGlobal['nb_new_messages']>0){
                                    $label= $label.' <span class="badge">'.$userGlobal['nb_new_messages'];
                                }
                                echo $this->Html->link(
                                    $label,
                                    array('controller' => 'messages', 'action' => 'index'),
                                    array('class' => 'btn btn-block btn-success', 'escape' => false));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-user-navbar">
                            <div class="btn-group-vertical btn-block">
                                <?php $label = 'My Lotteries';
                                $nbWon = $userGlobal['nb_new_won_lotteries']+$userGlobal['nb_new_won_super_lotteries']+$userGlobal['nb_new_won_flash_lotteries'];
                                if($nbWon>0){
                                    $label= $label.' <span class="badge">'.$nbWon;
                                }
                                echo $this->Html->link(
                                    $label,
                                    array('controller' => 'withdrawals', 'action' => 'index'),
                                    array(
                                        'class' => 'btn btn-block btn-primary',
                                        'escape' => false)
                                );
                                ?>
                                <?php $label = 'My Awards';
                                if($userGlobal['nb_new_awards']>0){
                                    $label= $label.' <span class="badge">'.$userGlobal['nb_new_awards'];
                                }
                                echo $this->Html->link(
                                    $label,
                                    array('controller' => 'awards', 'action' => 'index'),
                                    array(
                                        'class' => 'btn btn-block btn-primary',
                                        'escape' => false)
                                );
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php endif; ?>
<?php else: ?>
    <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-user">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $this->Html->link(
                    'Want to play ? Click on register !',
                    array('controller' => 'users', 'action' => 'register'),
                    array('class' => 'navbar-brand')
                );
                ?>
            </div>
            <div class="navbar-collapse collapse navbar-user">
                <div class="nav navbar-nav navbar-right">
                    <?php
                    echo $this->Html->link(
                        'Register',
                        array('controller' => 'users', 'action' => 'register'),
                        array('class' => 'btn btn-primary navbar-btn')
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php $label = '<strong>Create a New Lottery </strong>';
        if($nbFreeLotteries>0){
            $label= $label.'<span class="badge">'.$nbFreeLotteries.' Available';
        }
        if($this->params['controller'] == 'lotteries' && $this->params['action'] == 'index'){
            echo $this->Html->link(
                $label,
                '#collapse-item',
                array(
                    'class' => 'btn btn-block btn-success new-lot-collapse btn-new-lot',
                    'data-toggle' => 'collapse',
                    'escape' => false,
                )
            );
        }
        else{
            echo $this->Html->link(
                $label,
                array('controller' => 'lotteries', 'action' => 'index_open'),
                array(
                    'class' => 'btn btn-block btn-success new-lot-redirect btn-new-lot',
                    'escape' => false,)
            );
        }
        ?>
    </div>
</div>

<div class="modal fade" id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="deposit-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="deposit-modal-label">Deposit ISK</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="deposit-modal-body">
                    <p>To get EVE-Lotteries credits you must log in the game with the character you used to register and give ISK to the <a id="button-deposit" href="#" onclick="CCPEVE.showInfo(2, 98342107);">EVE-Lotteries Corporation</a>. Once you have deposited any amount of ISK you have to wait until the EVE API refresh our datas to be credited with the same amount of EVE-Lotteries credits. </p>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="center-block"><?php echo $this->Html->image('give_money.png', array('alt' => 'Give Money', 'class' => 'center-block'));?></div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="center-block"><?php echo $this->Html->image('amount.png', array('alt' => 'Set Amount', 'class' => 'center-block'));?></div>
                        </div>
                    </div>
                    <p>There is no need to provide a reason for the transfert.</p>
                    <p>The new API check will take place in <span class='api-countdown'></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        setInterval(updateCountDown, 10);

        $('#button-deposit').click(function(){
            window.scrollTo(0,0);
            $('#deposit-modal').modal('show');
        });
    });
    function updateCountDown() {

        countdown.resetLabels();

        exp_date = "<?php echo $apiCheckTime; ?>";

        if(moment(exp_date).isAfter()){
            $('.api-countdown').html(moment.utc(exp_date).countdown().toString());
        }
        else{
            $('.api-countdown').html("any minute");
        }
    }
</script>