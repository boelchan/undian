<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use App\Models\Partisipan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class HadiahController extends Controller
{

    public function index()
    {
        return view('hadiah.index');
    }

    /**
     * get data list with yajra datatable
     *
     * @return json
     */
    public function dataList(Request $request)
    {
        $hadiah = Hadiah::select(['id', 'hadiah', 'status', 'icon'])->orderBy('id', 'asc');

        return Datatables::of($hadiah)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->post('hadiah') != '') $query->whereRaw('LOWER(hadiah) like  ?', ["%{$request->post('hadiah')}%"]);
            })
            ->addColumn('action', function ($hadiah) {
                $btn = '<a href="' . route('hadiah.edit', $hadiah->id) . '" class="text-success" title="edit">
                                <i data-feather="edit-2"></i>
                            </a> ';
                $btn .= ' <a href="javascript:void(0)" data-url="' . route('hadiah.destroy', $hadiah->id) . '" data-token="' . csrf_token() . '" class="text-danger table-delete">
                            <i data-feather="trash"></i>
                        </a>';
                $btn .= ' <a href="javascript:void(0)" data-url="' . route('hadiah.reload', $hadiah->id) . '" data-token="' . csrf_token() . '" class="text-info table-reload">
                            <i data-feather="rotate-cw"></i>
                        </a>';
                return $btn;
            })
            ->editColumn('hadiah', function ($hadiah) {
                return '<img src="' . asset("storage/icon/" . $hadiah->icon) . '" alt="" width="50px"> ' . $hadiah->hadiah;
            })
            ->rawColumns(['hadiah', 'action'])
            ->make();
    }

    public function create()
    {
        return view('hadiah.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            []
        );

        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        $hadiah = Hadiah::create($request->all());

        if ($request->file('icon')) {
            $file_icon = $request->file('icon');
            $fileName = 'icon-' . Str::slug($hadiah->hadiah) . '.' . $file_icon->extension();
            $file_icon->move('storage/icon/', $fileName);

            $hadiah->icon = $fileName;
            $hadiah->save();
        }


        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'redirect' => route('hadiah.index')
        ]);
    }

    public function show(Hadiah $hadiah)
    {
        return view('hadiah.show', compact('hadiah'));
    }

    public function edit(Hadiah $hadiah)
    {
        return view('hadiah.edit', compact('hadiah'));
    }

    public function update(Request $request, Hadiah $hadiah)
    {
        $validator = Validator::make(
            $request->all(),
            []
        );

        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        $hadiah->update($request->all());

        if ($request->file('icon')) {
            $file_icon = $request->file('icon');
            $fileName = 'icon-' . Str::slug($hadiah->hadiah) . '.' . $file_icon->extension();
            $file_icon->move('storage/icon/', $fileName);

            $hadiah->icon = $fileName;
            $hadiah->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'redirect' => route('hadiah.index')
        ]);
    }

    public function destroy(Hadiah $hadiah)
    {
        $hadiah->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function reload(Hadiah $hadiah)
    {
        DB::transaction(function () use ($hadiah) {
            $partisipan = Partisipan::firstWhere('hadiah', $hadiah->id);
            if ($partisipan) {
                $partisipan->hadiah = null;
                $partisipan->save();
            }

            $hadiah->status = 'belum';
            $hadiah->save();
        });


        return response()->json([
            'success' => true
        ]);
    }
}
