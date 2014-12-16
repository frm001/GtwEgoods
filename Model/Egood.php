<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class Egood extends AppModel {
    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter Title'
            )           
        ),
        'description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter description'
            )           
        )
    );
    public $belongsTo = 'User';
    var $hasMany = array(
        'EgoodDownload' => array(
            'className' => 'EgoodDownload',
            'foreignKey' => 'egood_id',
        ));
        
    public $status = array(
                        1 => 'Active', 
                        0 => 'Inactive',
                        //2 => 'Deleted',
                    );
    public $type = array(
                        1 => 'Paid' ,
                        0 => 'Free',
                    );
    
    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (!empty($this->data[$this->alias]['title'])){
            $id = !empty($this->data[$this->alias]['id'])?$this->data[$this->alias]['id']:0;
            $this->data[$this->alias]['slug'] = $this->__getSlug($this->data[$this->alias]['title'],$id);
        }
        $this->uploadFiles();//Upload Files to server
        return true;
    }
    public function __getSlug($string,$id){
        $this->recursive = -1;
        $slug = strtolower(Inflector::slug($string, '-'));
        $count = $this->find( 'count', array('conditions' => array($this->alias.'.id <>'=>$id,$this->alias . ".slug REGEXP" => "^($slug)(-\d+)?")));
        if($count > 0){
            return $slug . "-" . $count;
        }else{
            return $slug;
        }
    }
    public function getSlugById($id){
        $this->recursive = -1;
        $house = $this->find( 'first', array('fields'=>array("id","slug"),'conditions'=>array($this->alias.".id" => $id)));
        if(!empty($house)){
            return $house[$this->alias]['slug'];
        }
        return false;
    }
    private function uploadFiles(){        
        if(!empty($this->data[$this->alias]['photo']['tmp_name'])){
            $this->data[$this->alias]['photo'] = $this->upload('photo');
        }
        if(!empty($this->data[$this->alias]['attachement']['tmp_name'])){
            $this->data[$this->alias]['attachement'] = $this->upload('attachement');
        }
        
        if(is_array($this->data[$this->alias]['photo'])){
            unset($this->data[$this->alias]['photo']);
        }
        if(is_array($this->data[$this->alias]['attachement'])){
            unset($this->data[$this->alias]['attachement']);
        }
    }
    private function upload($field){
        $ext = pathinfo($this->data[$this->alias][$field]['name'], PATHINFO_EXTENSION);
        $fileName = $this->data[$this->alias]['slug'].'_'.$field.'.'.$ext;
        move_uploaded_file($this->data[$this->alias][$field]['tmp_name'], $this->getPath($fileName));
        return $fileName;
    }

    public function getPath($filename=null){
        $path = WWW_ROOT . 'files'.DS.'uploads'.DS.'egoods'.DS ;
        //Check folder and if not exist then create folder
        $dir = new Folder($path,true,'0777');
        return  !empty($filename)?$path.$filename:$path ;
    }
    public function getUrl($filename=''){
        $path ="/files/uploads/egoods/";
        return  !empty($filename)?$path.$filename:$path ;
    }
    public function getEgoodById($eGoodId)
    {
        return $this->find('first',array(
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
    }
    
    public function getDownloadCount($slug)
    {
        return $this->Egood->find('first',array(
                            'fields'=>array(
                                'id',                                       
                                'egood_download_count'
                            ),
                            'conditions'=>array('slug' => $slug)
                        ));
    }
    
}