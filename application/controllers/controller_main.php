<?php
class Controller_Main extends Controller {
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_main();

    }

    public function action_index($param = NULL)
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
    public function action_likes($param = NULL)
    {
        $this->model->change_likes($param);
    }
    public function action_signout($param = NULL)
    {
        $this->model->action_signout();
    }
    public function action_comments($param = NULL)
    {
        $this->model->change_comments($param);
    }
}