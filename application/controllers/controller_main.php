<?php
class Controller_Main extends Controller {

    public function __construct() {
        $this->view = new View();
        $this->model = new Model_main();
    }

    public function action_index($param = NULL) {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
    public function action_likes($param = NULL) {
         $this->model->change_likes($param);
    }
    public function action_comments($param = NULL) {
        $this->model->change_comments();
    }
    public function action_delete($param = NULL) {
        $data = $this->model->delete($param);
    }
}