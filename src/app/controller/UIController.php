<?php

class UIController {
    static public function getUserInformation() {

         $app = \Slim\Slim::getInstance();
         $app->view()->layout = "_layout.twig";

         if(!isset($_SESSION['APP']['ADMIN']['MENU']['LEFT'])) {
             $_SESSION['APP']['ADMIN']['MENU']['LEFT'] = false;
         }

         $app->view()->appendData(array(
             'MENU_LEFT' => $_SESSION['APP']['ADMIN']['MENU']['LEFT']
         ));

         $app->pass();
     }

    //function to render frontend from dashboard.twig contained in view folder

    static public function dashboard() {
        App::render('dashboard.twig');
    }
    static public function delLog() {
        App::delLog();
        App::redirect("/");
    }
}
