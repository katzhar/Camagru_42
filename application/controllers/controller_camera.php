<?php

class Controller_Camera extends Controller
{

    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Camera();
    }

    public function action_index($param = NULL)
    {
        $login = $this->model->authenticate();

        if ($login === false)
            header("Location: /main");
        else {
            $data = $this->model->get_datatmp();
            $this->view->generate('camera_view.php','camera_view.php', $data);
        }
    }

    public function action_upload()
    {
        $result = $this->model->upload();
    }

    public function action_canvas()
    {

        $result = $this->model->upload_image_base_tmp();

        switch ($result) {
            case 'success':
                header("Location: /camera");
                break;
            case 'no_image':
                header("Location: /main");
                break;
        }
    }


    public function action_get_post()
    {

        $result = $this->model->upload_image_base();

        switch ($result) {
            case 'success':
                header("Location: /main");
                break;
            case 'no_image':
                header("Location: /camera");
                break;
        }
    }
}