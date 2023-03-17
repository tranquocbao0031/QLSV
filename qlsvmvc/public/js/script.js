$('button.delete').click(function (e) {
	e.preventDefault();
	var dataUrl = $(this).attr('data-href');
	$('#exampleModal a').attr('href', dataUrl);
});

$(".form-student-create,.form-student-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50,
			regex: /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i
		},
		birthday: {
			required: true,
		},

		gender: {
			required: true,
		},

	},
	messages: {
		name: {
			required: 'Vui lòng nhập họ và tên',
			maxlength: 'Vui lòng không nhập quá 50 ký tự',
			regex: 'Vui lòng nhập đúng định dạng họ và tên'
		},
		birthday: {
			required: 'Vui lòng chọn ngày sinh',

		},
		gender: {
			required: 'Vui lòng chọn giới tính',
		},

	}
});

$(".form-subject-create,.form-subject-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50
		},
		number_of_credit: {
			required: true,
			range: [1, 10],
			digits: true
		}

	},
	messages: {
		name: {
			required: 'Vui lòng nhập tên môn học',
			maxlength: 'Vui lòng không nhập quá 50 ký tự',

		},
		number_of_credit: {
			required: 'Vui lòng nhập số tín chỉ',
			range: 'Vui lòng nhập con số từ 1 đến 10',
			digits: 'Vui lòng nhập con số nguyên'

		}


	}
});

$(".form-register-create").validate({
	rules: {
		// simple rule, converted to {required:true}
		student_id: {
			required: true,
		},
		subject_id: {
			required: true,
		}

	},
	messages: {
		student_id: {
			required: 'Vui lòng chọn sinh viên',
		},
		subject_id: {
			required: 'Vui lòng chọn môn học',
		}


	}
});

$(".form-register-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		score: {
			range: [0, 10],
		},
	},
	messages: {
		score: {
			range: 'Vui lòng nhập điểm từ 0 đến 10',
		},
	}
});


$.validator.addMethod(
	"regex",
	function (value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);