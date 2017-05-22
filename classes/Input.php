<?php
class Input {
    public static function exists($type = 'post') {
      if ($type == 'post' && !empty($_POST)) {
        return true;
      }elseif ($type == 'get' && !empty($_GET)) {
        return true;
      }else {
        return false;
      }
    }

    public static function get($item){
      if (isset($_POST[$item])) {
        return $_POST[$item];
      } elseif (isset($_GET[$item])) {
        return $_GET[$item];
      }
      return '';
    }

}
?>
