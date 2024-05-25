# Routes

| URL                     | Méthode HTTP | Controller          | Méthode      | Commentaire                                    |
| ----------------------- | ------------ | ------------------- | ------------ | ---------------------------------------------- |
| `/`                     | `GET`        | `MainController`    | `home`       | -                                              |
| `/signin`               | `GET`        | `AppUserController` | `signin`     | Sign in                                        |
| `/signin`               | `POST`       | `AppUserController` | `signinPost` | Sign in                                        |
| `/teachers`             | `GET`        | `TeacherController` | `list`       | List all teachers                              |
| `/teachers/add`         | `GET`        | `TeacherController` | `add`        | Create the teacher                             |
| `/teachers/add`         | `POST`       | `TeacherController` | `addPost`    | Create the teacher                             |
| `/teachers/[id]`        | `GET`        | `TeacherController` | `update`     | Update - [id] represents the id of the teacher |
| `/teachers/[id]`        | `POST`       | `TeacherController` | `updatePost` | Update - [id] represents the id of the teacher |
| `/teachers/[id]/delete` | `GET`        | `TeacherController` | `delete`     | Delete - [id] represents the id of the teacher |
| `/students`             | `GET`        | `StudentController` | `list`       | List all students                              |
| `/students/add`         | `GET`        | `StudentController` | `add`        | Create the student                             |
| `/students/add`         | `POST`       | `StudentController` | `addPost`    | Create the student                             |
| `/students/[id]`        | `GET`        | `StudentController` | `update`     | Update - [id] represents the id of the student |
| `/students/[id]`        | `POST`       | `StudentController` | `updatePost` | Update - [id] represents the id of the student |
| `/students/[id]/delete` | `GET`        | `StudentController` | `delete`     | Delete - [id] represents the id of the student |
| `/appusers`             | `GET`        | `AppUserController` | `list`       | List all appusers                              |
| `/appusers/add`         | `GET`        | `AppUserController` | `add`        | Create the appuser                             |
| `/appusers/add`         | `POST`       | `AppUserController` | `addPost`    | Create the appuser                             |
| `/appusers/[id]`        | `GET`        | `AppUserController` | `update`     | Update - [id] represents the id of the appuser |
| `/appusers/[id]`        | `POST`       | `AppUserController` | `updatePost` | Update - [id] represents the id of the appuser |
| `/appusers/[id]/delete` | `GET`        | `AppUserController` | `delete`     | Delete - [id] represents the id of the appuser |
