<?php

namespace App\Http\Controllers;

use App\Models\Partisipan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class PartisipanController extends Controller
{

    public function index()
    {
        return view('partisipan.index');
    }

    /**
     * get data list with yajra datatable
     *
     * @return json
     */
    public function dataList(Request $request)
    {
        $partisipan = Partisipan::select(['id', 'nik','nama','alamat','hadiah']);

        return Datatables::of($partisipan)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
				if ($request->post('nik') != '') $query->whereRaw('LOWER(nik) like  ?', ["%{$request->post('nik')}%"]);
				if ($request->post('nama') != '') $query->whereRaw('LOWER(nama) like  ?', ["%{$request->post('nama')}%"]);
				if ($request->post('alamat') != '') $query->whereRaw('LOWER(alamat) like  ?', ["%{$request->post('alamat')}%"]);
				if ($request->post('hadiah') != '') $query->whereRaw('LOWER(hadiah) like  ?', ["%{$request->post('hadiah')}%"]);
			})
            ->addColumn('action', function ($partisipan) {
                $btn = '<a href="' . route('partisipan.edit', $partisipan->id) . '" class="text-success" title="edit">
                                <i data-feather="edit-2"></i>
                            </a> ';
                $btn .= ' <a href="javascript:void(0)" data-url="' . route('partisipan.destroy', $partisipan->id) . '" data-token="' . csrf_token() . '" class="text-danger table-delete">
                            <i data-feather="trash"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function create()
    {
        return view('partisipan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
            ]
        );

        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        Partisipan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'redirect' => route('partisipan.index')
        ]);
    }

    public function show(Partisipan $partisipan)
    {
        return view('partisipan.show', compact('partisipan'));
    }

    public function edit(Partisipan $partisipan)
    {
        return view('partisipan.edit', compact('partisipan'));
    }

    public function update(Request $request, Partisipan $partisipan)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
            ]
        );

        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        $partisipan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'redirect' => route('partisipan.index')
        ]);
    }

    public function destroy(Partisipan $partisipan)
    {
        $partisipan->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
