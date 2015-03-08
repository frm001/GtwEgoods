<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
 $this->Helpers->load('GtwStripe.Stripe');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 class="title"><?php echo  __d('gtw_egoods','My Transaction');?></h3></div>
            <div class="col-md-4 text-right"></div>
        </div>
    </div>    
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th width='55%'><?php echo $this->Paginator->sort('title',  __d('gtw_egoods','Title')); ?></th>
                <th width='15%' class='text-right'><?php echo $this->Paginator->sort('price', __d('gtw_egoods','Price')); ?></th>
                <th width='15%'><?php echo $this->Paginator->sort('created', __d('gtw_egoods','Purchase Date')); ?></th>
                <th width='15%' class='text-center'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($sells)){?>
                <tr>
                    <td colspan='4' class='text-warning'><?php echo __d('gtw_egoods','No record found.')?></td>
                </tr>
            <?php 
                }else{
                    foreach ($sells as $sell){
            ?>
                        <tr>
                            <td><?php echo $sell['Egood']['title'];?></td>                          
                            <td class="text-right">
                                <?php echo $this->Stripe->showPrice($sell['Transaction']['amount']);?>
                            </td>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $sell['EgoodSell']['created']); ?></td>
                            <td class="text-center actions">
                                <?php 
                                    echo $this->Html->actionIcon('fa fa-th', 'view', $sell['Egood']['slug']);
                                    echo '&nbsp|&nbsp';
                                    echo $this->Html->actionIcon('fa fa-download', 'download', $sell['Egood']['slug']);
                                ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>    
</div>
