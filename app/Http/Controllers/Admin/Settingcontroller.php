<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Certificate;
use App\Models\EntranceExam;
use App\Models\Language;
use App\Models\Level;
use App\Models\Setting;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Settingcontroller extends Controller
{
    public function languageIndex(Request $request)
    {
        $languages = Language::all();
        return view('admin.settings.language', compact('languages'));
    }
    public function languageAdd(Request $request)
    {
        $param = $request->all();
        $language = Language::where('name', $param['language_name'])
            ->orWhere('code', $param['language_code'])
            ->first();
        // nếu có ngôn ngữ thì thông báo ngôn ngữ đã tồn nếu không thì thêm ngôn ngữ
        if ($language) {
            return redirect()->back()->with('error', 'Ngôn ngữ đã tồn tại.');
        } else {
            Language::create([
                'name' => $param['language_name'],
                'code' => $param['language_code'],
            ]);
            return redirect('/admin/settings/languages/index')->with('success', 'Thêm ngôn ngữ thành công.');
        }
    }
    public function languageUpdate(Request $request)
    {
        $param = $request->all();
        //dd($param);
        $language = Language::find($param['language_id']);
        if ($language) {
            $language->name = $param['language_name'];
            $language->code = $param['language_code'];
            $language->save();
            return redirect('/admin/settings/languages/index')->with('success', 'Cập nhật ngôn ngữ thành công.');
        } else {
            return redirect('/admin/settings/language/index')->with('error', 'Ngôn ngữ không tồn tại.');
        }
    }

    public function languageDelete(Request $request)
    {
        $param = $request->all();
        $language = Language::find($param['language_id']);
        if ($language) {
            $language->delete();
            return redirect()->back()->with('success', 'Xóa ngôn ngữ thành công.');
        } else {
            return redirect()->back()->with('error', 'Ngôn ngữ không tồn tại.');
        }
    }

    public function certificateIndex(Request $request)
    {
        $certificates = Certificate::with('language', 'entranceExams')->get();
        $languages = Language::all();

        //dd($certificates);
        return view('admin.settings.certificate', compact('certificates', 'languages'));
    }
    public function certificateAdd(Request $request)
    {
        $param = $request->all();

        $certificate = Certificate::where('name', $param['certificate_name'])
            ->orWhere('code', $param['certificate_code'])
            ->where('language_id', $param['language_id'])
            ->first();

        if ($certificate) {
            return redirect()->back()->with('error', 'Chứng chỉ đã tồn tại.');
        }
        $certificate = Certificate::create([
            'name' => $param['certificate_name'],
            'code' => $param['certificate_code'],
            'language_id' => $param['language_id'],
        ]);
        // lưu file bài kiểm tra của chứng chỉ
        if ($request->hasFile('entrance_exam')) {
            $file = $request->file('entrance_exam');

            //  Tạo tên file an toàn
            $file_name = 'bai_kiem_tra_' . Str::slug($certificate->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Tạo thư mục nếu chưa có
            $destinationPath = public_path('files/entrance_exams');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Di chuyển file vào public/files/entrance_exams
            $file->move($destinationPath, $file_name);

            // Lưu vào bảng EntranceExam
            EntranceExam::create([
                'certificate_id' => $certificate->id,
                'name' => $file_name,
                'pdf_test_file' => 'files/entrance_exams/' . $file_name,
            ]);
        }
        return redirect('/admin/settings/certificates/index')->with('success', 'Thêm chứng chỉ thành công.');
    }




    public function certificateUpdate(Request $request)
    {
        $param = $request->all();
        $certificate = Certificate::find($param['certificate_id']);
        // nếu không có chứng chỉ thì thống báo lỗi
        if (!$certificate) {
            return redirect('/admin/settings/certificates/index')
                ->with('error', 'Chứng chỉ không tồn tại.');
        }
        // Kiểm tra trùng lặp
        $existingCertificate = Certificate::where(function ($query) use ($param) {
            $query->where('name', $param['certificate_name'])
                ->orWhere('code', $param['certificate_code']);
        })
            ->where('language_id', $param['language_id'])
            ->where('id', '!=', $param['certificate_id']) // bỏ qua chứng chỉ hiện tại
            ->first();
        if ($existingCertificate) {
            return redirect()->back()->with('error', 'Chứng chỉ bị trùng.');
        }
        // Cập nhật thông tin cơ bản
        $certificate->name = $param['certificate_name'];
        $certificate->code = $param['certificate_code'];
        $certificate->language_id = $param['language_id'];
        $certificate->save();
        // Nếu có upload file mới
        if ($request->hasFile('entrance_exam')) {
            $file = $request->file('entrance_exam');
            $file_name = 'bai_kiem_tra_' . Str::slug($certificate->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('files/entrance_exams');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // 🔥 Xóa file cũ (nếu có)
            $exam = EntranceExam::where('certificate_id', $certificate->id)->first();
            if ($exam && File::exists(public_path($exam->pdf_test_file))) {
                File::delete(public_path($exam->pdf_test_file));
            }

            // 🔼 Lưu file mới
            $file->move($destinationPath, $file_name);
            $path = 'files/entrance_exams/' . $file_name;

            // 🔁 Nếu đã có bản ghi exam → update, nếu chưa → tạo mới
            if ($exam) {
                $exam->update([
                    'name' => $file_name,
                    'pdf_test_file' => $path
                ]);
            } else {
                EntranceExam::create([
                    'certificate_id' => $certificate->id,
                    'name' => $file_name,
                    'pdf_test_file' => $path
                ]);
            }
        }
        return redirect('/admin/settings/certificates/index')
            ->with('success', 'Cập nhật chứng chỉ thành công.');
    }


    public function certificateDelete(Request $request)
    {
        $param = $request->all();
        $certificate = Certificate::find($param['certificate_id']);
        if ($certificate) {
            $certificate->delete();
            return redirect()->back()->with('success', 'Xóa chứng chỉ thành công.');
        } else {
            return redirect()->back()->with('error', 'Chứng chỉ không tồn tại.');
        }
    }

    public function levelIndex(Request $request)
    {
        $levels = Level::with(['certificate.language', 'certificate'])
        ->orderBy('certificate_id', 'asc')
        ->get();
        $languages = Language::all();
        $certificates = Certificate::all();
        //dd($levels);
        return view('admin.settings.level', compact('levels', 'languages', 'certificates'));
    }

    public function levelAdd(Request $request)
    {
        $param = $request->all();
        $level = Level::where('name', $param['level_name'])
            ->where('certificate_id', $param['certificate_id'])
            ->first();
        if ($level) {
            return redirect()->back()->with('error', 'Trình độ đã tồn tại.');
        } else {
            // Thêm mới level nếu chưa tồn tại
            Level::create([
                'name' => $param['level_name'],
                'certificate_id' => $param['certificate_id'],
                'min_score' => $param['min_score'],
                'max_score' => $param['max_score'],
            ]);
            return redirect()->back()->with('success', 'Thêm trình độ thành công.');
        }
    }
    public function levelUpdate(Request $request)
    {
        $param = $request->all();
        //dd($param);
        $level = Level::find($param['level_id']);
        if ($level) {
            // check trung lap chung chi truoc khi update
            $existingLevel = Level::where('name', $param['level_name'])
                ->where('certificate_id', $param['certificate_id'])
                ->where('id', '!=', $param['level_id']) // Exclude the current level
                ->first();
            if ($existingLevel) {
                return redirect()->back()->with('error', 'Trình độ trùng lập.');
            }
            $level->name = $param['level_name'];
            $level->certificate_id = $param['certificate_id'];
            $level->min_score = $param['min_score'];
            $level->max_score = $param['max_score'];
            $level->save();
            return redirect('/admin/settings/levels/index')->with('success', 'Cập nhật
    trình độ thành công.');
        } else {
            return redirect('/admin/settings/levels/index')->with('error', 'Trình độ không
    tồn tại.');
        }
    }
    public function levelDelete(Request $request)
    {
        $param = $request->all();
        $level = Level::find($param['level_id']);
        if ($level) {
            $level->delete();
            return redirect()->back()->with('success', 'Xóa trình độ thành công.');
        } else {
            return redirect()->back()->with('error', 'Trình độ không tồn tại.');
        }
    }


    public function shiftIndex(Request $request)
    {
        $shifts = Shift::all()->sortBy('start_time');
        return view('admin.settings.shift', compact('shifts'));
    }
    public function shiftAdd(Request $request)
    {
        $param = $request->all();
        $shift = Shift::where('start_time', $param['start_time'])
            ->where('end_time', $param['end_time'])
            ->first();
        if ($shift) {
            return redirect()->back()->with('error', 'Ca hoc da ton tai.');
        }
        Shift::create([
            // 'name' => $param['shift_name'],
            'start_time' => $param['start_time'],
            'end_time' => $param['end_time'],
        ]);
        return redirect()->back()->with('success', 'Them ca hoc thanh cong.');
    }

    public function shiftUpdate(Request $request)
    {
        $param = $request->all();
        $shift = Shift::find($param['shift_id']);
        if ($shift) {
            $shift->start_time = $param['start_time'];
            $shift->end_time = $param['end_time'];
            $shift->save();
            return redirect('/admin/settings/shifts/index')->with('success', 'Cap nhat ca hoc thanh cong.');
        } else {
            return redirect('/admin/settings/shifts/index')->with('error', 'Ca hoc khong ton tai.');
        }
    }

    public function shiftDelete(Request $request)
    {
        $param = $request->all();
        $shift = Shift::find($param['shift_id']);
        if ($shift) {
            $shift->delete();
            return redirect()->back()->with('success', 'Xoa ca hoc thanh cong.');
        } else {
            return redirect()->back()->with('error', 'Ca hoc khong ton tai.');
        }
    }


    public function informationIndex()
    {
        // Lấy danh sách setting và chuyển thành mảng [key => value]
        $settings = Setting::pluck('value', 'key')->toArray();
        $bankAccounts = BankAccount::whereNull('user_id')->get();
        return view('admin.settings.information', compact('settings', 'bankAccounts'));
    }

    public function updateInformation(Request $request)
    {
        $param = $request->except('_token');
        $fileFields = ['logo', 'favicon'];

        foreach ($param as $key => $value) {
            if (in_array($key, $fileFields) && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('uploads/settings');

                if (!file_exists($destination)) mkdir($destination, 0777, true);
                $file->move($destination, $filename);

                $old = Setting::where('key', $key)->first();
                if ($old && $old->value && file_exists(public_path($old->value))) {
                    @unlink(public_path($old->value));
                }

                Setting::updateOrCreate(['key' => $key], ['value' => 'uploads/settings/' . $filename]);
            } else {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }

    public function addBankAccount(Request $request) {
        $param = $request->all();
        if(BankAccount::where('account_number', $param['account_number'])->first()) {
            return redirect()->back()->with('error', 'Tài khoản ngân hàng đã tồn tại');
        }
        BankAccount::create([
            'bank' => $param['bank'],
            'account_number' => $param['account_number'],
        ]);
        return redirect('/admin/settings/informations/index')->with('success', 'Thêm tài khoản ngân hàng thành công');
    }

    public function updateBankAccount(Request $request) {
        $param = $request->all();
      //  dd($param);
        $bankAccount = BankAccount::find($param['bank_account_id']);
        $check = BankAccount::where('account_number', $param['account_number'])->where('id', '!=', $param['bank_account_id'])->first();
        if ($check) {
            return redirect()->back()->with('error', 'Tài khoản ngân hàng đã tồn tại');
        }
        if ($bankAccount) {
            $bankAccount->bank = $param['bank'];
            $bankAccount->account_number = $param['account_number'];
            $bankAccount->save();
            return redirect('/admin/settings/informations/index')->with('success', 'Cập nhật tài khoản ngân hàng thành công');
        } else {
            return redirect('/admin/settings/informations/index')->with('error', 'Tài khoản ngân hàng không tồn tại');
        }
    }

    public function deleteBankAccount(Request $request) {
        $param = $request->all();
        $bankAccount = BankAccount::find($param['bank_account_id']);
        if ($bankAccount) {
            $bankAccount->delete();
            return redirect()->back()->with('success', 'Xóa tài khoản ngân hàng thành công');
        } else {
            return redirect()->back()->with('error', 'Tài khoản ngân hàng không tồn tại');
        }
    }
}
