<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendAccountStudentMail;
use App\Jobs\SendContractMailJob;
use App\Jobs\UpdateFileContract;
use App\Models\BankAccount;
use App\Models\BillHistory;
use App\Models\Certificate;
use App\Models\Contract;
use App\Models\Course;
use App\Models\Language;
use App\Models\Level;
use App\Models\StudentProfile;
use App\Models\TestResult;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::with('studentProfile', 'studentProfile.student', 'course');
        $datas = [];
        $courses = Certificate::all();
        if ($request->filled('course_id')) {
            $datas['course_id'] = $request->get('course_id');
            $contracts = $contracts->where('course_id', $request->get('course_id'));
        }
        if ($request->filled('date')) {
            $datas['date'] = $request->get('date');
            $contracts = $contracts->whereDate('created_at', $request->get('date'));
        }
        if ($request->filled('status')) {
            $datas['status'] = $request->get('status');
            $contracts = $contracts->where('status', $request->get('status'));
        }
        if ($request->filled('sort')) {
            $datas['sort'] = $request->get('sort');
            if ($request->get('sort') == 'asc') {

                $contracts = $contracts->orderBy('created_at', 'asc');
            }
            if ($request->get('sort') == 'desc') {
                $contracts = $contracts->orderBy('created_at', 'desc');
            }
        }
        $contracts = $contracts->get();
        return view('admin.contracts.contract', compact('contracts', 'courses', 'datas'));
    }
    public function addContractIndex(Request $request)
    {
        $languages = Language::all();
        $certificates = Certificate::all();
        $courses = Course::all();
        $students = User::where('role', User::ROLE_STUDENT)->get();
        $levels = Level::all();

        // Khởi tạo mặc định
        $student = new User();
        $course = new Course();
        $certificate = new Certificate();
        // Nếu có student_profile_id và course_id
        if ($request->has('student_profile_id') && $request->get('course_id')) {
            $studentProfileId = $request->get('student_profile_id');
            $studentProfile = StudentProfile::find($studentProfileId);
            if ($studentProfile) {
                $student = User::find($studentProfile->student_id) ?? new User();
            }

            $courseId = $request->get('course_id');
            $course = Course::find($courseId) ?? new Course();

            if ($course->certificate_id) {
                $certificate = Certificate::find($course->certificate_id) ?? new Certificate();
            }
        }
        return view('admin.contracts.add-contract', compact('languages','certificates',
            'courses', 'students', 'student', 'course', 'certificate', 'levels'
        ));
    }


    // public function addContractIndex(Request $request)
    // {
    //     $languages = Language::all();
    //     $certificates = Certificate::all();
    //     $courses = Course::all();

    //     $students = User::where('role', User::ROLE_STUDENT)->get();
    //     $student = new User();
    //     $course = new Course();
    //     $certificate = new Certificate();
    //     $levels = Level::all();
    //    // dd($request->all());
    //     if ($request->has('student_profile_id') && $request->get('course_id')) {
    //        // dd("heheh");
    //         $studentProfileId = $request->get('student_profile_id');
    //        // dd($studentProfileId);
    //         $studentProfile = StudentProfile::find($studentProfileId);
    //         $student = User::find($studentProfile->student_id);

    //         // Xử lý khi có student_profile_id
    //         $courseId = $request->get('course_id');
    //       //  dd($courseId);
    //         $course = Course::find($courseId);

    //         $certificate = Certificate::find($course->certificate_id);
    //      //   $levels = Level::find($course->level_id);
    //     }
    //     //dd($student, $course, $certificate);

    //     return view('admin.contracts.add-contract', compact('languages', 'certificates', 'courses', 'students', 'student', 'course', 'certificate', 'levels'));
    // }

    public function addContract(Request $request)
    {
        $param = $request->all();
        $course = Course::find($param['khoa_hoc']);
        $level_id = Course::find($param['khoa_hoc'])->level_id;
        $student = User::find($param['studentId']);
        if (!$student) {
            $student = User::where('email', $param['email'])->first();
        }
        // chưa student thì tạo mới student và student_profile
        if (!$student) {
            $student = User::create([
                'name' => $param['ho_ten'],
                'email' => $param['email'],
                'phone_number' => $param['so_dien_thoai'],
                'role' => User::ROLE_STUDENT,
                'password' => bcrypt('123456'),
            ]);
            // thêm vào queue đợi server gửi mail tạo mới
           // MailService::sendMailCreateAccount($student);
            // chạy job trên queue php artisan queue:work
            SendAccountStudentMail::dispatch($student->id);
            $studentProfile = StudentProfile::create([
                'student_id' => $student->id,
                'language_id' => $param['ngon_ngu'],
                'certificate_id' => $param['chung_chi'],
                'current_level_id' => $level_id,
                'status' => StudentProfile::STATUS_WAIT_CLASS,

            ]);
        } else {
            $studentProfiles = StudentProfile::where('student_id', $student->id)
                ->where('certificate_id', $param['chung_chi'])
                ->where('language_id', $param['ngon_ngu'])
                ->where('current_level_id', $level_id)
                ->get();
            $checkStudentProfile = true;
            if (count($studentProfiles) != 0) {
                foreach ($studentProfiles as $studentProfile) {
                    if (
                        $studentProfile->status == StudentProfile::STATUS_FINISH
                        || $studentProfile->status == StudentProfile::STATUS_LEARNING

                    ) {
                        $checkStudentProfile = false;
                        break;
                    }

                    // if (
                    //     $studentProfile->status != StudentProfile::STATUS_INCOMPLETE
                    //     && $studentProfile->status != StudentProfile::STATUS_RETAKE
                    //     && $studentProfile->status != StudentProfile::STATUS_DROPOUT
                    //     && $studentProfile->status != StudentProfile::STATUS_WAIT_CLASS


                    // ) {
                    //     $checkStudentProfile = true;
                    //     break;
                    // }
                }
            }
            // kiểm tra nếu checkStudentProfile = true (chưa thỏa mãn điều kiện) thi tạo student_profile mới
            if ($checkStudentProfile) {
                $studentProfile = StudentProfile::where('student_id', $student->id)
                    ->where('certificate_id', $param['chung_chi'])
                    ->where('language_id', $param['ngon_ngu'])
                    ->where('current_level_id', $level_id)
                    ->where('status', StudentProfile::STATUS_WAIT_CLASS)
                    ->first();
                // dd($studentProfile, $level_id);
            } else {
                return redirect()->back()->with('error', 'Học viên đã hoặc đang học khoa học nay.');
            }
        }
        if (!$studentProfile) {
            $studentProfile = StudentProfile::create([
                'student_id' => $student->id,
                'language_id' => $param['ngon_ngu'],
                'certificate_id' => $param['chung_chi'],
                'current_level_id' => $level_id,
                'status' => StudentProfile::STATUS_WAIT_CLASS,

            ]);
            TestResult::create([
                'student_profile_id' => $studentProfile->id,
                'result_status' => TestResult::ROLE_FIRST_TEST,
                'total_score' => $studentProfile->level->min_score,

            ]);
        }
        $contract = Contract::create([
            'student_profile_id' => $studentProfile->id,
            'code' => 'HĐ-' . time(),
            'course_id' => $param['khoa_hoc'],
            'certificate_id' => $param['chung_chi'],

            'sign_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $param['ngay_tao'])->format('Y-m-d'),

            'total_value' => $param['total_value'],
            'collected' => 0,
            'note' => $param['note'],

            'status' => Contract::STATUS_PENDING
        ]);
        SendContractMailJob::dispatch($contract->id);
        //chạy local thì : php artisan queue:work (dùng database)
        return redirect('/admin/contracts/index')->with('success', 'Thêm hóa đơn thành công.');
    }


    public function updateContractIndex(Request $request, $contractId)
    {
        $contract = Contract::with('studentProfile.student', 'course', 'course.certificate', 'course.language')->find($contractId);
        $languages = Language::all();
        $certificates = Certificate::all();
        $courses = Course::all();
        $bills = BillHistory::where('contract_id', $contractId)
            ->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bill_histories.bank_account_id')
            ->orderBy('bill_histories.created_at', 'desc')->get();
        $bankAccounts = BankAccount::whereNull('user_id')->get();
        return view('admin.contracts.edit', compact('contract', 'languages', 'certificates', 'courses', 'bills', 'bankAccounts'));
    }


    public function updateContract(Request $request)
    {
        $param = $request->all();
        $contract = Contract::find($param['contract_id']);
        $contract->total_value = $param['total_value'];
        $contract->save();
        UpdateFileContract::dispatch($contract->id);
        return redirect()->back()->with('success', 'Cập nhật hóa đơn thành công.');
    }


    public function deleteContract(Request $request)
    {
        $param = $request->all();
        $contract = Contract::find($param['contract_id']);
        if ($contract) {
            try {
                $contract->delete();
                BillHistory::where('contract_id', $contract->id)->delete();
                return redirect()->back()->with('success', 'Xóa hóa đơn.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Xóa hóa đơn khóa.');
            }
        } else {
            return redirect()->back()->with('error', 'Hóa đơn không tồn tại.');
        }
    }
    public function addBill(Request $request)
    {
        $param = $request->all();
        // bằng 0: tiền mặt, còn lại là chuyển khoản
        if ($param['phuong_thuc_thanh_toan'] == 0) {
            BillHistory::create([
                'contract_id' => $param['contract_id'],
                'payment_time' => $param['ngay_tao'],
                'money' => $param['so_tien'],
                'content' => $param['noi_dung']
            ]);
        } else {
            // tạo thư mục lưu trữ file ảnh chuyển khoản
            if ($request->hasFile('anh_chuyen_khoan')) {
                $file = $request->file('anh_chuyen_khoan');
                // Tạo tên file duy nhất
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Thư mục lưu trữ (trong public/files/bills)
                $destinationPath = public_path('files/contracts/bills/' . $param['contract_id']);
                // Tạo thư mục nếu chưa có
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                // Di chuyển file vào thư mục public/files/bills
                $file->move($destinationPath, $fileName);
                // Đường dẫn tương đối (để lưu vào DB)
                $filePath = 'files/contracts/bills/' . $param['contract_id'] . '/' . $fileName;
            } else {
                $filePath = null;
            }
            // tạo Bill thanh toán
            BillHistory::create([
                'contract_id' => $param['contract_id'],

                'payment_time' => $param['ngay_tao'],
                'money' => $param['so_tien'],
                'content' => $param['noi_dung'],
                'image' => $filePath,
                'bank_account_id' => $param['phuong_thuc_thanh_toan']
            ]);
        }
        // cập nhật số tiền đã thanh toán và trạng thái của hợp đồng đã thanh toán đủ
        $contract = Contract::find($param['contract_id']);
        $contract->collected += $param['so_tien'];
        if ($contract->total_value == $contract->collected) {
            $contract->status = Contract::STATUS_DONE;
        }
        $contract->save();
        return redirect()->back()->with('success', 'Them hóa đơn thanh cong.');
    }

    public function deleteBill(Request $request)
    {
        $param = $request->all();
        $bill = BillHistory::find($param['bill_id']);
        $contract = Contract::find($bill->contract_id);
        $contract->collected -= $bill->money;
        if ($contract->total_value == $contract->collected) {
            $contract->status = Contract::STATUS_DONE;
        } else {
            $contract->status = Contract::STATUS_PENDING;
        }
        $contract->save();
        $bill->delete();

        return redirect()->back()->with('success', 'Xoa hóa đơn thanh cong.');
    }
}
