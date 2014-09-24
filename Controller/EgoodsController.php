<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
 
class EgoodsController extends AppController {
	public $name = 'Egoods';
	public $helpers = array('Text','Time');
	public $uses = array('GtwEgoods.Egood','GtwEgoods.EgoodDownload');
	
    public function beforeFilter(){
        if (CakePlugin::loaded('GtwUsers')){
            $this->layout = 'GtwUsers.users';
        }
        $this->set('uploadDir',$this->Egood->getPath());
        $this->set('uploadPath',$this->Egood->getUrl());
        $this->Auth->allow('index','view','download','download_count');
    }
	
    public function index($userId = 0) {
        $this->__getEgoods('frontend',$userId);
	}
    public function view($slug=null){
        $eGoodId = $this->__checkExist($slug);
        $goods = $this->Egood->find('first',array(
                        'fields'=>array(
                                'Egood.*','User.id',
                                'User.first',
                                'User.last',
                                'User.email'
                        ),
                        'conditions'=>array(
                            'Egood.id' =>$eGoodId
                        ),
                        'contain' => array(
                            'UserModel'
                        ),
                    ));
        $this->set(compact('goods'));
    }
    public function download($slug=null){
        $this->Egood->recursive = -1;
        $goods = $this->Egood->find('first',array(
                                        'fields'=>array(
                                            'id',
                                            'title',
                                            'slug',
                                            'attachement',
                                            'egood_download_count'
                                        ),
                                        'conditions'=>array('slug' => $slug)
                                    ));
        if(!empty($goods)){
            $filePath = $this->Egood->getPath($goods['Egood']['attachement']);
            if(file_exists($filePath) && !is_dir($filePath)){
                //Add To Download
                $download = array(
                                'EgoodDownload'=>array(
                                   'user_id'   => $this->Session->check('Auth.User.id')?$this->Session->read('Auth.User.id'):0,
                                   'egood_id'  => $goods['Egood']['id'],
                                   'ip'        => env('REMOTE_ADDR'),
                                ));
                $this->EgoodDownload->save($download);
                $this->autoRender = false;
                return $this->response->file($filePath, array('download' => true));
                exit;
            }
        }
        $this->Session->setFlash(__('File Not Found'), 'alert', array(
                                    'plugin' => 'BoostCake',
                                    'class' => 'alert-danger'
                                ));
        $this->redirect($this->referer());        
    }
    public function download_count($slug =null){
        $this->layout = 'ajax';
        $goods = $this->Egood->find('first',array(
                                        'fields'=>array(
                                            'id',                                       
                                            'egood_download_count'
                                        ),
                                        'conditions'=>array('slug' => $slug)
                                    ));
        $this->set(compact('goods'));
    }

    public function listing() {
        $this->__getEgoods('backend');
	}    
    public function add(){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Egood']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Egood->save($this->request->data)) {                
				$this->Session->setFlash(__('The e-good has been created successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'listing'));
            }
			$this->Session->setFlash(__('Unable to add e-good. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
        }
        $this->set('status',$this->Egood->status);
    }
    public function edit($slug=null) {
        $eGoodId = $this->__checkExist($slug);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Egood']['id'] = $eGoodId;
            if ($this->Egood->save($this->request->data)) {
				$this->Session->setFlash(__('The e-good has been saved'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'listing'));
            }
			$this->Session->setFlash(__('The e-good could not be saved. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
        } else {
            $this->request->data = $this->Egood->read(null, $eGoodId);
        }        
        $this->set('status',$this->Egood->status);        
    }
    public function delete($slug=NULL) {
        $eGoodId = $this->__checkExist($slug);
        $this->Egood->id =$eGoodId;
        if($this->Egood->saveField('status',2)){
            $this->Session->setFlash(__('E-Good has been deleted successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
        }else{
            $this->Session->setFlash(__('Unable to delete e-good, Please try again'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
        }
        $this->redirect($this->referer());
    }    
    public function change_status($status,$commentId){
        $arrStatus = array_flip($this->Comment->status);
        if(in_array($status, $arrStatus)){
            $this->Comment->id = $commentId;
            $this->Comment->saveField('status',$arrStatus[$status]);
            $this->Session->setFlash(__('Comment status has been successfully changed to '.$status), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
        }else{
            $this->Session->setFlash(__('Invalid Type, Pleae try again'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
        }
        $this->redirect(array('action' => 'listing'));
    }
    private function __checkExist($slug=null){
        $eGood = $this->Egood->find('first',array('fields'=>array('Egood.id','Egood.slug'),'conditions'=>array('slug'=>$slug)));
        if (empty($eGood)) {
            $this->Session->setFlash(__('Invalid e-good.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            return $this->redirect($this->referer());
        }
        return $eGood['Egood']['id'];
    }
    private function __getEgoods($type='frontend',$userId = 0){
        $conditions = array();        
        if($type=='frontend'){
            $conditions['Egood.status'] = 1; // Display only active Product
        }else{
            $conditions['Egood.status <>'] = 2; //Do not display deleted Goods
            //Display User's Goods if not admin
            if($this->Session->read('Auth.User.role')!='admin'){
                $conditions['Egood.user_id'] = $this->Session->read('Auth.User.id');
            }
        }
        if(!empty($userId)){
            $this->set('user',$this->Egood->User->find('first',array(
                                                        'fields'=>array('first','last'),
                                                        'conditions'=>array('id'=>$userId),
                                                        'recursive'=>-1,
                                                )));
            $conditions['Egood.user_id'] = $userId; // Display User's E-good
        }
		$this->paginate = array(
			'Egood' => array(
                'fields'=>array(
                    'Egood.id',
                    'Egood.user_id',
                    'Egood.title',
                    'Egood.photo',                    
                    'Egood.egood_download_count',
                    'Egood.slug',
                    'Egood.status',
                    'Egood.created',
                    'Egood.modified',
                    'User.id',
                    'User.first',
                    'User.email',
                ),
				'conditions' => $conditions,
				'contain' => array(
					'UserModel'
				),
				'order' => 'Egood.created DESC'
			)
		);
		$this->set('goods', $this->paginate('Egood'));
        $this->set('status',$this->Egood->status);
    }
}