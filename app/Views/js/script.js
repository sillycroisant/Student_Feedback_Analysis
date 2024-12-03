//hàm chuyển hướng người dùng đến trang "section" khác
function showSection(section) {
    var sections = document.getElementsByClassName('content-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('active');
    }
    document.getElementById(section).classList.add('active');
}