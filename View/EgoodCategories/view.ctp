<div class="gtwServices">            
    <div class="pull-right">
        <?php
            if($this->Session->read('Auth.User.role') =='admin'){
                echo $this->Html->actionIconBtn('fa fa-pencil',__(' Edit This'),'edit',$egoodCategory['EgoodCategory']['id'],'btn-primary');
            }
        ?>
    </div>
    <h1><?php echo __('Egood Category Detail');?></h1>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th class="col-md-2"><?php echo __('Name')?></th>
                    <td class="col-md-10"><?php echo $egoodCategory['EgoodCategory']['name']?>&nbsp;</td>
                </tr>
                <?php if($this->Session->read('Auth.User.role') =='admin'):?>
                    <tr>
                        <th class="col-md-2"><?php echo __('Total Egoods')?></th>
                        <td class="col-md-10"><?php echo $egoodCategory['EgoodCategory']['egood_count']?>&nbsp;</td>
                    </tr>
                    <tr>
                        <th class="col-md-2"><?php echo __('Added On')?></th>
                        <td class="col-md-10"><?php echo $this->Time->format('Y-m-d H:i:s', $egoodCategory['EgoodCategory']['created'])?>&nbsp;</td>
                    </tr>
                    <tr>
                        <th class="col-md-2"><?php echo __('Updated On')?></th>
                        <td class="col-md-10"><?php echo $this->Time->format('Y-m-d H:i:s', $egoodCategory['EgoodCategory']['modified'])?>&nbsp;</td>
                    </tr>
                <?php endif;?>
                <tr>
                    <th class="col-md-2"><?php echo __('Description')?></th>
                    <td class="col-md-10"><?php echo $egoodCategory['EgoodCategory']['description']?>&nbsp;</td>
                </tr>
            </table>
        </div>                
    </div>
</div>
