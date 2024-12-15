# import os.path giúp lấy đường dẫn để lưu dữ liệu
import os

class Question:
    def __init__(self, text):
        self.text = text  # Câu hỏi

class Subject:
    def __init__(self, name, rating_type):
        self.name = name  # Tên môn học
        self.rating_type = rating_type  # Kiểu đánh giá
        self.questions = []  # Danh sách câu hỏi

# Hàm kiểm tra ký tự nhập vào
def check_character(input_str):
    if not input_str:
        return "Không được để trống!"
    for char in input_str:
        if not char.isalnum() and not char.isspace() and not char == '?':
            return "Có ký tự không hợp lệ!"
    return input_str

# Hiển thị và chọn kiểu đánh giá
def select_rating_type():
    print("Chọn kiểu đánh giá: ")
    print("1. Đánh giá bằng số (1-Rất không hài lòng, 2-Không hài lòng, 3-Hài lòng, 4-Rất hài lòng, 5-Cực kỳ hài lòng) ")
    print("2. Đánh giá bằng chữ (Poor, Fair, Good, Very Good, Excellent) ")
    print("3. Tự nhập vào thang đánh giá ")
    choice = input("Lựa chọn (1 ,2 hoặc 3): ")

    if choice == "1":
        return "Đánh giá bằng số (1-Rất không hài lòng, 2-Không hài lòng, 3-Hài lòng, 4-Rất hài lòng, 5-Cực kỳ hài lòng)"
    elif choice == "2":
        return "Đánh giá bằng chữ (Poor, Fair, Good, Very Good, Excellent)"
    elif choice == "3":
        custom_rating = input("Nhập kiểu đánh giá của bạn (ví dụ: 1: Bad, 2: Normal,...): ")
        return custom_rating
    else:
        print("Lựa chọn không hợp lệ! Mặc định chọn đánh giá bằng thang điểm 1-5.")
        return "Đánh giá bằng số (1-Rất không hài lòng, 2-Không hài lòng, 3-Hài lòng, 4-Rất hài lòng, 5-Cực kỳ hài lòng)"

# Tạo form câu hỏi
def create_form(subject):
    add_more = 'y'
    while add_more.lower() == 'y':
        question_text = ""
        while True:
            question_text = input("Nhập câu hỏi: ")
            question_text = check_character(question_text)
            if question_text == "Không được để trống!" or question_text == "Có ký tự không hợp lệ!":
                print(question_text)
            else:
                break
        
        question = Question(question_text)
        subject.questions.append(question)

        add_more = input("Bạn có muốn thêm câu hỏi khác không? (y/n): ")

# Lưu dữ liệu vào file
def save_to_file(subjects, file_name):
    try:
        # Xác định đường dẫn đầy đủ đến file data.txt
        current_dir = os.path.dirname(os.path.abspath(__file__))  # Thư mục chứa CreateForm.py
        file_path = os.path.join(current_dir, file_name)  # Ghép đường dẫn đầy đủ

        with open(file_path, 'w', encoding='utf-8') as file:
            for subject in subjects:
                file.write(f"Môn học: {subject.name}\n")
                file.write(f"Kiểu đánh giá: {subject.rating_type}\n")
                for idx, question in enumerate(subject.questions):
                    file.write(f"  Câu hỏi {idx + 1}: {question.text}\n")
                file.write("-------------------------\n")
        print(f"Dữ liệu đã được ghi vào file: {file_name}")
    except Exception as e:
        print(f"Không thể mở file để ghi! Lỗi: {e}")

def main():
    subjects = []
    print("Chức năng cho giáo viên tạo form đánh giá")

    while True:
        subject_text = ""
        while True:
            subject_text = input("Nhập tên môn học: ")
            subject_text = check_character(subject_text)
            if subject_text == "Không được để trống!" or subject_text == "Có ký tự không hợp lệ!":
                print(subject_text)
            else:
                break
        
        rating_type = select_rating_type()
        subject = Subject(subject_text, rating_type)
        create_form(subject)
        subjects.append(subject)

        choice = input("Bạn có muốn thêm môn học khác không? (y/n): ")
        if choice.lower() != 'y':
            break

    file_name = "data.txt"
    save_to_file(subjects, file_name)

    print("Kết thúc chương trình.")

if __name__ == "__main__":
    main()
