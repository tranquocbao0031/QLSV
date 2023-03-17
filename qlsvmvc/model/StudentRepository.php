<?php
class StudentRepository
{
    public $error;
    // Lấy các dòng dữ liệu trong bảng student và chuyển thành danh sách các đối tượng sinh viên
    protected function fetch($cond = '')
    {
        // Rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // Muốn bên trong nhìn thấy biến bên ngoài phải dùng từ khóa global
        global $conn;
        $sql = "SELECT * FROM student";
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM student WHEE id=2
        }
        $result = $conn->query($sql);
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                $student = new Student($id, $name, $birthday, $gender);
                // Dấu ngoặc vuông [] là thêm 1 phần tử bên phải vào danh sách bên trái.
                $students[] = $student;
            }
        }
        return $students;
    }

    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $sql = "INSERT INTO student (name, birthday, gender) VALUES('$name', '$birthday', '$gender')";

        if ($conn->query($sql)) {
            // Lưu thành công
            return true;
        }
        // $conn->error là thông báo lỗi từ database server trả về
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "id=$id";
        $students = $this->fetch($cond);
        // current() là hàm lấy phần tử đầu tiên trong danh sách
        $student = current($students);
        return $student;
    }

    function update($student)
    {
        global $conn;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;
        $id = $student->id;

        $sql = "UPDATE student SET name='$name', birthday='$birthday', gender='$gender' WHERE id=$id";
        if ($conn->query($sql)) {
            // Lưu thành công
            return true;
        }
        // $conn->error là thông báo lỗi từ database server trả về
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM student WHERE id=$id";
        if ($conn->query($sql)) {
            // Lưu thành công
            return true;
        }
        // $conn->error là thông báo lỗi từ database server trả về
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function getByPattern($pattern)
    {
        $cond = "name LIKE '%$pattern%'";
        $students = $this->fetch($cond);
        return $students;
    }

    function getAll()
    {
        return $this->fetch();
    }
}
