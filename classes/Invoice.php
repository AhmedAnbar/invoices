<?php
class Invoice {
    private $_db,
            $_data;

    
    public function __construct ($invoice = null) {
        $this->_db = DB::getInstance();
        if($invoice){
            $this->find($invoice);
        }
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('invoices', $fields)){
            throw new Exception ('There was a problem creating a invoice.');
        }
    }
    
    public function find($invoice = null) {
        if ($invoice) {
            $data = $this->_db->get('invoices', array('id', '=', $invoice));
            
            if ($data->count()) {
                $this->_data = $data->first();
                return TRUE;
            }
        }
        return FALSE;
    }
    public function update($fields = array(), $id = null) {
        if (!$id) {
            throw new Exception('Please enter invoice id.');
        }
        
        if (!$this->_db->update('invoices', $id, $fields)) {
            throw new Exception('There was a problem updating.');
        }
    }
    
    public function exists() {
        return (!empty($this->_data)) ? TRUE : FALSE;
    }
    
    public function delete($id){
        if ($this->_db->delete('invoices', array('id', '=', $id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function data() {
        return $this->_data;
    }
    
    
}
?>
