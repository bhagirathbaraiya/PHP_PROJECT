Table admin {
  id int [pk, increment]
  fname varchar
  lname varchar
  email varchar [unique]
  status enum
  created_at timestamp
  updated_at timestamp

  Indexes {
    (email)
    (status)
  }
}

Table students {
  grno int [pk]
  erno int [unique]
  fname varchar
  lname varchar
  email varchar [unique]
  password varchar
  mobile int
  telegram int
  status enum
  created_at timestamp
  updated_at timestamp

  Indexes {
    (erno)
    (email)
    (mobile)
    (status)
  }
}

Table faculty {
  erno int [pk]
  fname varchar
  lname varchar
  email varchar [unique]
  password varchar
  mobile int
  telegram int
  status enum
  created_at timestamp
  updated_at timestamp

  Indexes {
    (email)
    (mobile)
    (status)
  }
}

Table student_to_class {
  id int [pk, increment]
  grno int [ref: > students.grno]
  class_id int [ref: > class.id]
  created_at timestamp
  updated_at timestamp

  Indexes {
    (grno)
    (class_id)
  }
}

Table class {
  id int [pk, increment]
  host_id int [ref: > faculty.erno]
  name varchar
  description varchar
  created_at timestamp
  updated_at timestamp

  Indexes {
    (host_id)
    (name)
  }
}

Table assignments {
  id int [pk, increment]
  name varchar
  description varchar
  due_date date
  class_id int [ref: > class.id]
  created_at timestamp
  updated_at timestamp

  Indexes {
    (name)
    (due_date)
    (class_id)
  }
}

Table notebook {
  id int [pk, increment]
  class_id int [ref: > class.id]
  created_at timestamp
  updated_at timestamp

  Indexes {
    (class_id)
  }
}

Table assignment_submissions {
  id int [pk, increment]
  assignment_id int [ref: > assignments.id]
  grno int [ref: > students.grno]
  submission_file varchar
  submitted_at timestamp
  graded_by int [ref: > faculty.erno]
  grade varchar
  feedback text
  status enum
  updated_at timestamp

  Indexes {
    (assignment_id)
    (grno)
    (submitted_at)
    (graded_by)
    (grade)
    (status)
  }
}

Table notebook_submissions {
  id int [pk, increment]
  notebook_id int [ref: > notebook.id]
  grno int [ref: > students.grno]
  submission_file varchar
  submitted_at timestamp
  graded_by int [ref: > faculty.erno]
  grade varchar
  feedback text
  status enum
  updated_at timestamp

  Indexes {
    (notebook_id)
    (grno)
    (submitted_at)
    (graded_by)
    (grade)
    (status)
  }
}

Table notifications {
  id int [pk, increment]
  user_id int
  role enum
  message varchar
  status enum
  created_at timestamp

  Indexes {
    (user_id)
    (role)
    (status)
  }
}

Table common_log {
  id int [pk, increment]
  user_id int
  user_role enum('admin', 'faculty', 'student')
  action enum
  description varchar
  status enum
  created_at timestamp

  Indexes {
    (user_id)
    (user_role)
    (action)
    (status)
    (created_at)
  }
}
