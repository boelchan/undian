<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use App\Models\Partisipan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardAnalytics()
    {
        $hadiah = Hadiah::orderBy('id', 'asc')->get();

        return view('dashboard.dashboard-analytics', compact('hadiah'));
    }

    public function undian(Request $request)
    {
        $hadiah = Hadiah::findOrFail($request->hadiah);

        abort_if(($hadiah->status == 'sudah'), 404, 'adsasdasd');

        $partisipan = Partisipan::select('id')->whereNull('hadiah')->orWhere('hadiah', '')->get();
        $jumlah_partisipan = $partisipan->count();

        $id_array = [];
        foreach ($partisipan as $p) {
            $id_array[] = $p->id;
        }

        $pemenang_id = $id_array[array_rand($id_array, 1)];


        $pemenang = Partisipan::findOrFail($pemenang_id);

        // $name = Partisipan::select('nama')->get(100);
        // $list = [];
        // foreach ($name as $n) {
        //     $list[] = $n->nama;
        // }
        // $nameJson = (string)json_encode($list);

        return view('dashboard.undian', compact('hadiah', 'pemenang'));
    }


    public function simpan(Request $request)
    {
        DB::transaction(function () use ($request) {
            Hadiah::where('id', $request->hadiah_id)->update(['status' => 'sudah']);
            Partisipan::where('id', $request->partisipan_id)->update(['hadiah' => $request->hadiah_id]);

        });
        return  redirect()->route('dashboard-analytics');
    }
}
