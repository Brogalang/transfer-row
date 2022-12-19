<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_FormTable;
use App\Models\M_ItemUnit;
use App\Models\M_Item;
use DB;

class FormTable extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $item = M_Item::get();
        return view('form.table',compact('item'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

   
    public function create()
    {
        $list= DB::select("select distinct name from m__item_unit");   
        $i=1;
        $j=1;
        return view('form.add',compact('list','i','j'));
    }

    public function storeImage(Request $request){
        $data= new M_FormTable();

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }
        $data->save();
        return redirect()->route('images.view');
       
    }

   
    public function store(Request $request)
    {
        $until=count($request->name);
        for ($i=1; $i <=$until ; $i++) { 
            M_ItemUnit::insert([
                'name' => $request->name[$i],
                'Qty' => $request->idput[$i],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        }
        // echo"<pre>";
        // print_r(count($request->idput));
        // die();
        $data= new M_FormTable();

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }
        $data->save();
        return redirect()->route('form.add');
    }

    public function edit(M_divisi $divisi)
    {
        return view('divisi.edit',compact('divisi'));
    }

    public function update(Request $request, M_divisi $divisi)
    {
        $request->validate([
            'kode_divisi' => 'required',
            'nama_divisi' => 'required',
        ]);
    
        $divisi->update($request->all());
        
        Alert::success('Congrats', 'You\'ve Successfully Updated Data');
        return redirect()->route('divisi.index')
                        ->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        M_divisi::where('id', '=', $id)->delete();
        return redirect()->route('divisi.index')
                        ->with('success','Product deleted successfully');
    }

    public function deletediv(Request $request)
    {
        M_divisi::where('id', '=', $request->idDiv)->delete();
        Alert::success('Congrats', 'Data Berhasil dihapus');
        return redirect()->route('divisi.index')
                        ->with('success','Product deleted successfully');
    }
}
