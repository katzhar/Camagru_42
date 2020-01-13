<?php
class Model_Registration extends Model {
    public function get_data() {
        if ($_POST['login'] && $_POST['password'] && $_POST['submit'] && $_POST['submit'] == "SignUp") {
			if (!file_exists('../private'))
				mkdir("../private");
			if (!file_exists('../private/passwd'))
				file_put_contents('../private/passwd', null);
			$arr = unserialize(file_get_contents('../private/passwd'));
			if ($arr) {
				foreach ($arr as $user) {
					if ($user['login'] == $_POST['login']) {
						echo "ERROR\n";
						return ;
					}
				}
			}
			$log['login'] = $_POST['login'];
			$log['password'] = hash('whirlpool', $_POST['password']);
			$arr[] = $log;
			file_put_contents('../private/passwd', serialize($arr));
			echo "OK\n";
	}
	else
		echo "ERR\n";
	}
}