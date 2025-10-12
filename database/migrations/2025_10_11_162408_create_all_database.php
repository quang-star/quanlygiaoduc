<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---------------- USERS ----------------
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone_number', 20)->nullable();
            $table->string('password', 255);
            $table->string('avatar', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->integer('role'); // ->comment('1=admin, 2=staff, 3=student, 4=supporter')
            $table->rememberToken();
            $table->timestamps();
        });

        // ---------------- LANGUAGES ----------------
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->string('name', 255);
            $table->timestamps();
        });

        // ---------------- CERTIFICATES ----------------
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('language_id')->index();
            $table->string('code', 50);
            $table->string('name', 255);
            $table->timestamps();
        });

        // ---------------- LEVELS ----------------
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('certificate_id')->index();
            $table->double('min_score')->nullable();
            $table->double('max_score')->nullable();
            $table->timestamps();
        });

        // ---------------- COURSES ----------------
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name', 255);
            $table->integer('language_id')->index();
            $table->integer('certificate_id')->index();
            $table->integer('level_id')->index();
            $table->timestamps();
        });

        // ---------------- STUDENT PROFILES ----------------
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->index();
            $table->integer('language_id')->index();
            $table->integer('current_level_id')->nullable()->index();
            $table->integer('certificate_id')->nullable()->index();
            $table->integer('status'); // >default(0)->comment('0:chờ test, 1:chờ xếp lớp, 2:đang học, 3:đã học')
            $table->timestamps();
        });

        // ---------------- CLASSES ----------------
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('teacher_id')->index();
            $table->integer('course_id')->index();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('total_lesson')->nullable();
            $table->integer('lesson_per_week')->nullable();
            $table->string('schedule', 255)->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->integer('min_student')->nullable();
            $table->integer('max_student')->nullable();
            $table->integer('status')->nullable(); // ->default(0)->comment('0=scheduled,1=running,2=completed')
            $table->string('note', 255)->nullable();
            $table->string('day_learn', 255)->nullable();
            $table->timestamps();
        });

        // ---------------- ATTENDANCES ----------------
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->index();
            $table->integer('class_id')->index();
            $table->timestamp('time_attendance')->nullable();
            $table->timestamps();
        });

        // ---------------- ENTRANCE EXAMS ----------------
        Schema::create('entrance_exams', function (Blueprint $table) {
            $table->id();
            $table->integer('certificate_id')->index();
            $table->string('name', 255)->nullable();
            $table->string('pdf_test_file', 255)->nullable();
            $table->timestamps();
        });

        // ---------------- TEST RESULTS ----------------
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->index();
            $table->integer('exam_id')->index();
            $table->timestamp('test_date')->nullable();
            $table->double('total_score')->nullable();
            $table->string('result_status', 50)->nullable();
            $table->timestamps();
        });

        // ---------------- CONTRACTS ----------------
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->integer('student_id')->index();
            $table->timestamp('sign_date')->nullable();
            $table->integer('certificate_id')->nullable()->index();
            $table->integer('class_id')->nullable()->index();
            $table->integer('course_id')->nullable()->index();
            $table->integer('status')->nullable(); // ->default(0)
            $table->double('total_value');
            $table->timestamps();
        });

        // ---------------- BANK ACCOUNTS ----------------
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank', 255);
            $table->string('account_number', 50);
            $table->timestamps();
        });

        // ---------------- BILL HISTORIES ----------------
        Schema::create('bill_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->index();
            $table->timestamp('payment_time')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->double('money');
            $table->integer('bank_account_id')->nullable()->index();
            $table->string('image', 255)->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_histories');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('test_results');
        Schema::dropIfExists('entrance_exams');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('users');
    }
};
