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
        ($login === false) ? header("Location: /main") :
$this->view->generate('camera_view.php', 'template_view.php');
    }

   public function action_upload(){
       $result = $this->model->upload();
   }

    public function action_canvas()
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