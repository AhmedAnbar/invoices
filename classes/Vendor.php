<?php
class Vendor {
    private $_db,
            $_data;

    
    public function __construct ($vendor = null) {
        $this->_db = DB::getInstance();
        if($vendor){
            $this->find($vendor);
        }
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('vendors', $fields)){
            throw new Exception ('There was a problem creating a vendor.');
        }
    }
    
    public function find($vendor = null) {
        if ($vendor) {
            $data = $this->_db->get('vendors', array('id', '=', $vendor));
            
            if ($data->count()) {
                $this->_data = $data->first();
                return TRUE;
            }
        }
        return FALSE;
    }
    public function update($fields = array(), $id = null) {
        if (!$id) {
            throw new Exception('Please enter vendor id.');
        }
        
        if (!$this->_db->update('vendors', $id, $fields)) {
            throw new Exception('There was a problem updating a vendor.');
        }
    }
    
    public function exists() {
        return (!empty($this->_data)) ? TRUE : FALSE;
    }
    
    public function delete($id){
        if ($this->_db->delete('vendors', array('id', '=', $id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function data() {
        return $this->_data;
    }
    
    
}
?>
