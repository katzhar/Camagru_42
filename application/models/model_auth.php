<?php

class Model_Auth extends Model {
        public function getlogin() {
        if (isset($_REQUEST['login']) && isset($_REQUEST['password'])) {
            if ($_REQUEST['login'] == 'root' && $_REQUEST['password'] == 'root') {
                return 'OK';
            }
            else {
                return 'ERROR';
            }
        }
    }
}
