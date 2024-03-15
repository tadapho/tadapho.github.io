import os  # นำเข้าโมดูล os เพื่อทำงานกับระบบไฟล์
import cv2  # นำเข้า OpenCV เพื่อประมวลผลภาพ
import dlib  # นำเข้า dlib เพื่อตรวจจับใบหน้าและสร้างลักษณะพิเศษของใบหน้า
import numpy as np  # นำเข้า NumPy เพื่อการคำนวณทางคณิตศาสตร์
import shutil  # นำเข้า shutil เพื่อจัดการไฟล์และโฟลเดอร์
import easyocr  # เรียกใช้งานไลบรารี EasyOCR เพื่อการจดจำข้อความ

# สร้างตัวตรวจจับใบหน้า, ตัวทำนายรูปร่างของใบหน้า, และตัวจับหน้ารูปใบหน้า
detector = dlib.get_frontal_face_detector()
shape_predictor = dlib.shape_predictor("shape_predictor_68_face_landmarks.dat")
face_recognizer = dlib.face_recognition_model_v1("dlib_face_recognition_resnet_model_v1.dat")

def preprocess_image(inputNum_folder, outputNum_folder):
    face_cascade = cv2.CascadeClassifier("haarcascade_frontalface_default.xml")  # Load Haar cascade for face detection

    for filenameNum in os.listdir(inputNum_folder):  # Iterate through files in input folder
        if filenameNum.lower().endswith(('.jpg', '.jpeg', '.png')):        # Check if file is a JPEG image
            imageNum_path = os.path.join(inputNum_folder, filenameNum)  # Get full path of the image
            imageNum = cv2.imread(imageNum_path)     # Read the image using OpenCV
            facesNum = face_cascade.detectMultiScale(imageNum, scaleFactor=1.1, minNeighbors=5)  # Detect faces in the image
            for (x, y, w, h) in facesNum:  # Iterate through detected faces
                cv2.rectangle(imageNum, (x, y), (x+w, y+h), (0, 0, 0), -1)  # Draw a black rectangle to cover the face

            outputNum_path = os.path.join(outputNum_folder, filenameNum)  # Get full path for output image
            cv2.imwrite(outputNum_path, imageNum)  # Save the processed image

def read_and_compare_numbers(folderNum1, folderNum2, folderNum3):
    reader = easyocr.Reader(['en'])  # สร้างอ็อบเจ็กต์ EasyOCR เพื่อการจดจำข้อความภาษาอังกฤษ
    numbers_folder1 = {}  # พจนานุกรมสำหรับเก็บตัวเลขที่ตรวจจับได้ในโฟลเดอร์ 1
    numbers_folder2 = {}  # พจนานุกรมสำหรับเก็บตัวเลขที่ตรวจจับได้ในโฟลเดอร์ 2

    # อ่านตัวเลขจากโฟลเดอร์แรก
    for filenameNum in os.listdir(folderNum1):  # วนลูปผ่านไฟล์ในโฟลเดอร์ 1
        if filenameNum.lower().endswith(('.jpg', '.jpeg', '.png')):  # ตรวจสอบว่าเป็นไฟล์รูปภาพ
            imageNum_path = os.path.join(folderNum1, filenameNum)  # รับเส้นทางเต็มของภาพ
            results = reader.readtext(imageNum_path)  # ทำการจดจำข้อความในภาพ
            numbers_folder1[filenameNum] = [item[1] for item in results]  # เก็บตัวเลขที่ตรวจจับได้

    # อ่านตัวเลขจากโฟลเดอร์ที่สอง
    for filenameNum in os.listdir(folderNum2):  # วนลูปผ่านไฟล์ในโฟลเดอร์ 2
        if filenameNum.lower().endswith(('.jpg', '.jpeg', '.png')):  # ตรวจสอบว่าเป็นไฟล์รูปภาพ
            imageNum_path = os.path.join(folderNum2, filenameNum)  # รับเส้นทางเต็มของภาพ
            results = reader.readtext(imageNum_path)  # ทำการจดจำข้อความในภาพ
            numbers_folder2[filenameNum] = [item[1] for item in results]
    for file1, numbers1 in numbers_folder1.items():  # วนลูปผ่านตัวเลขในโฟลเดอร์ 1
        for file2, numbers2 in numbers_folder2.items():  # วนลูปผ่านตัวเลขในโฟลเดอร์ 2
            for number1 in numbers1:  # วนลูปผ่านตัวเลขในโฟลเดอร์ 1
                for number2 in numbers2:  # วนลูปผ่านตัวเลขในโฟลเดอร์ 2
                    if number1 == number2:  # หากตัวเลขตรงกัน
                        folder_name = os.path.splitext(file1)[0]  # ใช้ชื่อไฟล์เป็นชื่อโฟลเดอร์
                        folder_path = os.path.join("matches", folder_name)  # เส้นทางของโฟลเดอร์ย่อยใน matches
                        os.makedirs(folder_path, exist_ok=True)  # สร้างโฟลเดอร์ย่อย
                        # ย้ายภาพจาก Student_Photo ไปยังโฟลเดอร์ที่ตรงกันใน matches
                        shutil.copy(os.path.join(folderNum3, file2), folder_path)
                        print(f"Moved image {file2} to folder {folder_path}")
                        print(f"เลข {number1} ตรงกัน ระหว่างภาพ {file1} และ {file2}")  # พิมพ์เลขที่ตรงกันและชื่อไฟล์

# ฟังก์ชันสำหรับคำนวณลักษณะใบหน้า
def compute_face_descriptors(image):
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)  # แปลงภาพเป็นขาวดำ
    faces = detector(gray_image)  # ตรวจจับใบหน้าในภาพ
    face_descriptors = []
    for face in faces:
        face_shape = shape_predictor(gray_image, face)  # สร้างลักษณะพิเศษของใบหน้า
        face_descriptor = np.array(face_recognizer.compute_face_descriptor(image, face_shape))  # คำนวณลักษณะใบหน้า
        face_descriptors.append(face_descriptor)
    return face_descriptors

# ฟังก์ชันสำหรับประมวลภาพในไดเรกทอรี
def process_images_in_directory(directory):
    images = []
    for filename in os.listdir(directory):
        if filename.lower().endswith(('.jpg', '.jpeg', '.png')):  # ตรวจสอบนามสกุลไฟล์ภาพ
            file_path = os.path.join(directory, filename)  # รวมเส้นทางไฟล์
            image = cv2.imread(file_path)  # อ่านภาพจากไฟล์
            if image is not None:  # ตรวจสอบว่าอ่านภาพได้หรือไม่
                face_descriptors = compute_face_descriptors(image)  # คำนวณลักษณะใบหน้า
                if len(face_descriptors) >= 1:  # ตรวจสอบว่ามีใบหน้าในภาพหรือไม่
                    images.append((filename, face_descriptors, filename.split('.')[0]))  # เก็บข้อมูลภาพ
                else:
                    print(f"No face detected in {filename}")  # แสดงข้อความหากไม่พบใบหน้าในภาพ
    return images

# ฟังก์ชันสำหรับจับคู่ใบหน้าในฐานข้อมูล
def match_faces_in_database(student_face_descriptors, database_images):
    for student_filename, student_face_descriptors, _ in student_face_descriptors:
        match_found = False
        for database_image_filename, database_face_descriptors, folder_name in database_images:
            for student_face_descriptor in student_face_descriptors:
                for database_face_descriptor in database_face_descriptors:
                    distance = np.linalg.norm(student_face_descriptor - database_face_descriptor)  # คำนวณระยะห่างระหว่างลักษณะใบหน้า
                    if distance < 0.4:  # ตรวจสอบว่าใบหน้าตรงกันหรือไม่
                        folder_path = os.path.join("matches", folder_name)  # ระบุเส้นทางโฟลเดอร์ที่จะบันทึกภาพที่ตรงกัน
                        os.makedirs(folder_path, exist_ok=True)  # สร้างโฟลเดอร์ถ้ายังไม่มี
                        shutil.copy(os.path.join("student_Photo", student_filename), folder_path)  # คัดลอกภาพนักเรียนไปยังโฟลเดอร์ที่ตรงกัน
                        print(f"Match found between {student_filename} and {database_image_filename}")  # แสดงข้อความเมื่อพบการจับคู่
                        match_found = True
                        break
                if match_found:
                    break
            if match_found:
                break
        if not match_found:
            print(f"No match found for {student_filename}")  # แสดงข้อความหากไม่พบการจับคู่

# สร้างฟังก์ชันสำหรับสร้างโฟลเดอร์ matches ตามชื่อไฟล์รูปในโฟลเดอร์ database
def create_matches_folders(database_folder):
    matches_folder = "matches"
    os.makedirs(matches_folder, exist_ok=True)  # สร้างโฟลเดอร์ matches หากยังไม่มี

    for filename in os.listdir(database_folder):
        if filename.lower().endswith(('.jpg', '.jpeg', '.png')):  # ตรวจสอบนามสกุลไฟล์ภาพ
            folder_name = os.path.splitext(filename)[0]  # ใช้ชื่อไฟล์เป็นชื่อโฟลเดอร์
            folder_path = os.path.join(matches_folder, folder_name)  # เส้นทางของโฟลเดอร์ย่อย
            os.makedirs(folder_path, exist_ok=True)  # สร้างโฟลเดอร์ย่อย
            print(f"Created folder: {folder_path}")

if __name__ == "__main__":
    create_matches_folders("database")
    database_images = process_images_in_directory("database")  # ประมวลภาพในโฟลเดอร์ฐานข้อมูล
    student_face_descriptors = process_images_in_directory("student_Photo")  # ประมวลภาพในโฟลเดอร์นักเรียน
    match_faces_in_database(student_face_descriptors, database_images)  

    preprocess_image("database", "databaseNum")
    preprocess_image("student_Photo", "student_PhotoNum")
    read_and_compare_numbers("databaseNum", "student_PhotoNum", "student_Photo")

