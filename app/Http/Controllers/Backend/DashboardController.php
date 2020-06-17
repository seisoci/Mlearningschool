<?php

namespace App\Http\Controllers\Backend;

use App\Mlearningkelas;
use App\Mlearningmateri;
use App\User;

class DashboardController extends Controller{
    public function index(){
        $breadcrumbs = [
          ['name'=>"Page"]
        ];
        $config = array(
          "title"        => "Backend Page",
          "title_table"  => "Create Page",
        );
        $data = array(
            'count_guru'    => User::where('role', '=', 'guru')->count(),
            'count_siswa'   => User::where('role', '=', 'siswa')->count(),
            'count_materi'  => Mlearningmateri::all()->count(),
            'count_kelas'  => Mlearningkelas::all()->count(),
        );
        return view('backend.dashboard.index', compact('breadcrumbs', 'config', 'data'));
    }
}
