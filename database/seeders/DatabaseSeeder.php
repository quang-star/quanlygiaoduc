<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------- USERS ----------------
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'phone_number' => '0909000001',
                'password' => Hash::make('123456'),
                'role' => 1,
                'birthday' => '1990-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nguyễn Văn Học',
                'email' => 'hocvien@example.com',
                'phone_number' => '0909123456',
                'password' => Hash::make('123456'),
                'role' => 3,
                'birthday' => '2004-05-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Giáo viên Anh',
                'email' => 'giaovien@example.com',
                'phone_number' => '0909345678',
                'password' => Hash::make('123456'),
                'role' => 2,
                'birthday' => '1988-09-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---------------- LANGUAGES ----------------
        DB::table('languages')->insert([
            ['code' => 'EN', 'name' => 'Tiếng Anh', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'JP', 'name' => 'Tiếng Nhật', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'KR', 'name' => 'Tiếng Hàn', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---------------- CERTIFICATES ----------------
        DB::table('certificates')->insert([
            ['language_id' => 1, 'code' => 'TOEIC', 'name' => 'TOEIC', 'created_at' => now(), 'updated_at' => now()],
            ['language_id' => 1, 'code' => 'IELTS', 'name' => 'IELTS', 'created_at' => now(), 'updated_at' => now()],
            ['language_id' => 2, 'code' => 'JLPT', 'name' => 'Japanese-Language Proficiency Test', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---------------- LEVELS ----------------
        DB::table('levels')->insert([
            ['name' => 'A1', 'certificate_id' => 1, 'min_score' => 0, 'max_score' => 300, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A2', 'certificate_id' => 1, 'min_score' => 301, 'max_score' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B1', 'certificate_id' => 2, 'min_score' => 5.0, 'max_score' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'N3', 'certificate_id' => 3, 'min_score' => 0, 'max_score' => 180, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---------------- COURSES ----------------
        DB::table('courses')->insert([
            [
                'code' => 'EN-B1-2025',
                'name' => 'Khóa học IELTS B1',
                'language_id' => 1,
                'certificate_id' => 2,
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'JP-N3-2025',
                'name' => 'Khóa học JLPT N3',
                'language_id' => 2,
                'certificate_id' => 3,
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---------------- STUDENT PROFILES ----------------
        DB::table('student_profiles')->insert([
            [
                'student_id' => 2,
                'language_id' => 1,
                'current_level_id' => 1,
                'certificate_id' => 1,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ---------------- CLASSES ----------------
        DB::table('classes')->insert([
            [
                'name' => 'Lớp IELTS B1 - Sáng',
                'teacher_id' => 3,
                'course_id' => 1,
                'start_date' => '2025-10-13 08:00:00',
                'end_date' => '2025-12-30 10:00:00',
                'total_lesson' => 20,
                'lesson_per_week' => 3,
                'schedule' => 'Thứ 2, 4, 6',
                'time_start' => '08:00:00',
                'time_end' => '10:00:00',
                'min_student' => 5,
                'max_student' => 20,
                'status' => 1,
                'note' => 'Lớp cơ bản',
                'day_learn' => 'Mon, Wed, Fri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---------------- ATTENDANCES ----------------
        DB::table('attendances')->insert([
            [
                'student_id' => 2,
                'class_id' => 1,
                'time_attendance' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ---------------- ENTRANCE EXAMS ----------------
        DB::table('entrance_exams')->insert([
            [
                'certificate_id' => 1,
                'name' => 'TOEIC Placement Test',
                'pdf_test_file' => 'tests/toeic_sample.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---------------- TEST RESULTS ----------------
        DB::table('test_results')->insert([
            [
                'student_id' => 2,
                'exam_id' => 1,
                'test_date' => '2025-10-11 09:00:00',
                'total_score' => 350.0,
                'result_status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ---------------- CONTRACTS ----------------
        DB::table('contracts')->insert([
            [
                'code' => 'HD001',
                'student_id' => 2,
                'sign_date' => '2025-10-11 09:30:00',
                'certificate_id' => 2,
                'class_id' => 1,
                'course_id' => 1,
                'status' => 1,
                'total_value' => 3500000.0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ---------------- BANK ACCOUNTS ----------------
        DB::table('bank_accounts')->insert([
            ['bank' => 'Vietcombank', 'account_number' => '0123456789', 'created_at' => now(), 'updated_at' => now()],
            ['bank' => 'Techcombank', 'account_number' => '0987654321', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---------------- BILL HISTORIES ----------------
        DB::table('bill_histories')->insert([
            [
                'contract_id' => 1,
                'payment_time' => '2025-10-11 10:00:00',
                'phone_number' => '0909123456',
                'money' => 1500000.0,
                'bank_account_id' => 1,
                'image' => 'bills/payment_1.jpg',
                'content' => 'Đã thanh toán đợt 1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
