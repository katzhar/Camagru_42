<?php
        if ($data == Model::ERROR) 
            echo 'ERROR';
        else if ($data == Model::SUCCESS) 
            echo 'SUCCESS'; 
        else if ($data == Model::INCORRECT_LOG_OR_PSSWRD) 
            echo 'INCORRECT_LOG_OR_PSSWRD'; 
            
