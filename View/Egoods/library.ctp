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
                    <?php echo __('My Library');?>
                </h3>
            </div>
            <div class="col-md-4 text-right"></div>
		</div>
	</div>
    <div class="panel-body items">
        <div class="row">
            <?php if(empty($downloads)):?>
                <div class="col-md-2 col-sm-4 text-warning">
                    <?php echo __('No record found.')?>
                </div>
            <?php else:?>
                <?php foreach ($downloads as $download):?>
                    <div class="col-md-2 col-sm-4">
                        <div class="item">
                            <!-- Item image -->
                            <div class="item-image">
                                <?php 
									if(file_exists($uploadDir.$download['Egood']['photo']) && !is_dir($uploadDir.$download['Egood']['photo'])){
										$photo = $uploadPath.$download['Egood']['photo'];
									}else{
										$photo = "GtwEgoods.no_image.gif";
									}
									echo $this->Html->image($photo,array('url'=>array('controller'=>'egoods','action'=>'view',$download['Egood']['slug'])));
								?>
                            </div>
                            <!-- Item details -->
                            <div class="item-details">
                                <h5>
                                    <?php echo $this->Html->link($download['Egood']['title'],array('controller'=>'egoods','action'=>'view',$download['Egood']['slug']));?>                                    
                                </h5>
                                <div class="text-center">
                                    <?php echo $this->element('GtwEgoods.downloadCount',array('egood_download_count'=>$download['Egood']['egood_download_count']));?> 
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <?php if($paymentSupport){?>
                                    <div class="item-price pull-left">
                                        <?php 
                                            if($download['Egood']['type']){
                                                echo $this->Stripe->showPrice($download['Egood']['price']);
                                            }else{
                                                echo $type[$download['Egood']['type']];
                                            }
                                        ?>
                                    </div>
                                    <div class="button pull-right">
                                         <?php 
		                                    echo $this->Html->actionIcon('fa fa-th', 'view', $download['Egood']['slug']);
		                                    echo '&nbsp|&nbsp';
											echo $this->Html->actionIcon('fa fa-download', 'download', $download['Egood']['slug']);
		                                ?>
                                    </div>
                                <?php }else{?>
                                    <div class="button">
                                        <?php 
		                                    echo $this->Html->actionIcon('fa fa-th', 'view', $download['Egood']['slug']);
		                                    echo '&nbsp|&nbsp';
											echo $this->Html->actionIcon('fa fa-download', 'download', $download['Egood']['slug']);
		                                ?>
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