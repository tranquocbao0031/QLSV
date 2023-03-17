<?php
class SubjectController
{
    // Trang danh sách môn học
    function index()
    {
        // Gọi model lấy danh sách môn học
        $subjectRepository = new SubjectRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search);
        } else {
            $subjects = $subjectRepository->getAll();
        }

        require 'view/subject/index.php';
    }

    // Hiển thị form tạo môn học
    function create()
    {
        require 'view/subject/create.php';
    }

    function store()
    {
        $name = $_POST['name'];
        $data = $_POST;
        $subjectRepository = new SubjectRepository();
        // Lưu xuống database
        if ($subjectRepository->save($data)) {
            // Thành công
            $_SESSION['success'] = "Đã tạo môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    function edit()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        require 'view/subject/edit.php';
    }

    function update()
    {
        // Lấy subject từ database
        $id = $_POST['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        // Cập nhật thông tin người dùng đã thay đổi vào subject
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;

        // Lưu xuống database
        if ($subjectRepository->update($subject)) {
            // Thành công
            $_SESSION['success'] = "Đã cập nhật môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    function destroy()
    {
        $id = $_GET['id'];
        // Lấy name của subject
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        $name = $subject->name;

        // Nếu môn học đã được đăng ký rồi thì không được xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getBySubjectId($id);
        if (count($registers) > 0) {
            //Môn học đã được sinh viên đăng ký
            $_SESSION['error'] = "Môn học $name đã được sinh viên đăng ký, không thể xóa";
            header('location: /');
            exit;
        }
        // Xóa dưới database
        if ($subjectRepository->destroy($id)) {
            // Thành công
            $_SESSION['success'] = "Đã xóa môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // Thất bại
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }
}
