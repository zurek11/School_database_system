<?php

class StudentsController {

    //function to handle whole main student window

    static public function index(){
		$conn = new Database();

		//filling table with students
		$sql = "SELECT
          student.id, student.name, student.surname, count(scholarship.id) AS count_scholarship
          FROM student
          LEFT JOIN scholarship ON (student.id=scholarship.student_id)
          ";

		//search students by name and surname
		$values = array();
        if (!empty($_GET['search'])) {
            $sql .= "WHERE coalesce(name, '') || ' ' || coalesce(surname, '') ILIKE ? ";
            $values[] = "%" . $_GET['search'] . "%";
        }

        //paging of students table
        $_GET['offset'] = (empty($_GET['offset']) || !filter_var($_GET['offset'], FILTER_VALIDATE_INT) || $_GET['offset'] < 0) ? 0 : $_GET['offset'];
        $sql .= "GROUP BY student.id LIMIT 8 OFFSET " . $_GET['offset'] * 8;

		$stmt = $conn->prepare($sql);
		$stmt->execute($conn->execute($values));
		$people = $stmt->fetchAll();

		App::log($sql); //prints query to log.txt in doc
		App::render('students.twig', array(
            'people' => $people,
            'search' => $_GET
		));
	}

	//function called, when the user wants to add or edit a student
    //(function will redirect user to the new link with the new menu)

	static public function indexGet($id = null) {

        //if id of the student is not empty function gets from database student information
		 if(!empty($id)){
			$conn = new Database();
			$sql = "SELECT * FROM student WHERE id=?";
			$stmt = $conn->prepare($sql);
			App::log($sql);
 			$stmt->execute($conn->execute(array(
				$id
			)));
 			$person = $stmt->fetch();
		 }
        //function to render frontend from students-add-edit.twig contained in view folder
		 App::render('students-add-edit.twig', array(
			 '_POST' => !empty($id) ? $person : null,
			 'id' => $id
		 ));
	 }

    //function called, when user wants to add or edit a student
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
		   		$sql = "INSERT INTO student (name, surname) VALUES (?, ?)";
                App::log($sql);
		   	}
		   	else {				//edit student in the table
				$values[] = $id;
		   		$sql = "UPDATE student SET name = ?, surname = ? WHERE id = ?";
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
		App::render('students-add-edit.twig', array(
			'id' => $id,
			'type' => $type,
			'alerts' => $alerts,
			'_POST' => empty($id) ? (( $type == 'success') ? null : $_POST) : $_POST
		));
	}

    //function called, when user wants to delete a student

    static public function indexDelete($id){
        $conn = new Database();

        try {   //transaction included
            $conn->pdoObject->beginTransaction();
            $stmt = $conn->prepare("DELETE FROM grade WHERE student_id = ?");
            App::log("DELETE FROM grade WHERE student_id = ?");
            $stmt->execute($conn->execute([$id]));
            $stmt = $conn->prepare("DELETE FROM scholarship WHERE student_id = ?");
            App::log("DELETE FROM scholarship WHERE student_id = ?");
            $stmt->execute($conn->execute([$id]));
            $stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
            App::log("DELETE FROM student WHERE id = ?");
            $stmt->execute($conn->execute([$id]));
            $conn->pdoObject->commit();
        }
        catch (Exception $e) {
            $conn->pdoObject->rollBack();
        }
    }

    static public function indexDetail($id){
        $conn = new Database();
        $sql = "SELECT
          coalesce(student.name, '') || ' ' || coalesce(student.surname, '') AS student, student.grade AS schoolyear, classroom.id AS classroom_id, classroom.name AS classroom,
          coalesce(teacher.name, '') || ' ' || coalesce(teacher.surname, '') AS teacher,
          (SELECT avg(value) FROM grade WHERE student_id = student.id) AS avg_grade,
          (SELECT sum(amount) FROM scholarship WHERE student_id = student.id) AS sum_scholarship
          FROM student 
          LEFT JOIN classroom ON (student.classroom_id=classroom.id)
          LEFT JOIN teacher ON (classroom.teacher_id=teacher.id)
          WHERE student.id = ?
        ";
        $stmt = $conn->prepare($sql);
        App::log($sql);

        $stmt->execute($conn->execute(array(
            $id
        )));
        $person = $stmt->fetch();

        $sql = "SELECT
          subject.name AS subject, coalesce(teacher.name, '') || ' ' || coalesce(teacher.surname, '') AS teacher, classroom.name AS classroom, teach_time.time AS time, weekdays.day AS day
          FROM teaching 
          LEFT JOIN classroom ON (teaching.classroom_id=classroom.id)
          LEFT JOIN teacher ON (teaching.teacher_id=teacher.id)
          LEFT JOIN subject ON (teaching.subject_id=subject.id)
          LEFT JOIN teach_time ON (teaching.teach_time_id=teach_time.id)
          LEFT JOIN weekdays ON (teaching.weekdays_id=weekdays.id)
          WHERE teaching.classroom_id = ?
        ";
        $stmt = $conn->prepare($sql);
        App::log($sql);

        $stmt->execute($conn->execute(array(
            $person['classroom_id']
        )));
        $teaching = $stmt->fetchAll();


        App::render('students-detail.twig', array(
            'person' => $person,
            'teaching' => $teaching
        ));
    }
}
