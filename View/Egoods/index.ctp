<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
if($paymentSupport){
    $this->Helpers->load('GtwStripe.Stripe');
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8">
                <h3 class="title">
                    <?php echo __d('gtw_egoods','E-Goods');?>
                    <small>
                        <?php 
                            if(!empty($user)){
                                echo $user['User']['first'].' '.$user['User']['last'];
                            } elseif(!empty($egoodCategory)){
								echo __d('gtw_egoods','in %s Category', $egoodCategory['EgoodCategory']['name']);
							}
                        ?>
                    </small>
                </h3>
            </div>
            <div class="col-md-4 text-right"></div>
        </div>
    </div>
    <div class="panel-body items">
        <div class="row">
            <?php if(empty($goods)):?>
                <div class="col-md-2 col-sm-4 text-warning">
                    <?php echo __d('gtw_egoods','No record found.')?>
                </div>
            <?php else:?>
                <?php foreach ($goods as $good):?>
                    <div class="col-md-2 col-sm-4">
                        <div class="item">
                            <!-- Item image -->
                            <div class="item-image">
                                <?php 
                                    if(file_exists($uploadDir.$good['Egood']['photo']) && !is_dir($uploadDir.$good['Egood']['photo'])){
                                        $photo = $uploadPath.$good['Egood']['photo'];
                                    }else{
                                        $photo = "GtwEgoods.no_image.gif";
                                    }
                                    echo $this->Html->image($photo,array('url'=>array('controller'=>'egoods','action'=>'view',$good['Egood']['slug'])));
                                ?>
                            </div>
                            <!-- Item details -->
                            <div class="item-details">
                                <h5>
                                    <?php echo $this->Html->link($good['Egood']['title'],array('controller'=>'egoods','action'=>'view',$good['Egood']['slug']));?>                                    
                                </h5>
                                <div class="category-details"><?php echo (empty($good['EgoodCategory']['name'])?' ':$good['EgoodCategory']['name'])?></div>
                                <div class="text-center">
                                    <?php echo $this->element('GtwEgoods.downloadCount',array('egood_download_count'=>$good['Egood']['egood_download_count']));?> 
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <?php if($paymentSupport){?>
                                    <div class="item-price pull-left">
                                        <?php 
                                            if($good['Egood']['type']){
                                                echo $this->Stripe->showPrice($good['Egood']['price']);
                                            }else{
                                                echo $type[$good['Egood']['type']];
                                            }
                                        ?>
                                    </div>
                                    <div class="button pull-right">
                                        <?php echo $this->Html->actionBtn(__d('gtw_egoods','View Detail'), 'view',array($good['Egood']['slug']),'btn-primary btn-sm')?>
                                    </div>
                                <?php }else{?>
                                    <div class="button">
                                        <?php echo $this->Html->actionBtn(__d('gtw_egoods','View Detail'), 'view',array($good['Egood']['slug']),'btn-primary btn-sm btn-block')?>
                                    </div>
                                <?php }?>                                
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
