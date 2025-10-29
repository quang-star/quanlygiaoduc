<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentContractController extends Controller
{
    public function index()
    {
        return view('admin.contracts.contract');
    }
    public function addContract()
    {
        return view('admin.contracts.add-contract');
    }
}
