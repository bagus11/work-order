<?php

namespace App\Http\Controllers;

use App\Models\MasterCategory;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('work-order.work_order-index');
    }
    public function get_work_order_list()
    {
        if(auth()->user()->hasPermissionTo('get-all-work_order_list'))
        {
            $data = DB::table('work_orders')->select('work_orders.*', 'users.name as username')->join('users','users.id','=','work_orders.user_id')->get();
        }else{
            $data = DB::table('work_orders')->select('work_orders.*', 'users.name as username')->join('users','users.id','=','work_orders.user_id')->where('user_id', auth()->user()->id)->get();
        }
       return response()->json([
        'data'=>$data
        ]);
    }
    public function get_categories_name()
    {
        $data = MasterCategory::where('flg_aktif',1)->get();
        return response()->json([
            'data'=>$data
            ]);
    }
    public function save_wo(Request $request)
    {
        $request_type = $request->request_type;
        $categories = $request->categories;
        $problem_type = $request->problem_type;
        $subject = $request->subject;
        $add_info = $request->add_info;
        $validator = Validator::make($request->all(),[
            'request_type'=>'required',
            'categories'=>'required',
            'problem_type'=>'required',
            'subject'=>'required',
            'add_info'=>'required',
        ],[
            'request_type.required'=>'Tipe request tidak boleh kosong',
            'categories.required'=>'Kategori tidak boleh kosong',
            'problem_type.required'=>'Tipe problem tidak boleh kosong',
            'subject.required'=>'Subject tidak boleh kosong',
            'add_info.required'=>'Keterangan tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $ticket_code= WorkOrder::lates()->first();
            
            $post =[
                ''
            ];
        }

    }
}
