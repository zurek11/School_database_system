<?php

class TeachersController{

    static public function index(){
        $conn = new Database();

        //filling table with teachers
        $sql = "SELECT teacher.id, teacher.name, teacher.surname FROM teacher ";

        //search teachers by name and surname
        $values = array();
        if (!empty($_GET['search'])) {
            $sql .= "WHERE coalesce(name, '') || ' ' || coalesce(surname, '') ILIKE ? ";
            $values[] = "%" . $_GET['search'] . "%";
        }

        //paging of teachers table
        $_GET['offset'] = (empty($_GET['offset']) || !filter_var($_GET['offset'], FILTER_VALIDATE_INT) || $_GET['offset'] < 0) ? 0 : $_GET['offset'];
        $sql .= "GROUP BY teacher.id LIMIT 8 OFFSET " . $_GET['offset'] * 8;

        $stmt = $conn->prepare($sql);
        $stmt->execute($conn->execute($values));
        $people = $stmt->fetchAll();

        App::log($sql); //prints query to log.txt in doc
        App::render('teachers.twig', array(
            'people' => $people,
            'search' => $_GET
        ));
    }

    //function called, when the user wants to add or edit a teacher
    //(function will redirect user to the new link with the new menu)

    static public function indexGet($id = null) {

        //if id of the teacher is not empty function gets from database teacher information
        if(!empty($id)){
            $conn = new Database();
            $stmt = $conn->prepare("SELECT * FROM teacher WHERE id=?");
            App::log("SELECT * FROM teacher WHERE id=?");
            $stmt->execute($conn->execute(array(
                $id
            )));
            $person = $stmt->fetch();
        }
        //function to render frontend from teachers-add-edit.twig contained in view folder
        App::render('teachers-add-edit.twig', array(
            '_POST' => !empty($id) ? $person : null,
            'id' => $id
        ));
    }

    //function called, when user wants to add or edit a teacher
    //(if the user just clicked on the add or delete button)

    static public function indexPost($id = null) {
        $validator = new Validation();
        $rules = array(
            'name' => 'required',
            'surname' => 'required'
        );

        $validated = $validator->validate($_POST, $rules);

        //if user filled all textFiles with good data
        if($validated === true) {
            $values = array(
                $_POST['name'],
                $_POST['surname']
            );

            if (empty($id)) {	//add new student to the table
                $sql = "INSERT INTO teacher (name, surname) VALUES (?, ?)";
                App::log($sql);
            }
            else {				//edit teacher in the table
                $values[] = $id;
                $sql = "UPDATE teacher SET name = ?, surname = ? WHERE id = ?";
                App::log($sql);
            }

            $conn = new Database();
            $stmt = $conn->prepare($sql);
            $stmt->execute($conn->execute($values));

            $type = "success";
            $alerts = "Success!";
        }
        else {
            $type = "negative";
            $alerts = $validator->get_errors();
        }
        App::render('teachers-add-edit.twig', array(
            'id' => $id,
            'type' => $type,
            'alerts' => $alerts,
            '_POST' => empty($id) ? (( $type == 'success') ? null : $_POST) : $_POST
        ));
    }

    //function called, when user wants to delete a teacher

    static public function indexDelete($id){
        $conn = new Database();

        $stmt = $conn->prepare("DELETE FROM teacher WHERE id = ?");
        App::log("DELETE FROM teacher WHERE id = ?");
        $stmt->execute($conn->execute([$id]));
    }
}