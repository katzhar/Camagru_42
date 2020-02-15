<?php
session_start();
class Model_Camera extends Model
{
    public function authenticate()
    {
        if (!isset($_SESSION['login']))
            return false;
        return true;
    }

    public function upload_image_base_tmp()
    {
        if (!isset($_POST['base_img']))
            return ('no_image');
        else {
            $sticker = $_POST['sent_sticker'];
            $sticker = explode('_', $sticker);
            $sticker[2] = intval($sticker[2]);
            $sticker[3] = intval($sticker[3]);
            $data = explode(',', $_POST['base_img']);
            $img = imagecreatefromstring(base64_decode($data[1])); //переводим из base64 в изображение
            if ($img === false)
                return 'no_image';
            $image_name = hash('crc32', rand()) . '.jpg'; //хешируем название
            $src = imagecreatefrompng('images/' . $sticker[1] . '.png');
            imagesavealpha($src, true); //сохраняем альфа канал у стикера
            $img = imagescale($img, 640, 480); //ставим размер изображения
            $src = imagescale($src, 180, 180);
// объединение изображений
            imagecopy($img, $src, $sticker[2] - 28, $sticker[3] - 127, 0, 0, imagesx($src), imagesy($src));
// сохраняем изображение в папку
            imagejpeg($img, "images/user_image/$image_name");
            //чистим память
            imagedestroy($img);
            imagedestroy($src);
            $this->update_dbtmp($image_name);
            return ('success');
        }
    }

    public function upload_image_base()
    {
        if (!isset($_POST['data']))
            return ('no_image');
        else {

            $data = explode('_', $_POST['data']);
            $this->update_db($data);
            return ('success');
        }
    }
    private function update_db($data)
    {
        require 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'SELECT * FROM tmp_img WHERE id = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($data[0]));
        $postimg = $sql->fetch();
        $sql = 'INSERT INTO `post_img` (`User_ID`, `Image`, `Message`, `Creation_Date`) VALUES (?, ?, ?, NOW())';
        $id = $_SESSION['id'];
        $message =htmlspecialchars($data[1]);
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id, $postimg['Image'], $message));
        $sql = 'DELETE FROM tmp_img WHERE `id` = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($data[0]));

    }

    public function upload()
    {
        if (isset($_FILES['picture']['type']) && $_FILES['picture']['type'] != NULL) {
            $path = 'images/user_image/';
            $type = explode('/', $_FILES['picture']['type']);
            $image_name = hash('crc32', rand()) . '.' . $type[1]; //хешируем название
// Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg');
// Максимальный размер файла
            $size = 100240000;
// Обработка запроса
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Проверяем тип файла
                if (!in_array($_FILES['picture']['type'], $types))
                {
                    $_SESSION['message'] = "Запрещённый тип файла";
                    header('Location: /camera');
                    exit();
                }
                // Проверяем размер файла
                if ($_FILES['picture']['size'] > $size)
                {
                    $_SESSION['message'] = "Слишком большой размер файла";
                    header('Location: /camera');
                    exit();
                }
                // Загрузка файла и вывод сообщения
                if (!@copy($_FILES['picture']['tmp_name'], $path . $image_name))
                    echo 'Что-то пошло не так';
                else {
                    $img = base64_encode(file_get_contents($path . $image_name));
                    $_SESSION['user_file'] = 'data:image/png;base64,'. $img;
                    $this->update_dbuserfile($image_name);
                    header('Location:/camera');
                }
            }
        }
        else
        {
            $_SESSION['message'] = "Прикрепите фото";
            header('Location:/camera');
            exit();
        }
    }

    private function update_dbtmp($image_name)
    {
        require 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'INSERT INTO `tmp_img` (`User_ID`, `Image`) VALUES (?, ?)';
        $id = $_SESSION['id'];
        $sql = $pdo->prepare($sql);
        $sql->execute(array($id, $image_name));
    }
    private function update_dbuserfile($image_name)
    {
        require 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'INSERT INTO `tmp_img` (`User_ID`, `Image`, `User_file`) VALUES (?, ?, 1)';
        $id = $_SESSION['id'];
        $sql = $pdo->prepare($sql);
        $sql->execute(array($id, $image_name));
        $sql = 'SELECT id FROM `tmp_img`  WHERE Image = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($image_name));
        $data = $sql->fetch();
        $_SESSION['id_user_file'] = $data['id'];
    }

    public function get_datatmp()
    {
        require 'config/database.php';

        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $id = $_SESSION['id'];
        $sql = 'SELECT * FROM tmp_img WHERE User_file = ? AND User_ID = ? ORDER BY id DESC limit 3';
        $sql = $pdo->prepare($sql);
        $sql->execute(array(0,$id));
        $data = $sql->fetchAll();
        return ($data);
    }
}

