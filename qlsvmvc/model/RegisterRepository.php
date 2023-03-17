<?php
class RegisterRepository
{
    public $error;
    // Lấy các dòng dữ liệu trong bảng register và chuyển thành danh sách các đối tượng môn học
    protected function fetch($cond = '')
    {
        // Rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // Muốn bên trong nhìn thấy biến bên ngoài phải dùng từ khóa global
        global $conn;
        $sql = "
                SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
                JOIN student ON student.id=register.student_id
                JOIN subject ON subject.id=register.subject_id
        ";
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM register WHEE id=2
        }
        $result = $conn->query($sql);
        $registers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];
                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];
                $register = new Register($id, $student_id, $subject_id, $score, $student_name, $subject_name);
                // Dấu ngoặc vuông [] là thêm 1 phần tử bên phải vào danh sách bên trái.
                $registers[] = $register;
            }
        }
        return $registers;
    }

    function save($data)
    {
        global $conn;
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];
        $sql = "INSERT INTO register (student_id, subject_id) VALUES('$student_id', '$subject_id')";

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
        $cond = "register.id=$id";
        $registers = $this->fetch($cond);
        // current() là hàm lấy phần tử đầu tiên trong danh sách
        $register = current($registers);
        return $register;
    }

    function update($register)
    {
        global $conn;
        $score = $register->score;
        $id = $register->id;

        $sql = "UPDATE register SET score=$score WHERE id=$id";
        if ($score == '') {
            $sql = "UPDATE register SET score=NULL WHERE id=$id";
        }
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
        $sql = "DELETE FROM register WHERE id=$id";
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
        $cond = "student.name LIKE '%$pattern%' OR subject.name LIKE '%$pattern%'";
        $registers = $this->fetch($cond);
        return $registers;
    }

    function getAll()
    {
        return $this->fetch();
    }

    function getByStudentId($student_id)
    {
        $cond = "student_id=$student_id";
        // SELECT * FROM register WHERE student_id=1
        $registers = $this->fetch($cond);
        return $registers;
    }
    function getBySubjectId($subject_id)
    {
        $cond = "subject_id=$subject_id";
        // SELECT * FROM register WHERE subject_id=1
        $registers = $this->fetch($cond);
        return $registers;
    }
}
