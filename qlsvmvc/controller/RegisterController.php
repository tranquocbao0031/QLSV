<?php
class RegisterController
{
    // Trang danh sách môn học
    function index()
    {
        // Gọi model lấy danh sách môn học
        $registerRepository = new RegisterRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $registers = $registerRepository->getByPattern($search);
        } else {
            $registers = $registerRepository->getAll();
        }

        require 'view/register/index.php';
    }

    // Hiển thị form tạo môn học
    function create()
    {
        // Lấy danh sách sinh viên
        $studentRepository = new StudentRepository();
        $students = $studentRepository->getAll();

        // Lấy danh sách môn học
        $subjectRepository = new SubjectRepository();
        $subjects = $subjectRepository->getAll();

        require 'view/register/create.php';
    }

    function store()
    {
        // Lấy tên sinh viên
        $student_id = $_POST['student_id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($student_id);
        $student_name = $student->name;

        // Lấy tên môn học
        $subject_id = $_POST['subject_id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($subject_id);
        $subject_name = $subject->name;


        $data = $_POST;
        $registerRepository = new RegisterRepository();
        // Lưu xuống database
        if ($registerRepository->save($data)) {
            // Thành công
            $_SESSION['success'] = "Sinh viên $student_name đăng ký môn $subject_name thành công";
            header('location: /?c=register');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    function edit()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        require 'view/register/edit.php';
    }

    function update()
    {
        // Lấy register từ database
        $id = $_POST['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Cập nhật thông tin người dùng đã thay đổi vào register
        $score = $_POST['score'];
        $register->score = $score;

        // Lưu xuống database
        if ($registerRepository->update($register)) {
            // Thành công
            $_SESSION['success'] = "Sinh viên $student_name thi môn $subject_name được $score điểm";
            if ($score == '') {
                $_SESSION['success'] = "Sinh viên $student_name đăng ký môn $subject_name, nhưng chưa thi";
            }
            header('location: /?c=register');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    function destroy()
    {
        $id = $_GET['id'];
        // Lấy student_id của register
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Xóa dưới database
        if ($registerRepository->destroy($id)) {
            // Thành công
            $_SESSION['success'] = "Đã xóa sinh viên $student_name đăng ký môn học $subject_name thành công";
            header('location: /?c=register');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }
}
