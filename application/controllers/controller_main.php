<?php
class Controller_Main extends Controller {
<<<<<<< HEAD
    public function __construct()
    {
=======
    public function __construct() {
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
        $this->view = new View();
        $this->model = new Model_main();

    }
<<<<<<< HEAD

    public function action_index($param = NULL)
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
    public function action_likes($param = NULL)
    {
        $this->model->change_likes($param);
=======
    public function action_index($param = NULL) {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
    public function action_likes($param = NULL) {
         $this->model->change_likes($param);
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
    }
    public function action_comments() {
        $this->model->change_comments($_POST['message']);
    }
}