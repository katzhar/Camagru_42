<?php


class Model_Camera extends Model
{

public function upload_image_base()
{
    if (!isset($_POST['base_img']))
        return ('no_image');
    else {
        $data = explode(',' , $_POST['base_img']);
        $img = imagecreatefromstring(base64_decode($data[1])); //переводим из base64 в изображение
        if ($img === false)
            return 'no_image';
        $image_name = hash('crc32', rand()) . '.jpg'; //хешируем название
        $src = imagecreatefrompng('images/2.png');
        imagesavealpha($src, true); //сохраняем альфа канал у стикера

        $img = imagescale($img, 640, 480); //ставим размер изображения
        $src = imagescale($src, 150, 150);
// объединение изображений
        imagecopy($img, $src, 400, 250, 0, 0, imagesx($src), imagesy($src));
// сохраняем изображение в папку
        imagejpeg($img,  "images/user_image/$image_name");
        //чистим память
        imagedestroy($img);
        imagedestroy($src);
        $this->update_db($image_name);
        return ('success');
    }
}
    private function update_db($image_name) {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'INSERT INTO `Posts` (`User_ID`, `Image`, `Message`, `Creation_Date`) VALUES (?, ?, ?, NOW())';

        $id = $_SESSION['Logged_user_ID'];
        $message = isset($_POST['description']) ? mb_strimwidth($_POST['description'], 0, 250) : null;

        $sth = $pdo->prepare($sql);
        $sth->execute(array($id, $image_name, $message));
    }
    public function upload()
    {
        $path = 'images/user_image/';

// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');
// Максимальный размер файла
        $size = 1024000;
// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array($_FILES['picture']['type'], $types))
                die('Запрещённый тип файла. <a href="#">Попробовать другой файл?</a>');
            // Проверяем размер файла
            if ($_FILES['picture']['size'] > $size)
                die('Слишком большой размер файла. <a href="?">Попробовать другой файл?</a>');
            // Загрузка файла и вывод сообщения
            if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']))
                echo 'Что-то пошло не так';
            else {
                $type = $_FILES['picture']['type'];
                $path = $path . $_FILES['picture']['name'];
                $data = base64_encode(file_get_contents($path));
                echo "<img src='data:$type;base64,$data'>\n";
            }
        }
    }
}