<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\OrderDetail;
use App\Model\SearchFunction;
use App\Model\AdminCommissions;
use App\Model\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use function App\CPU\translate;
use Carbon\Carbon;



class SystemController extends Controller
{
    public function search_function(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ], [
            'key.required' => 'Product name is required!',
        ]);

        $key = explode(' ', $request->key);

        $items = SearchFunction::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('key', 'like', "%{$value}%");
            }
        })->get();

        return response()->json([
            'result' => view('admin-views.partials._search-result', compact('items'))->render(),
        ]);
    }

    public function maintenance_mode()
    {
        $maintenance_mode = BusinessSetting::where('type', 'maintenance_mode')->first();
        if (isset($maintenance_mode) == false) {
            DB::table('business_settings')->insert([
                'type' => 'maintenance_mode',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('business_settings')->where(['type' => 'maintenance_mode'])->update([
                'type' => 'maintenance_mode',
                'value' => $maintenance_mode->value == 1 ? 0 : 1,
                'updated_at' => now(),
            ]);
        }

        if (isset($maintenance_mode) && $maintenance_mode->value){
            return response()->json(['message'=>'Maintenance is off.']);
        }
        return response()->json(['message'=>'Maintenance is on.']);
    }
    public function order_data()
    {
        $new_order = DB::table('orders')->where(['checked' => 0])->count();
        return response()->json([
            'success' => 1,
            'data' => ['new_order' => $new_order]
        ]);
    }


    public function admin_commissions_store(Request $request) {



      $test = AdminCommissions::find(1);


      if(isset($test)) {

        AdminCommissions::find(1)->update([

            'percent'       => $request->commissions,
            'updated_at'    => Carbon::now()

        ]);

       
      } else {

        AdminCommissions::insert([

            'percent'       => $request->commissions ,
            'created_at'    => Carbon::now()

        ]);


      }

        Toastr::success(translate('admin_commissions'));
       return redirect()->back();

    }
}
