<?php
class User {
    private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
    public function __construct ($user = null) {
        $this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		
		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn = TRUE;
				} else {
					// process log out
				}
			}
		} else {
			$this->find($user);
		}
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)){
            throw new Exception ('There was a problem creating a user account.');
        }
    }
	
	public function find($user = null) {
		if ($user) {
			$field = (is_numeric($user)) ? 'id' : 'userName';
			$data = $this->_db->get('users', array($field, '=', $user));
			
			if ($data->count()) {
				$this->_data = $data->first();
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function login($username = null, $password = null, $remember = FALSE){
		
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);	
			if ($user) {
				if ($this->data()->userPassword === Hash::make($password, $this->data()->userSalt)) {
					Session::put($this->_sessionName, $this->data()->id);
					
					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('userId', '=', $this->data()->id));
						
						if (!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'userId' => $this->data()->id,
								'Hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->Hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return TRUE;
				}  
			}
		}
		return FALSE;
	}
	
	public function update($fields = array(), $id = null) {
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		
		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating.');
		}
	}
	
	public function hasPermission($key) {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->userGroup));
		if ($group->count()) {
			$permissions = json_decode($group->first()->groupPermission, TRUE);
			
			if ($permissions[$key] == TRUE) {
				return TRUE;
			}	
		}
		return FALSE;
	}
	
	public function exists() {
		return (!empty($this->_data)) ? TRUE : FALSE;
	}
    
    public function delete($id){
        if ($this->_db->delete('users', array('id', '=', $id))) {
            return TRUE;
        }
        return FALSE;
    }
	
	public function logout() {
		
		$this->_db->delete('users_session', array('userId', '=', $this->data()->id));
		
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data() {
		return $this->_data;
	}
	
	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
}
?>
