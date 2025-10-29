<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Import các Models cần thiết
use App\Models\Language;
use App\Models\Certificate;
use App\Models\Level;
use App\Models\Course;
use App\Models\BankAccount;
use App\Models\Shift;
use App\Models\Setting;
use App\Models\ClassModel; // Đổi tên Classes thành ClassModel hoặc tương tự nếu bạn có class tên là "Class"
use App\Models\TeacherSalary;
use App\Models\EntranceExam;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      
        // USERS TABLE
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '0909000001',
            'password' => Hash::make('password'),
            'avatar' => 'images/avatars/1.jpg',
            'birthday' => '1990-01-01',
            'base_salary' => null,
            'role' => 0,
            'active' => 1,
            'remember_token' => 'KxIcHlbHqDKay6TIMDgpT3WfEKy7AMjPQI3o2AMbgnA5u2rnNKCI5sP2hWJd',
            'created_at' => '2025-10-11 03:30:49',
            'updated_at' => '2025-10-22 03:36:23',
        ]);

        User::create([
            'id' => 77, // Match ID from your SQL dump
            'name' => 'Teacher One',
            'email' => 'teacher1@example.com',
            'phone_number' => '0123456789',
            'password' => Hash::make('password'),
            'avatar' => null,
            'birthday' => '1985-05-10',
            'base_salary' => 10000000,
            'role' => 1,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'id' => 78, // Match ID from your SQL dump
            'name' => 'Teacher Two',
            'email' => 'teacher2@example.com',
            'phone_number' => '0987654321',
            'password' => Hash::make('password'),
            'avatar' => null,
            'birthday' => '1988-11-20',
            'base_salary' => 1000000,
            'role' => 1,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // LANGUAGES TABLE
        Language::create(['id' => 1, 'code' => 'EN', 'name' => 'Tiếng Anh', 'created_at' => '2025-10-11 10:30:50', 'updated_at' => '2025-10-11 10:30:50']);
        Language::create(['id' => 2, 'code' => 'JP', 'name' => 'Tiếng Nhật', 'created_at' => '2025-10-11 10:30:50', 'updated_at' => '2025-10-11 10:30:50']);
        Language::create(['id' => 3, 'code' => 'CN', 'name' => 'Tiếng Trung', 'created_at' => '2025-10-11 10:30:50', 'updated_at' => '2025-10-14 09:26:41']);
        Language::create(['id' => 6, 'code' => 'KOREA', 'name' => 'Tiếng Hàn', 'created_at' => '2025-10-24 08:24:25', 'updated_at' => '2025-10-24 08:24:25']);

        // Define additional Certificate IDs that are used as foreign keys in entrance_exams
        // These might not have full details but need to exist for FK constraints
        // Adjust language_id as appropriate for these placeholder certificates
        $englishId = Language::where('code', 'EN')->first()->id;
        $japaneseId = Language::where('code', 'JP')->first()->id;

        // CERTIFICATES TABLE
        Certificate::create(['id' => 6, 'language_id' => $englishId, 'code' => 'TOEIC', 'name' => 'TOEIC', 'created_at' => '2025-10-14 08:15:29', 'updated_at' => '2025-10-14 08:15:29']);
        Certificate::create(['id' => 7, 'language_id' => Language::where('code', 'CN')->first()->id, 'code' => 'HSK', 'name' => 'HSK', 'created_at' => '2025-10-14 09:26:57', 'updated_at' => '2025-10-14 09:26:57']);
        Certificate::create(['id' => 8, 'language_id' => $japaneseId, 'code' => 'JLPT', 'name' => 'JLPT', 'created_at' => '2025-10-14 09:28:12', 'updated_at' => '2025-10-14 09:28:12']);
        Certificate::create(['id' => 9, 'language_id' => $japaneseId, 'code' => 'NAT', 'name' => 'NAT', 'created_at' => '2025-10-14 09:28:58', 'updated_at' => '2025-10-14 09:28:58']);
        Certificate::create(['id' => 10, 'language_id' => $englishId, 'code' => 'IELTS', 'name' => 'IELTS', 'created_at' => '2025-10-14 09:30:25', 'updated_at' => '2025-10-14 09:30:25']);
        Certificate::create(['id' => 15, 'language_id' => Language::where('code', 'KOREA')->first()->id, 'code' => 'TOPIK', 'name' => 'TOPIK', 'created_at' => '2025-10-24 09:05:09', 'updated_at' => '2025-10-24 09:05:09']);

        // Placeholder certificates for entrance exams that aren't fully defined in certificates table
        Certificate::create(['id' => 11, 'language_id' => $englishId, 'code' => 'GEN-ENG', 'name' => 'General English Cert', 'created_at' => now(), 'updated_at' => now()]);
        Certificate::create(['id' => 13, 'language_id' => $englishId, 'code' => 'ACAD-ENG', 'name' => 'Academic English Cert', 'created_at' => now(), 'updated_at' => now()]);
        Certificate::create(['id' => 14, 'language_id' => $englishId, 'code' => 'BUSINESS-ENG', 'name' => 'Business English Cert', 'created_at' => now(), 'updated_at' => now()]);
        Certificate::create(['id' => 16, 'language_id' => $japaneseId, 'code' => 'NAT-TEST', 'name' => 'NAT Test Certificate', 'created_at' => now(), 'updated_at' => now()]);


        // LEVELS TABLE
        Level::create(['id' => 9, 'name' => 1, 'certificate_id' => 6, 'min_score' => 0, 'max_score' => 450, 'created_at' => '2025-10-14 09:32:46', 'updated_at' => '2025-10-14 09:32:46']);
        Level::create(['id' => 10, 'name' => 2, 'certificate_id' => 6, 'min_score' => 451, 'max_score' => 700, 'created_at' => '2025-10-14 09:33:05', 'updated_at' => '2025-10-14 09:33:05']);
        Level::create(['id' => 11, 'name' => 3, 'certificate_id' => 6, 'min_score' => 701, 'max_score' => 900, 'created_at' => '2025-10-14 09:33:17', 'updated_at' => '2025-10-14 09:33:17']);
        Level::create(['id' => 12, 'name' => 1, 'certificate_id' => 10, 'min_score' => 0, 'max_score' => 4.5, 'created_at' => '2025-10-14 09:34:05', 'updated_at' => '2025-10-14 09:34:05']);
        Level::create(['id' => 13, 'name' => 2, 'certificate_id' => 10, 'min_score' => 4.6, 'max_score' => 6, 'created_at' => '2025-10-14 09:40:30', 'updated_at' => '2025-10-14 09:40:30']);
        Level::create(['id' => 15, 'name' => 3, 'certificate_id' => 10, 'min_score' => 6.1, 'max_score' => 7.5, 'created_at' => '2025-10-14 09:42:06', 'updated_at' => '2025-10-14 09:42:06']);
        Level::create(['id' => 16, 'name' => 1, 'certificate_id' => 9, 'min_score' => 0, 'max_score' => 10000, 'created_at' => '2025-10-17 07:27:42', 'updated_at' => '2025-10-17 07:27:42']);
        Level::create(['id' => 17, 'name' => 1, 'certificate_id' => 15, 'min_score' => 0, 'max_score' => 10000, 'created_at' => '2025-10-24 09:05:36', 'updated_at' => '2025-10-24 09:05:36']);
        Level::create(['id' => 18, 'name' => 1, 'certificate_id' => 8, 'min_score' => 1, 'max_score' => 12, 'created_at' => '2025-10-25 08:32:32', 'updated_at' => '2025-10-25 08:32:32']);


        // COURSES TABLE
        Course::create(['id' => 10, 'price' => 5000000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => 'abc', 'code' => 'TOEIC-1', 'name' => 'TOEIC for beginner', 'language_id' => 1, 'certificate_id' => 6, 'level_id' => 9, 'created_at' => '2025-10-14 09:55:04', 'updated_at' => '2025-10-14 09:55:04']);
        Course::create(['id' => 11, 'price' => 5000000, 'total_lesson' => 30, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => 'abcxz', 'code' => 'TOEIC-2', 'name' => 'TOEICE for 2', 'language_id' => 1, 'certificate_id' => 6, 'level_id' => 10, 'created_at' => '2025-10-14 09:56:42', 'updated_at' => '2025-10-14 09:56:42']);
        Course::create(['id' => 12, 'price' => 5000000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => 'absd', 'code' => 'TOEIC-3', 'name' => 'TOEICE for 3', 'language_id' => 1, 'certificate_id' => 6, 'level_id' => 11, 'created_at' => '2025-10-14 09:57:00', 'updated_at' => '2025-10-14 09:57:00']);
        Course::create(['id' => 13, 'price' => 5000000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => '112', 'code' => 'IELTS-1', 'name' => 'IELTS for beginner', 'language_id' => 1, 'certificate_id' => 10, 'level_id' => 12, 'created_at' => '2025-10-14 09:58:08', 'updated_at' => '2025-10-14 09:58:08']);
        Course::create(['id' => 14, 'price' => 5000000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => 'da', 'code' => 'IELTS-2', 'name' => 'IELTS for 2', 'language_id' => 1, 'certificate_id' => 10, 'level_id' => 13, 'created_at' => '2025-10-14 09:58:22', 'updated_at' => '2025-10-14 09:58:22']);
        Course::create(['id' => 15, 'price' => 5000000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'description' => '54', 'code' => 'IELTS-3', 'name' => 'IELTS for 3', 'language_id' => 1, 'certificate_id' => 10, 'level_id' => 15, 'created_at' => '2025-10-14 09:58:39', 'updated_at' => '2025-10-14 09:58:39']);
        Course::create(['id' => 17, 'price' => 50000, 'total_lesson' => 20, 'lesson_per_week' => 2, 'max_student' => 11, 'min_student' => 1, 'description' => null, 'code' => 'JLPT-1', 'name' => 'Nguyễn Kim Quan13', 'language_id' => 2, 'certificate_id' => 8, 'level_id' => 18, 'created_at' => '2025-10-25 08:32:54', 'updated_at' => '2025-10-25 08:32:54']);


        // BANK_ACCOUNTS TABLE
        BankAccount::create(['id' => 1, 'bank' => 'Vietcombank', 'account_number' => '0123456789', 'created_at' => '2025-10-11 10:30:50', 'updated_at' => '2025-10-11 10:30:50', 'user_id' => null]);
        BankAccount::create(['id' => 2, 'bank' => 'Techcombank', 'account_number' => '0987654321', 'created_at' => '2025-10-11 10:30:50', 'updated_at' => '2025-10-11 10:30:50', 'user_id' => null]);
        BankAccount::create(['id' => 3, 'bank' => 'Vietcombank', 'account_number' => '1234567', 'created_at' => '2025-10-20 01:26:08', 'updated_at' => '2025-10-20 01:26:08', 'user_id' => null]);
        BankAccount::create(['id' => 4, 'bank' => 'BIDV', 'account_number' => '09887654421', 'created_at' => '2025-10-20 01:27:02', 'updated_at' => '2025-10-20 01:27:02', 'user_id' => null]);
        BankAccount::create(['id' => 5, 'bank' => 'BIDV', 'account_number' => '0974213318', 'created_at' => '2025-10-20 07:20:59', 'updated_at' => '2025-10-20 07:20:59', 'user_id' => null]);
        BankAccount::create(['id' => 6, 'bank' => 'Techcombank', 'account_number' => '0987654321', 'created_at' => '2025-10-22 09:18:44', 'updated_at' => '2025-10-22 09:18:44', 'user_id' => 77]); // Linked to Teacher One
        BankAccount::create(['id' => 7, 'bank' => 'MB Bank', 'account_number' => 'heheh', 'created_at' => '2025-10-22 09:19:38', 'updated_at' => '2025-10-22 09:19:38', 'user_id' => 78]); // Linked to Teacher Two


        // SHIFTS TABLE
        Shift::create(['id' => 4, 'start_time' => '13:30:00', 'end_time' => '15:00:00', 'created_at' => '2025-10-22 09:13:52', 'updated_at' => '2025-10-22 09:13:52']);
        Shift::create(['id' => 5, 'start_time' => '15:30:00', 'end_time' => '17:00:00', 'created_at' => '2025-10-22 09:14:25', 'updated_at' => '2025-10-22 09:14:25']);
        Shift::create(['id' => 6, 'start_time' => '18:00:00', 'end_time' => '19:30:00', 'created_at' => '2025-10-22 09:14:48', 'updated_at' => '2025-10-22 09:14:48']);
        Shift::create(['id' => 7, 'start_time' => '20:00:00', 'end_time' => '21:30:00', 'created_at' => '2025-10-22 09:15:14', 'updated_at' => '2025-10-22 09:15:14']);


        // CLASSES TABLE (assuming 'Classes' is your model name, if not, adjust it)
        ClassModel::create(['id' => 20, 'name' => 'IELTS begin1', 'teacher_id' => 77, 'course_id' => 13, 'start_date' => '2025-10-21 17:00:00', 'end_date' => '2025-12-12 17:00:00', 'total_lesson' => 20, 'lesson_per_week' => 2, 'schedule' => '[{"day":"Thứ 2","shift":6},{"day":"Thứ 5","shift":7}]', 'time_start' => null, 'time_end' => null, 'min_student' => 10, 'max_student' => 20, 'status' => 0, 'note' => null, 'day_learn' => '2025-10-23,2025-10-27,2025-10-30,2025-11-03,2025-11-06,2025-11-10,2025-11-13,2025-11-17,2025-11-20,2025-11-24,2025-11-27,2025-12-01,2025-12-04,2025-12-08,2025-12-11', 'created_at' => '2025-10-22 09:27:25', 'updated_at' => '2025-10-25 03:28:01', 'supporter_id' => null]);
        ClassModel::create(['id' => 21, 'name' => 'fpt', 'teacher_id' => 78, 'course_id' => 11, 'start_date' => '2025-10-15 17:00:00', 'end_date' => '2025-11-19 17:00:00', 'total_lesson' => 30, 'lesson_per_week' => 2, 'max_student' => 20, 'min_student' => 10, 'status' => 1, 'note' => null, 'schedule' => '[{"day":"Thứ 2","shift":4},{"day":"Thứ 5","shift":7}]', 'time_start' => null, 'time_end' => null, 'day_learn' => '2025-10-16,2025-10-20,2025-10-23,2025-10-27,2025-10-30,2025-11-03,2025-11-06,2025-11-10,2025-11-13,2025-11-17,2025-11-20', 'created_at' => '2025-10-25 15:14:17', 'updated_at' => '2025-10-25 15:14:17', 'supporter_id' => null]);


        // TEACHER_SALARIES TABLE
        TeacherSalary::create(['id' => 7, 'teacher_id' => 77, 'month' => '2025-10', 'total_sessions' => 3, 'base_salary' => 10000000, 'bonus' => 0, 'penalty' => 0, 'total_salary' => 30000000, 'bank_name' => 'Techcombank', 'account_number' => '0987654321', 'status' => 1, 'note' => null, 'created_at' => '2025-10-22 10:26:48', 'updated_at' => '2025-10-22 10:26:48']);
        TeacherSalary::create(['id' => 8, 'teacher_id' => 78, 'month' => '2025-10', 'total_sessions' => 0, 'base_salary' => 1000000, 'bonus' => 0, 'penalty' => 0, 'total_salary' => 0, 'bank_name' => 'MB Bank', 'account_number' => 'heheh', 'status' => 1, 'note' => null, 'created_at' => '2025-10-22 10:26:48', 'updated_at' => '2025-10-22 10:26:48']);


        // ENTRANCE_EXAMS TABLE
        EntranceExam::create(['id' => 2, 'certificate_id' => 11, 'name' => 'Bài kiểm tra đầu vào 1', 'pdf_test_file' => 'a.sql', 'created_at' => '2025-10-14 10:22:55', 'updated_at' => '2025-10-14 10:22:55']);
        EntranceExam::create(['id' => 3, 'certificate_id' => 14, 'name' => 'bai_kiem_tra_2_1760694795.xlsx', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_2_1760694795.xlsx', 'created_at' => '2025-10-17 02:53:15', 'updated_at' => '2025-10-17 02:53:15']);
        EntranceExam::create(['id' => 4, 'certificate_id' => 13, 'name' => 'bai_kiem_tra_5_1760695055.pdf', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_5_1760695055.pdf', 'created_at' => '2025-10-17 02:57:14', 'updated_at' => '2025-10-17 02:57:35']);
        EntranceExam::create(['id' => 5, 'certificate_id' => 6, 'name' => 'bai_kiem_tra_toeic_1761320110.pdf', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_toeic_1761320110.pdf', 'created_at' => '2025-10-24 08:35:10', 'updated_at' => '2025-10-24 08:35:10']);
        EntranceExam::create(['id' => 6, 'certificate_id' => 15, 'name' => 'bai_kiem_tra_topik_1761321910.php', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_topik_1761321910.php', 'created_at' => '2025-10-24 09:05:10', 'updated_at' => '2025-10-24 09:05:10']);
        EntranceExam::create(['id' => 7, 'certificate_id' => 7, 'name' => 'bai_kiem_tra_hsk_1761322391.pdf', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_hsk_1761322391.pdf', 'created_at' => '2025-10-24 09:13:11', 'updated_at' => '2025-10-24 09:13:11']);
        EntranceExam::create(['id' => 8, 'certificate_id' => 16, 'name' => 'bai_kiem_tra_12212_1761380481.pdf', 'pdf_test_file' => 'files/entrance_exams/bai_kiem_tra_12212_1761380481.pdf', 'created_at' => '2025-10-25 08:21:21', 'updated_at' => '2025-10-25 08:21:21']);


        // SETTINGS TABLE
        Setting::create(['id' => 1, 'key' => 'site_name', 'value' => 'hehhe', 'created_at' => '2025-10-23 02:56:56', 'updated_at' => '2025-10-24 10:33:10']);
        Setting::create(['id' => 2, 'key' => 'address', 'value' => 'Thái Bình', 'created_at' => '2025-10-23 02:56:56', 'updated_at' => '2025-10-23 03:14:46']);
        Setting::create(['id' => 3, 'key' => 'phone', 'value' => '0974213318', 'created_at' => '2025-10-23 02:56:56', 'updated_at' => '2025-10-23 03:14:46']);
        Setting::create(['id' => 4, 'key' => 'email', 'value' => 'quangnguyenkim1612@gmail.com', 'created_at' => '2025-10-23 02:56:56', 'updated_at' => '2025-10-23 03:14:46']);
        Setting::create(['id' => 5, 'key' => 'language', 'value' => 'vi', 'created_at' => '2025-10-23 02:56:56', 'updated_at' => '2025-10-23 02:56:56']);
    }
}