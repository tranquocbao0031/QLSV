<?php
class StudentController
{
    // Trang danh sách sinh viên
    function index()
    {
        // Gọi model lấy danh sách sinh viên
        $studentRepository = new StudentRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $students = $studentRepository->getByPattern($search);
        } else {
            $students = $studentRepository->getAll();
        }

        require 'view/student/index.php';
    }

    // Hiển thị form tạo sinh viên
    function create()
    {
        require 'view/student/create.php';
    }

    function store()
    {
        $name = $_POST['name'];
        $data = $_POST;
        $studentRepository = new StudentRepository();
        // Lưu xuống database
        if ($studentRepository->save($data)) {
            // Thành công
            $_SESSION['success'] = "Đã tạo sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    function edit()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        require 'view/student/edit.php';
    }

    function update()
    {
        // Lấy student từ database
        $id = $_POST['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        // Cập nhật thông tin người dùng đã thay đổi vào student
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $student->name = $name;
        $student->birthday = $birthday;
        $student->gender = $gender;

        // Lưu xuống database
        if ($studentRepository->update($student)) {
            // Thành công
            $_SESSION['success'] = "Đã cập nhật sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    function destroy()
    {
        $id = $_GET['id'];
        // Lấy name của student
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        $name = $student->name;

        // Nếu sinh viên đăng ký  môn học rồi thì không được xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getByStudentId($id);
        if (count($registers) > 0) {
            //Sinh viên này đã đăng ký môn học
            $_SESSION['error'] = "Sinh viên $name đã đăng ký môn học, không thể xóa";
            header('location: /');
            exit;
        }

        // Xóa dưới database
        if ($studentRepository->destroy($id)) {
            // Thành công
            $_SESSION['success'] = "Đã xóa sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }
}
