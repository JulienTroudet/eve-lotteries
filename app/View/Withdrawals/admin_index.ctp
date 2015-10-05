<div id="wrapper" >
    <?php
    echo $this->element('ManagerMenu', array());
    ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="awards index">
                <h2>Ongoing Withdrawals</h2>
                <div id="list-awards">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Player</th>
                                    <th>Date</th>
                                    <th>Claimed as</th>
                                    <th>Manager</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($claimed_awards as $claimed_award):?>
                                    <tr>
                                        <td>
                                            <img src="https://image.eveonline.com/Character/<?php echo $claimed_award['User']['id']; ?>_32.jpg">
                                        </td>
                                        <td>
                                            <?php echo $claimed_award['User']['eve_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $claimed_award['Withdrawal']['modified']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($claimed_award['Withdrawal']['type']) {
                                                case 'award_isk':
                                                    echo number_format($claimed_award['Withdrawal']['value'], 2).' ISK';
                                                    break;
                                                case 'award_item':
                                                    echo $claimed_award['Ticket']['Lottery']['name'];
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td >
                                            <?php echo $claimed_award['Admin']['eve_name']; ?>
                                        </td>
                                        <td >
                                            <?php echo $claimed_award['Withdrawal']['status']; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <ul class="pager">
                            <li class="previous">
                                <?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
                            </li>
                            <li>
                                <?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>
                            </li>
                            <li class="next">
                                <?php
                                echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


