<?php
class Model_Auth extends Model {

    public function check_user($login, $password) 
    {
        include "config/database.php";
        $hash_passwd = hash("whirlpool", $password);
        try
		{
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$query = "SELECT * FROM users WHERE login = ? AND password = ?";
			$stmt = $dbh->prepare($query);
			$stmt->execute(array($login, $hash_passwd));
			$data = $stmt->fetch();
			if ($data) {
				$_SESSION['login'] = $data['login'];
				$_SESSION['password'] = $data['password'];
				return Model::SUCCESS;
			}
			else
				return Model::INCORRECT_LOG_OR_PSSWRD;
		}
		catch (PDOException $ex) {
            return Model::ERROR;
        }
    }
}


// class Model_Auth extends Model {

//     public function check_user($login, $password) {
//         include "config/database.php";
//         $dbh = new PDO($dsn, $db_user, $db_password, $options);
//         $dbh->exec('USE camagru_db');
//         $query = "SELECT * FROM users WHERE login=?";
//         $stmt = $dbh->prepare($query);
//         $stmt->bindparam('ss', $login, $password);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $user = $result->fetch_assoc();
//         if (password_verify($password, $user['password'])) { // if password matches
//         $stmt->close();
//         $_SESSION['login'] = $user['login'];
//         header('location: ../index.php');
//         exit(0);
//     }
//             return Model::SUCCESS;
        
//         return Model::INCORRECT_LOG_OR_PSSWRD;
//     }
// }