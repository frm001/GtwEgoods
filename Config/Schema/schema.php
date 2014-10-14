<?php 
class GtwEgoodSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $egood_downloads = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'egood_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $egood_sells = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'egood_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'transaction_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $egoods = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'title' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'unsigned' => false, 'comment' => '0 -> Free, 1 -> Paid'),
		'price' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '12,2', 'unsigned' => false),
		'photo' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'attachement' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'egood_download_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'egood_sell_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

}
