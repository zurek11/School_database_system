CREATE SEQUENCE subject_id;
CREATE TABLE subject (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('subject_id'),
	name CHAR(50) NOT NULL,
	score DECIMAL
);

CREATE SEQUENCE teacher_id;
CREATE TABLE teacher (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('teacher_id'),
	name CHAR(50),
	surname CHAR(50)
);

CREATE SEQUENCE classroom_id;
CREATE TABLE classroom (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('classroom_id'),
	teacher_id INT references teacher(id),
	name CHAR(50)
);

CREATE SEQUENCE student_id;
CREATE TABLE student (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('student_id'),
	classroom_id INT references classroom(id),
	name CHAR(50),
	surname CHAR(50),
	grade INT
);

CREATE SEQUENCE scholarship_type_id;
CREATE TABLE scholarship_type(
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('scholarship_type_id'),
	type CHAR(50)
);

CREATE SEQUENCE scholarship_id;
CREATE TABLE scholarship (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('scholarship_id'),
	student_id INT references student(id),
	scholarship_type_id INT references scholarship_type(id),
	amount INT,
	date_of_assignation DATE
);

CREATE SEQUENCE weekdays_id;
CREATE TABLE weekdays(
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('weekdays_id'),
	day CHAR(50)
);

CREATE SEQUENCE teach_time_id;
CREATE TABLE teach_time(
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('teach_time_id'),
	time TIME
);

CREATE SEQUENCE teaching_id;
CREATE TABLE teaching (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('teaching_id'),
	teacher_id INT references teacher(id),
	subject_id INT references subject(id),
	classroom_id INT references classroom(id),
	teach_time_id INT,
	weekdays_id INT
);

CREATE SEQUENCE grade_id;
CREATE TABLE grade (
	id INT PRIMARY KEY NOT NULL DEFAULT NEXTVAL('grade_id'),
	student_id INT references student(id),
	teaching_id INT references teaching(id),
	value INT
);