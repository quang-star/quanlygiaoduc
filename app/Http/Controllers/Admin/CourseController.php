<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Language;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function getIndex(Request $request)
    {
        $param = $request->all();
        // lấy dữ liệu của các khóa học
        $courses = Course::with(['certificate', 'level']);
        $datas = [];
        if($request->filled('certificate_id')) {
            $datas['certificate_id'] = $request->certificate_id;
            $courses = $courses->where('certificate_id', $request->certificate_id);
        }
        $courses = $courses->get();
        $certificates = Certificate::all();
        return view('admin.courses.index', compact('courses', 'certificates', 'datas'));
    }

    public function addCourse(Request $request)
    {
        // Lấy dữ liệu cho các combobox
        $languages = Language::all();
        $certificates = Certificate::all();
        $levels = Level::all();

        return view('admin.courses.add', compact('languages', 'certificates', 'levels'));
    }

    public function storeCourse(Request $request)
    {
        $param = $request->all();
        $certificate = Certificate::find($request->certificate_id);
        $level = Level::find($request->level_id);
        // Tạo mã khóa học dạng: TENCHUNGCHI-TENLEVEL (viết hoa)
        $code = strtoupper($certificate->name . '-' . $level->name);

          // check xem có khóa như này nữa không
        $checkCourse = Course::where('language_id', $request->language_id)
        ->where('certificate_id', $request->certificate_id)
        ->where('level_id', $request->level_id)
        ->first();

        if ($checkCourse) {
            return redirect()->back()->withInput()->with('error', 'Khóa học nay da ton tai!');
        }
        // Lưu vào database


        Course::create([
            'code' => $code, // tự sinh mã KH
            'name' => $request->name,
            'language_id' => $request->language_id,
            'certificate_id' => $request->certificate_id,
            'level_id' => $request->level_id,
            'price' => $request->price,
            'total_lesson' => $request->total_lesson,
            'lesson_per_week' => $request->lesson_per_week,
            'max_student' => $request->max_student,
            'min_student' => $request->min_student,
            'description' => $request->description,
        ]);

        return redirect('/admin/courses/index')->with('success', 'Thêm khóa học thành công!');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $languages = Language::all();
        $certificates = Certificate::all();
        $levels = Level::all();

        return view('admin.courses.edit', compact('course', 'languages', 'certificates', 'levels'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Lấy chứng chỉ và level để sinh lại mã khóa học
        $certificate = Certificate::find($request->certificate_id);
        $level = Level::find($request->level_id);
        $code = strtoupper($certificate->name . '-' . $level->name);
        // check xem có khóa như này nữa không
        $checkCourse = Course::where('language_id', $request->language_id)
        ->where('certificate_id', $request->certificate_id)
        ->where('level_id', $request->level_id)
        ->where('id', '!=', $id)
        ->first();

        if ($checkCourse) {
            return redirect()->back()->withInput()->with('error', 'Khóa học nay da ton tai!');
        }
        $course->update([
            'code' => $code, // tự sinh mã KH
            'name' => $request->name,
            'language_id' => $request->language_id,
            'certificate_id' => $request->certificate_id,
            'level_id' => $request->level_id,
            'price' => $request->price,
            'total_lesson' => $request->total_lesson,
            'lesson_per_week' => $request->lesson_per_week,
            'max_student' => $request->max_student,
            'min_student' => $request->min_student,
            'description' => $request->description,
        ]);

        return redirect('admin/courses/index')
        ->with('success', 'Cập nhật khóa học thành công!');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->back()->with('success', 'Xóa khóa học thành công!');
    }
}
