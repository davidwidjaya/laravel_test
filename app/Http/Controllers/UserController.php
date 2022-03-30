<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Yajra\Datatables\Facades\Datatables;
use DataTables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create($request->except('_token'));
            $user->save();
            return redirect()->route('user.index')->with('success', 'Data has been successfully added');
        } catch (\Exception $ex) {
            return redirect()->route('user.index')->with('failed', 'Data has been failed to add');
            // return redirect()->back()->withInput($request->all())->with('failed', 'Data Failed to Insert');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id) ?? null;

        return view('edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id) ?? null;
            if(!$user){
                return redirect()->route('user.index')->with('failed', 'Data has been failed to update');
            }

            $user->update($request->except('_token'));
            return redirect()->route('user.index')->with('success', 'Data has been successfully update');
        } catch (\Exception $ex) {
            return redirect()->route('user.index')->with('failed', 'Data has been failed to update');
            // return redirect()->back()->withInput($request->all())->with('failed', 'Data Failed to Insert');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id) ?? null;
            if(!$user){
                return redirect()->route('user.index')->with('failed', 'Data has been failed to delete');
            }

            $user->delete();
            return redirect()->route('user.index')->with('success', 'Data has been successfully delete');
        } catch (\Exception $ex) {
            return redirect()->route('user.index')->with('failed', 'Data has been failed to delete');
        }
    }

    public function ajax(Request $request)
    {
        $list = User::all();
        // dd($list);

        return DataTables::collection(User::all())
            ->addColumn('created_at_obj', function ($data) use ($request) {
                return tgl($data->created_at);
            })
            ->addColumn('updated_at_obj', function ($data) use ($request) {
                return tgl($data->updated_at);
            })
            ->addColumn('action', function ($data) use ($request) {
                Log::alert(route('user.edit', ['user' => $data->id]));
                $edit = route('user.edit', ['user' => $data->id]);
                $des = route('user.destroy', ['user' => $data->id]);
                $html = "";
                $html.= "<a href='".$edit."' class='btn btn-primary'>Edit</a>";
                $html.= "<a href='#' id='btn-delete' data-id='".$data->id."' class='btn btn-danger'>Delete</a>";
                $html.= "<form method='POST' action='".$des."' id='form-delete".$data->id."'><input type='hidden' name='_method' value='DELETE' />".csrf_field()."</form>";
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
