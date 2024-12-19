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