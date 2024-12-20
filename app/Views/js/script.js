// //hàm chuyển hướng người dùng đến section khác ở trong cùng 1 file html
// //sử dụng tag content-section và active
// function showSection(section) {
//     var sections = document.getElementsByClassName('content-section');
//     for (var i = 0; i < sections.length; i++) {
//         sections[i].classList.remove('active');
//     }
//     document.getElementById(section).classList.add('active');
// }

function showSection(sectionId) {
    // Ẩn tất cả các section
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });

    // Hiển thị section được chọn
    const section = document.getElementById(sectionId);
    if (section) {
        section.classList.add('active');

        // Nếu section là "result", tải nội dung PHP
        if (sectionId === 'result') {
            fetch('../../Controllers/analyze.php') // Đường dẫn tới file PHP
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    section.innerHTML = data; // Chèn nội dung vào section
                })
                .catch(error => {
                    console.error('Error fetching PHP file:', error);
                    section.innerHTML = '<p>Không thể tải nội dung. Vui lòng thử lại sau.</p>';
                });
        }
    }
}


//điều hướng giao diện thông qua đường dẫn
function navigate(path){
    window.location.href = path;
}

document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu đây là trang teacherHomePage.html
    if (window.location.pathname.includes("teacherHomePage.html")) {
        // Gọi AJAX đến signin.php để lấy thông tin người dùng
        fetch('../../../database/signin.php?ajax=true')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Hiển thị thông tin người dùng chỉ trên teacherHomePage.html
                    const greetingElement = document.createElement('li');
                    greetingElement.textContent = `Chào ${data.full_name}`;
                    // document.querySelector('.nav').appendChild(greetingElement);

                    // Thêm lớp CSS cho thẻ li
                    greetingElement.classList.add('greeting');

                     // Tìm thẻ "Đăng xuất" (có href là "../../../index.html")
                    const logoutLi = document.querySelector('a[href="../../../index.html"]').parentElement;

                    // Chèn thẻ <li> mới vào trước thẻ "Đăng xuất"
                    logoutLi.parentElement.insertBefore(greetingElement, logoutLi);

                } else {
                    alert(data.message); // Hiển thị lỗi nếu có
                    window.location.href = '../../../index.html'; // Chuyển hướng nếu chưa đăng nhập
                }
            })
            .catch(error => {
                console.error('Error fetching user info:', error);
            });
    }

    // Kiểm tra nếu đây là trang studentHomePage.html
    if (window.location.pathname.includes("studentHomePage.html")) {
        // Gọi AJAX đến signin.php để lấy thông tin người dùng
        fetch('../../../database/signin.php?ajax=true')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Hiển thị thông tin người dùng chỉ trên studentHomePage.html
                    const greetingElement = document.createElement('li');
                    greetingElement.textContent = `Chào ${data.full_name}`;
                    // document.querySelector('.nav').appendChild(greetingElement);

                    // Thêm lớp CSS cho thẻ li
                    greetingElement.classList.add('greeting');

                     // Tìm thẻ "Đăng xuất" (có href là "../../../index.html")
                    const logoutLi = document.querySelector('a[href="../../../index.html"]').parentElement;

                    // Chèn thẻ <li> mới vào trước thẻ "Đăng xuất"
                    logoutLi.parentElement.insertBefore(greetingElement, logoutLi);

                } else {
                    alert(data.message); // Hiển thị lỗi nếu có
                    window.location.href = '../../../index.html'; // Chuyển hướng nếu chưa đăng nhập
                }
            })
            .catch(error => {
                console.error('Error fetching user info:', error);
            });
    }
});