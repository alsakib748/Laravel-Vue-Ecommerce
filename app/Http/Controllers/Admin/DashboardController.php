<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class DashboardController extends Controller
{

    use ApiResponse;

    public function index()
    {
        return view('admin/index');
    }

    public function deleteData($id = '', $table = '')
    {
        if (empty($id) || empty($table)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid parameters'
            ], 400);
        }

        DB::table($table)->where('id', $id)->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully deleted',
            'data' => ['reload' => true]
        ]);

    }

}
