<div id="user-navbar">
    <?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-12 col-md-offset-1">
                <h2><?php echo __('Wage'); ?></h2>

                <h3>
                    <?php echo __('Status : '); ?> <?php echo h($wage['Wage']['status']); ?>
                    <p class="pull-right"><?php if($wage['Wage']['status'] == 'unclaimed'){echo $this->Html->link(__('Claim'), array('action' => 'claim', $wage['Wage']['id']));} ?></p>
                </h3>

                <h4><?php echo __('Amount : '); ?> <?php echo h(number_format($wage['Wage']['amount'], 2).' ISK'); ?></h4>
                <h4><?php echo __('Creation date : '); ?> <?php echo h($wage['Wage']['created']); ?></h4>


            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-sm-12 col-md-offset-1">
                <h3>Withdrawals linked to this wage</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Player</th>
                        <th>Claimed as</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($claimed_awards as $claimed_award){?>
                        <tr>
                            <td><img src="https://image.eveonline.com/Character/<?php echo $claimed_award['User']['id']; ?>_32.jpg"></td>
                            <td>
                                <?php echo $claimed_award['User']['eve_name']; ?>
                            </td>

                            <td>
                                <?php
                                switch ($claimed_award['Withdrawal']['type']) {
                                    case 'award_isk':
                                        echo number_format($claimed_award['Withdrawal']['value'], 2).' ISK';
                                        break;
                                    case 'award_item':
                                        echo $claimed_award['Withdrawal']['value'];
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $claimed_award['Withdrawal']['modified']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
