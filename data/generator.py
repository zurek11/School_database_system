import random

from faker import Faker

fake = Faker()
maximum_students = 1000000
maximum_teacher = 1000
maximum_classroom = 100000
maximum_teaching = 2000000
maximum_grades = 2000000
maximum_scholarships = 200000

f = open('data.sql', 'a')

scholarships = ["Merit-based Scholarship",
                "Need-based Scholarship",
                "Athletic Scholarship",
                "Individual Scholarship",
                "Scholarship For Ethnic Minorities"]

subjects = ["English",
            "Mathematics",
            "Art",
            "History",
            "Geography",
            "Biology",
            "Information technology",
            "Physical education",
            "Chemistry",
            "Physics",
            "Music"]

weekdays = ["Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"]

teachTime = ["8:00",
             "9:00",
             "10:00",
             "11:00",
             "12:00",
             "13:00",
             "14:00"]

insert = "INSERT INTO subject (name, score) VALUES"
for subject in subjects:
    f.write(insert
            + "('{}', '{}');".format(subject, round(random.uniform(1.0, 5.0), 1))
            + "\n"
            )

insert = "INSERT INTO teacher (name, surname) VALUES"
for teacher in range(maximum_teacher):
    f.write(insert
            + "('{}', '{}');".format(fake.first_name(), fake.last_name())
            + "\n"
            )

insert = "INSERT INTO classroom (teacher_id, name) VALUES"
for classroom in range(maximum_classroom):
    f.write(insert
            + "('{}', '{}');".format(random.randint(1, maximum_teacher), fake.country_code())
            + "\n"
            )

insert = "INSERT INTO student (classroom_id, name, surname, grade) VALUES"
for student in range(200000):
    f.write(insert
            + "('{}', '{}', '{}', '{}');".format(
        random.randint(1, maximum_classroom), fake.first_name(), fake.last_name(), random.randint(1, 9))
            + "\n"
            )

insert = "INSERT INTO scholarship_type (type) VALUES"
for scholarship_type in scholarships:
    f.write(insert
            + "('{}');".format(scholarship_type)
            + "\n"
            )

insert = "INSERT INTO scholarship (student_id, scholarship_type_id, amount, date_of_assignation) VALUES"
for student in range(30000):
    f.write(insert
            + "('{}', '{}', '{}', '{}');".format(
        random.randint(1, maximum_students), random.randint(1, len(scholarships)), random.randrange(500, 1500, 10),
        fake.date(pattern="%Y-%m-%d"))
            + "\n"
            )

insert = "INSERT INTO weekdays (day) VALUES"
for weekday in weekdays:
    f.write(insert
            + "('{}');".format(weekday)
            + "\n"
            )

insert = "INSERT INTO teach_time (time) VALUES"
for time in teachTime:
    f.write(insert
            + "('{}');".format(time)
            + "\n"
            )

insert = "INSERT INTO teaching (teacher_id, subject_id, classroom_id, teach_time_id, weekdays_id) VALUES"
for teaching in range(500000):
    f.write(insert
            + "('{}', '{}', '{}', '{}', '{}');".format(
        random.randint(1, maximum_teacher), random.randint(1, len(subjects)), random.randint(1, maximum_classroom)
        ,random.randint(1, len(teachTime)), random.randint(1, len(weekdays)))
            + "\n"
            )

insert = "INSERT INTO grade (student_id, teaching_id, value) VALUES"
for teaching in range(500000):
    f.write(insert
            + "('{}', '{}', '{}');".format(
        random.randint(1, maximum_students), random.randint(1, maximum_teacher), random.randint(1, 5))
            + "\n"
            )
