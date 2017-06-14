<?php

	$app->map('/(:url)', array('UIController', 'getUserInformation'))
			->conditions(array('url' => '.*'))
			->via('GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS');


    $app->get('/(/)', array('UIController', 'dashboard'));				            //Main menu
	$app->get('/students(/:search)(/)', array('StudentsController', 'index'));	    //the link calls method index StudentsController
    $app->get('/student/:id/detail(/)', array('StudentsController', 'indexDetail'));
    $app->post('/student/:id/detail(/)', array('StudentsController', 'indexDetail'));
    $app->get('/student/add(/)', array('StudentsController', 'indexGet'));		    //the link calls method indexGet in StudentsController
	$app->post('/student/add(/)', array('StudentsController', 'indexPost'));	    //the link calls method indexPost in StudentsController
	$app->get('/student/:id/edit(/)', array('StudentsController', 'indexGet'));	    //the link calls method indexGet in StudentsController
	$app->post('/student/:id/edit(/)', array('StudentsController', 'indexPost'));	//the link calls method indexPost in StudentsController
    $app->delete('/student/:id/delete(/)', array('StudentsController', 'indexDelete')); //the link calls method indexDelete in StudentsController

    $app->get('/teachers(/:search)(/)', array('TeachersController', 'index'));	    //the link calls method index TeachersController
    $app->get('/teacher/add(/)', array('TeachersController', 'indexGet'));		    //the link calls method indexGet in TeachersController
    $app->post('/teacher/add(/)', array('TeachersController', 'indexPost'));	    //the link calls method indexPost in TeachersController
    $app->get('/teacher/:id/edit(/)', array('TeachersController', 'indexGet'));	    //the link calls method indexGet in TeachersController
    $app->post('/teacher/:id/edit(/)', array('TeachersController', 'indexPost'));	//the link calls method indexPost in TeachersController
    $app->delete('/teacher/:id/delete(/)', array('TeachersController', 'indexDelete')); //the link calls method indexDelete in TeachersController

    $app->get('/delLog(/)', array('UIController', 'delLog'));
    $app->get('/app/session/:first(/:second(/:third(/))(/))(/)', array('CoreController', 'sessionVariableToggle'));
