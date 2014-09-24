<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
?>
<span class="label label-default">
    <?php 
        if(!$egood_download_count){
            echo __('Be first to Download');
        }elseif($egood_download_count==1){
            echo $egood_download_count.' '.__('Download');
        }else{
            echo $egood_download_count.' '.__('Downloads');
        }
    ?>
</span>