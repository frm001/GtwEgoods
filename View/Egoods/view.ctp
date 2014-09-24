<?php 
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
 
$this->Helpers->load('GtwRequire.GtwRequire');
echo $this->GtwRequire->req($this->Html->url('/',true).'GtwEgoods/js/egoods.js');
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
            <div class="col-xs-8">
                <h3 class="title"><?php echo __('E-Goods Detail');?></h3>
            </div>
            <div class="col-xs-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply',__(' Back'),'index'); ?></div>
		</div>
	</div>
    <div class="panel-body items">
        <div class="row">
            <div class="col-md-4">
				<?php 
					if(file_exists($uploadDir.$goods['Egood']['photo']) && !is_dir($uploadDir.$goods['Egood']['photo'])){
						echo $this->Html->image($uploadPath.$goods['Egood']['photo'],array('class'=>'img-responsive'));
					}else{
						echo $this->Html->image("GtwEgoods.no_image.gif",array('class'=>'img-responsive'));
					}
				?>
                <?php if (CakePlugin::loaded('GtwComments')):?>
                    <div class="egoodComments hidden-sm">
                        <h3 class="title"><?php echo __('Comments')?></h3>
                        <?php echo $this->element('GtwComments.comment',array('model'=>'Egood','refId'=>$goods['Egood']['id']));?>
                    </div>                    
                <?php endif;?>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <h3><?php echo $goods['Egood']['title']?></h3>
                </div>
                <div class="form-group" id="egood_download_count" data-url="<?php echo $this->Html->url(array('controller'=>'egoods','action'=>'download_count',$goods['Egood']['slug']));?>">
                    <?php echo $this->element('GtwEgoods.downloadCount',array('egood_download_count'=>$goods['Egood']['egood_download_count']));?> 
                </div>
                <div class="form-group">
                    <?php 
                        echo __("Added by ");
                        echo $this->Html->link($goods['User']['first'].' '.$goods['User']['last'],array('controller'=>'egoods','action'=>'index',$goods['User']['id']));
                    ?>
                </div>
                <div class="form-group">
                    <?php echo __("Added on ").$goods['Egood']['modified']?>
                </div>                
                <div class="form-group">
                    <?php echo $this->Html->actionIconBtn('fa fa-download', __(' Download now'), 'download',array($goods['Egood']['slug']),'btn-danger');?>
                </div>
                <div class="form-group">
                    <?php echo $goods['Egood']['description']?>
                </div>
            </div>
        </div>
    </div>
</div>