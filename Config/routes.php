<?php
Router::parseExtensions('rss');

Router::connect('/egoods', array('plugin' => 'gtw_egoods', 'controller' => 'egoods'));
Router::connect('/egoods/listing', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'listing'));
Router::connect('/egoods/listing/*', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'listing'));
Router::connect('/egoods/library', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'library'));
Router::connect('/egoods/add', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'add'));
Router::connect('/egoods/view/*', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'view'));
Router::connect('/egoods/edit/*', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'edit'));
Router::connect('/egoods/delete/*', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'delete'));
Router::connect('/egoods/download/*', array('plugin' => 'gtw_egoods', 'controller' => 'egoods','action'=>'download'));