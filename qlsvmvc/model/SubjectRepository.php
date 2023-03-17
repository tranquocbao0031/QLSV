<?php
class SubjectRepository
{
    public $error;
    // Lấy các dòng dữ liệu trong bảng subject và chuyển thành danh sách các đối tượng môn học
    protected function fetch($cond = '')
    {
        // Rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // Muốn bên trong nhìn thấy biến bên ngoài phải dùng từ khóa global
        global $conn;
        $sql = "SELECT * FROM subject";
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM subject WHEE id=2
        }
        $result = $conn->query($sql);
        $subjects = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                $subject = new Subject($id, $name, $number_of_credit);
                // Dấu ngoặc vuông [] là thêm 1 phần tử bên phải vào danh sách bên trái.
                $subjects[] = $subject;
            }
        }
        return $subjects;
    }

    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $number_of_credit = $data['number_of_credit'];
        $sql = "INSERT INTO subject (name, number_of_credit) VALUES('$name', '$number_of_credit')";

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
        $subjects = $this->fetch($cond);
        // current() là hàm lấy phần tử đầu tiên trong danh sách
        $subject = current($subjects);
        return $subject;
    }

    function update($subject)
    {
        global $conn;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;
        $id = $subject->id;

        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";
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
        $sql = "DELETE FROM subject WHERE id=$id";
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
        $subjects = $this->fetch($cond);
        return $subjects;
    }

    function getAll()
    {
        return $this->fetch();
    }
}