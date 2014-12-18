<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
 
class EgoodsController extends AppController
{
    public $name = 'Egoods';
    public $helpers = array('Text','Time');
    public $uses = array('GtwEgoods.Egood','GtwEgoods.EgoodDownload','GtwEgoods.EgoodSell','GtwEgoods.EgoodCategory');
    public $paymentSupport = false;
    public function beforeFilter()
    {
        if (CakePlugin::loaded('GtwUsers')){
            $this->layout = 'GtwUsers.users';
        }
        if (CakePlugin::loaded('GtwStripe')){
            $this->paymentSupport = true;            
        }
        $this->set('paymentSupport',$this->paymentSupport);
        $this->set('type',$this->Egood->type);
        $this->set('uploadDir',$this->Egood->getPath());
        $this->set('uploadPath',$this->Egood->getUrl());
        $this->Auth->allow('index','view','download','download_count');
    }
    
    public function index($userId = 0, $egoodCategoryId = 0)
    {
        $this->__getEgoods('frontend',$userId, $egoodCategoryId);
    }
    public function view($slug=null)
    {
        $eGoodId = $this->__checkExist($slug);
        $goods = $this->Egood->getEgoodById($eGoodId);
        //Check for Purchase
        $this->__trackPurchase($goods);
        $this->set('allowToDownload',$this->EgoodSell->checkSell($this->Session->read('Auth.User.id'),$goods['Egood']['id']));
        $this->set(compact('goods'));
    }
    public function download($slug=null)
    {
        $this->Egood->recursive = -1;
        $goods = $this->Egood->find('first',array(
                                        'fields'=>array(
                                            'id',
                                            'title',
                                            'slug',
                                            'attachement',
                                            'egood_download_count',
                                            'type'
                                        ),
                                        'conditions'=>array('slug' => $slug)
                                    ));
        if(!empty($goods)){
            if($goods['Egood']['type']!=0 && !$this->EgoodSell->checkSell($this->Session->read('Auth.User.id'),$goods['Egood']['id'])){
                $this->Session->setFlash(__('Invalid Download'), 'alert', array(
                                    'plugin' => 'BoostCake',
                                    'class' => 'alert-danger'
                                ));
                $this->redirect($this->referer());  
            }
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
    public function download_count($slug =null)
    {
        $this->layout = 'ajax';
        $goods = $this->Egood->getDownloadCount($slug);
        $this->set(compact('goods'));
    }

    public function listing($userId = 0) {
    	if($this->Session->read('Auth.User.role') != 'admin'){
    		$userId = 0;
    	}
        $this->__getEgoods('backend', $userId);
    }    
    public function add()
    {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Egood']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Egood->save($this->request->data)) {                
                $this->Session->setFlash(__('The e-good has been created successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                $this->EgoodCategory->recursive = -1;
                return $this->redirect(array('action' => 'listing'));
            }
            $this->Session->setFlash(__('Unable to add e-good. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
        }
        $egoodCategories = $this->EgoodCategory->find('list',array('fields'=>array('EgoodCategory.id','EgoodCategory.name')));
        $this->set('egoodCategories',$egoodCategories);
        $this->set('status',$this->Egood->status);
    }
    public function edit($slug=null)
    {
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
			$egoodCategories = $this->EgoodCategory->find('list',array('fields'=>array('EgoodCategory.id','EgoodCategory.name')));
			$this->set('egoodCategories',$egoodCategories);
            $this->request->data = $this->Egood->read(null, $eGoodId);
        }        
        $this->set('status',$this->Egood->status);        
    }
    public function delete($slug=NULL)
    {
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
    public function change_status($status,$commentId)
    {
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
    private function __checkExist($slug=null)
    {
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
    private function __getEgoods($type='frontend',$userId = 0, $egoodCategoryId = 0)
    {
        $conditions = array();        
        if($type=='frontend'){
            $conditions['Egood.status'] = 1; // Display only active Product
            if(!$this->paymentSupport){
                $conditions['Egood.type'] = 0; // Display only active Product    
            }
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
        } elseif(!empty($egoodCategoryId)){
			$this->set('egoodCategory',$this->EgoodCategory->find('first',array(
                                                        'fields'=>array('id','name'),
                                                        'conditions'=>array('id'=>$egoodCategoryId),
                                                        'recursive'=>-1,
                                                )));
			$conditions['Egood.egood_category_id'] = $egoodCategoryId; // Display Only Selected Category
		}
        $this->paginate = array(
            'Egood' => array(
                'fields'=>array(
                    'Egood.id',
                    'Egood.user_id',
                    'Egood.title',
                    'Egood.photo',
                    'Egood.egood_category_id',
                    'Egood.egood_download_count',
                    'Egood.type',
                    'Egood.price',
                    'Egood.slug',
                    'Egood.status',
                    'Egood.created',
                    'Egood.modified',
                    'User.id',
                    'User.first',
                    'User.email',
                    'EgoodCategory.id',
                    'EgoodCategory.name',
                ),
                'conditions' => $conditions,
                'contain' => array(
                    'UserModel',
                    'EgoodCategoryModel'
                ),
                'order' => 'Egood.created DESC'
            )
        );
        $this->set('goods', $this->paginate('Egood'));
        $this->set('status',$this->Egood->status);
    }
    public function transaction()
    {
        $conditions = array();        
        $conditions['Egood.status'] = 1; // Display only active Product
        $conditions['EgoodSell.user_id'] = $this->Session->read('Auth.User.id');
        $this->paginate = array(
            'EgoodSell' => array(
                'fields'=>array(
                    'EgoodSell.*',
                    'Egood.id',
                    'Egood.title',
                    'Egood.photo',                    
                    'Egood.price',
                    'Egood.slug',
                    'Transaction.amount',
                    'Transaction.brand',
                    'Transaction.last4',
                ),
                'conditions' => $conditions,
                'contain' => array(
                    'UserModel'
                ),
                'order' => 'Egood.created DESC'
            )
        );
        $this->set('sells', $this->paginate('EgoodSell'));
    }
    private function __trackPurchase($goods = array())
    {
        if($this->paymentSupport){
            if(!empty($this->request->named['transaction'])){
                $this->Transac = $this->Components->load('GtwStripe.Transac');
                $transaction = $this->Transac->getLastTransaction($this->request->named['transaction']);
                if(!empty($transaction)){
                    $this->EgoodSell->addToSell($transaction['Transaction'],$goods['Egood']['id']);
                     $this->Session->setFlash(__('Thank you for buy "<b>%s</b>", Now you can download it from this page or from your My Account section',$goods['Egood']['title']), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                }else{
                    $this->Session->setFlash(__('Unable to process your payment request, Please try again'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                )); 
                }
            }
        }
    }
    
    /* To show list of all downloaded Egoods by user*/
    public function library(){
    	$conditions = array();
    	$conditions['Egood.status'] = 1; // Display only active Product
    	$conditions['EgoodDownload.user_id'] = $this->Session->read('Auth.User.id');
    	$this->paginate = array(
    			'EgoodDownload' => array(
    					'fields'=>array(
    							'EgoodDownload.*',
    							'Egood.id',
			                    'Egood.user_id',
			                    'Egood.title',
			                    'Egood.photo',                    
			                    'Egood.egood_download_count',
			                    'Egood.type',
			                    'Egood.price',
			                    'Egood.slug',
			                    'Egood.status',
			                    'Egood.created',
			                    'Egood.modified'
    					),
    					'conditions' => $conditions,
    					'contain' => array(
    							'UserModel'
    					),
    					'group' => array('EgoodDownload.egood_id'),
    					'order' => 'Egood.created DESC'
    			)
    	);
    	$this->set('downloads', $this->paginate('EgoodDownload'));
    }
}
