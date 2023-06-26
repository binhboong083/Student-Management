//
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
//
function removeRow(id, url) {
    if (confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id },
            success: function (result) {
                // console.log(result);
                if (result.error == false) {
                    // alert(result.message);
                    location.reload();
                }
                else {
                    // alert("Xóa bản ghi thất bại");
                    location.reload();
                }
            }
        })
    }
}
function removeRowMany(ids, url) {
    if (confirm("Bạn có chắc chắn muốn xóa các bản ghi này không?")) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { ids },
            success: function (result) {
                // console.log(result);
                if (result.error == false) {
                    // alert(result.message);
                    location.reload();
                }
                else {
                    // alert("Xóa bản ghi thất bại");
                    location.reload();
                }
            }
        })
    }
}
// Hàm sắp xếp bảng
let countClick = 0;
// function sortTable(n, name) {
//     countClick++
//     // if (countClick > 2) return
//     var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
//     table = document.getElementById(name);
//     switching = true;
//     dir = "asc";
//     while (switching) {
//         switching = false;
//         rows = table.rows;
//         for (i = 1; i < (rows.length - 1); i++) {
//             shouldSwitch = false;
//             x = rows[i].getElementsByTagName("TD")[n];
//             y = rows[i + 1].getElementsByTagName("TD")[n];
//             if (dir == "asc") {
//                 if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
//                     shouldSwitch = true;
//                     break;
//                 }
//             } else if (dir == "desc") {
//                 if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
//                     shouldSwitch = true;
//                     break;
//                 }
//             }
//         }
//         if (shouldSwitch) {
//             rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
//             switching = true;
//             switchcount++;
//         } else {
//             if (switchcount == 0 && dir == "asc") {
//                 dir = "desc";
//                 switching = true;
//             }
//         }
//     }
// }
function sortTable(n, name) {
    countClick++;
    // if (countClick > 2) return;
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(name);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            // Thêm điều kiện so sánh giá trị số
            if (!isNaN(parseFloat(x.innerHTML)) && !isNaN(parseFloat(y.innerHTML))) {
                if (dir == "asc") {
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            // Nếu không phải là giá trị số, sẽ so sánh chuỗi bình thường
            else {
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
// Xóa file cũ khi upload file mới
function deleteFile(path) {
    $.ajax({
        type: 'DELETE',
        dataType: 'JSON',
        url: '/admin/delete-file',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { path },
        success: function (response) {
            console.log(response.message);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

/*Upload File */
$('#upload').change(function () {
    //
    var fileOld = $('#thumb').val();
    //
    const form = new FormData();
    form.append('file', $(this)[0].files[0]);

    $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        data: form,
        url: '/admin/upload/services',
        success: function (result) {
            //console.log(result);
            if (result.error === false) {
                $('#image_show').html('<a href="' + result.url + '" target="_blank">' +
                    '<img src="' + result.url + '" width="100px"></a>');
                if (fileOld) {
                    deleteFile(fileOld);
                }
                $('#thumb').val(result.url);
            } else {
                // alert(results.message);
                toastr.error(result.message, 'Thông báo');
                $('#upload').val('');
            }
        }
    });
});
//
// Xử lý form login
function validateFormLogin() {
    var email = $('#email');
    var password = $('#password');

    if (!email.val()) {
        toastr.error('Email không được để trống!', 'Thông báo', { timeOut: 2000 });
        email.focus();
        return false;
    }
    if (!password.val()) {
        toastr.error('Vui lòng nhập mật khẩu!', 'Thông báo');
        password.focus();
        return false;
    }
    return true;
}

$('#login').submit(function (e) {
    if (!validateFormLogin()) {
        e.preventDefault();
    }
});
//
function validateFormLop() {
    var malop = $('#malop');
    var tenlop = $('#tenlop');
    // var mota = $('#mota');
    var soluongsv = $('#soluongsv');

    // Kiểm tra mã lớp
    if (malop.val() == '') {
        // alert('Vui lòng nhập mã');
        toastr.error('Vui lòng nhập mã!', 'Thông báo', { timeOut: 2000 });
        malop.focus();
        return false;
    }

    // Kiểm tra họ tên
    if (tenlop.val() == '') {
        // alert('Vui lòng nhập tên');
        toastr.error('Vui lòng nhập tên!', 'Thông báo');
        tenlop.focus();
        return false;
    }
    // Kiểm tra mô tả lớp môn học
    var mota = CKEDITOR.instances.mota.getData();
    if (!mota) {
        // alert('Vui lòng nhập mô tả');
        toastr.error('Vui lòng nhập mô tả!', 'Thông báo');
        CKEDITOR.instances.mota.focus();
        return false;
    }

    // Kiểm tra ngày sinh
    if (soluongsv.val() == '') {
        // alert('Vui lòng nhập số lượng sinh viên');
        toastr.error('Vui lòng nhập số lượng sinh viên!', 'Thông báo');
        soluongsv.focus();
        return false;
    }

    return true;
}

$('#lop-form').submit(function (e) {
    if (!validateFormLop()) {
        e.preventDefault();
    }
});
//
function validateFormStudent() {
    var mssv = $('#mssv');
    var name = $('#name');
    var class_id = $('#class_id');
    var date = $('#date');
    var phone = $('#phone');
    var email = $('#email');
    var fileInput = $('#upload');

    // Kiểm tra mã số sinh viên
    if (mssv.val() == '') {
        toastr.error('Vui lòng nhập mã số sinh viên!', 'Thông báo');
        mssv.focus();
        return false;
    }

    // Kiểm tra họ tên
    if (name.val() == '') {
        toastr.error('Vui lòng nhập họ tên!', 'Thông báo');
        name.focus();
        return false;
    } else if (name.val().length > 24) {
        toastr.error('Họ tên không được quá 24 ký tự!', 'Thông báo');
        name.focus();
        return false;
    }

    // Kiểm tra lớp môn học
    if (!class_id.val()) {
        toastr.error('Vui lòng chọn lớp môn học!', 'Thông báo');
        class_id.focus();
        return false;
    }

    // Kiểm tra ngày sinh
    if (date.val() == '') {
        toastr.error('Vui lòng chọn ngày sinh!', 'Thông báo');
        date.focus();
        return false;
    }

    // Kiểm tra số điện thoại
    if (phone.val() == '') {
        toastr.error('Vui lòng nhập số điện thoại!', 'Thông báo');
        phone.focus();
        return false;
    } else if (!phone.val().match(/^\d{3}\d{3}\d{4}$/)) {
        toastr.error('Số điện thoại không hợp lệ!', 'Thông báo');
        // alert('Số điện thoại không hợp lệ. Vui lòng nhập theo định dạng 0987654321');
        phone.focus();
        return false;
    }

    // Kiểm tra email
    if (email.val() == '') {
        toastr.error('Vui lòng nhập địa chỉ email!', 'Thông báo');
        email.focus();
        return false;
    } else if (!email.val().match(/^\S+@\S+\.\S+$/)) {
        toastr.error('Địa chỉ email không hợp lệ!', 'Thông báo');
        email.focus();
        return false;
    }

    // Kiểm tra nhập ảnh
    if (fileInput.val() == '') {
        toastr.error('Vui lòng nhập ảnh đại diện!', 'Thông báo');
        fileInput.focus();
        return false;
    }

    return true;
}

$('#student-form').submit(function (e) {
    if (!validateFormStudent()) {
        e.preventDefault();
    }
});

// Bắt sự kiện checkbox form 1
function checkAll(source) {
    $('.checkbox').prop('checked', source.checked);
}

// Bắt sự kiện khi click vào checkbox bất kỳ
$('.checkbox').on('change', function () {
    var checkboxes = $('.checkbox');
    $('#check-all').prop('checked', checkboxes.length == checkboxes.filter(':checked').length);
    //
    var row = $(this).closest('tr');
    if (this.checked) {
        row.insertBefore(row.closest('tbody').find('tr:eq(0)'));
    } else {
        row.insertAfter(row.closest('tbody').find('tr:last'));
    }
    //
});

// Bắt sự kiện khi click vào button xóa hàng loạt
// $('#delete-selected').click(function () {
//     if (confirm("Bạn có chắc chắn muốn xóa các bản ghi này không?")) {
//         var ids = [];
//         $('.checkbox:checked').each(function () {
//             ids.push($(this).closest('tr').find('td:eq(2)').text());
//         });

//         // Gán danh sách ids vào hidden input
//         $('#delete-ids').val(ids.join(','));

//         // Submit form để xóa bản ghi
//         $('#delete-form').submit();
//     }
// });
// Bắt sự kiện checkbox form 2
function checkAll2(source) {
    $('.checkbox2').prop('checked', source.checked);
}

// Bắt sự kiện khi click vào checkbox bất kỳ
$('.checkbox2').on('change', function () {
    var checkboxes = $('.checkbox2');
    $('#check-all2').prop('checked', checkboxes.length == checkboxes.filter(':checked').length);
    //
    var row = $(this).closest('tr');
    if (this.checked) {
        row.insertBefore(row.closest('tbody').find('tr:eq(0)'));
    } else {
        row.insertAfter(row.closest('tbody').find('tr:last'));
    }
    //
});

$('#delete-selected').click(function () {
    var ids = [];
    $('.checkbox:checked').each(function () {
        ids.push($(this).closest('tr').find('td:eq(2)').text());
    });
    // alert(ids);
    // Gán danh sách ids vào hidden input
    $('#delete-ids').val(ids.join(','));
    var url = "/admin/sinhvien/deletemany";
    removeRowMany($('#delete-ids').val(), url);
});


function beforeDeletes(url) {
    var ids = [];
    $('.checkbox:checked').each(function () {
        ids.push($(this).closest('tr').find('td:eq(2)').text());
    });
    // alert(ids);
    // Gán danh sách ids vào hidden input
    $('#delete-ids').val(ids.join(','));
    removeRowMany($('#delete-ids').val(), url);
}

// Xử lý trước khi xóa bảng đăng ký học phần
function beforeClearHocPhan(url) {
    var ids = [];
    $('.checkbox2:checked').each(function () {
        ids.push($(this).closest('tr').find('td:eq(2)').text());
    });
    // Gán danh sách ids vào hidden input
    $('#delete-ids').val(ids.join(','));
    removeRowMany($('#delete-ids').val(), url);
}

// Lấy dữ liệu từ combox -> chuyển ngược lại (có sử lý phân trang)
function refreshData(name, val) {
    // cập nhật lại giá trị của tham số perPage trong query string của URL
    var searchParams = new URLSearchParams(window.location.search);
    searchParams.set(name, val);
    window.history.replaceState(null, null, '?' + searchParams.toString());
    // reload trang để hiển thị lại dữ liệu với số trang mới
    window.location.reload();
}
// Xử lý phân trang ijax
function LoadPage(page, val) {
    // cập nhật lại giá trị của tham số perPage trong query string của URL
    var searchParams = new URLSearchParams(window.location.search);
    searchParams.set(page, val);
    window.history.replaceState(null, null, '?' + searchParams.toString());
    // reload trang để hiển thị lại dữ liệu với số trang mới
    window.location.reload();
}
// Hàm search option
function searchOption(nameSearch, searchVal, optionName, optionVal) {
    refreshData(nameSearch, searchVal);
    refreshData(optionName, optionVal);
}
// Tạo combobox phân trang 1
$('#perPage').on('change', function () {
    const newPerPage = $(this).val();
    const url = new URL(window.location.href);
    url.searchParams.set('perPage', newPerPage);
    window.location.href = url.toString();
});
//
function beforeInsert(idsv, idlop, url) {
    if (idlop) {
        insertRow(idsv, idlop, url);
    } else {
        toastr.error('Vui lòng nhập lớp môn học!', 'Thông báo');
    }

}
//
function beforeInsertMany(idlop, url) {
    if (idlop) {
        var ids = [];
        $('.checkbox:checked').each(function () {
            ids.push($(this).closest('tr').find('td:eq(2)').text());
        });
        // Gán danh sách ids vào hidden input
        $('#insert-ids').val(ids.join(','));
        var idsv = $('#insert-ids').val();
        // alert(idsv);
        insertRow(idsv, idlop, url);
    } else {
        toastr.error('Vui lòng nhập lớp môn học!', 'Thông báo');
    }

}
//
function insertRow(idsv, idlop, url) {
    $.ajax({
        type: 'POST',
        datatype: 'JSON',
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { idsv, idlop },
        success: function (result) {
            // console.log(result);
            if (result.error == false) {
                // alert(result.message);
                location.reload();
            }
            else {
                // alert(result.message);
                location.reload();
            }
        }
    })
}
