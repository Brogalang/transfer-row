<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_FormTable;
use App\Models\M_ItemUnit;
use App\Models\M_Item;
use App\Models\M_kategori;
use DB;

class FormTable extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $item = M_Item::get();
        $item = DB::table('m_item')
                    ->select('m_item.id as id','postimages.image','kategori.name_kategori','m_item.Code','m_item.Name','m_item.Brand','m_item.xPicture')
                    ->leftjoin('postimages', 'postimages.id_header', '=', 'm_item.id')
                    ->leftjoin('kategori', 'kategori.id', '=', 'm_item.id_category')
                    ->where('m_item.id_unit','=',NULL)
                    ->get();
        $itemUnit = M_ItemUnit::get();
        foreach ($itemUnit as $key => $value) {
            $detail[$value->id_Project]=$value->id_Project;
            $detailCode[$value->id_Project][$value->Code]=$value->Code;
            $detailName[$value->id_Project][$value->name]=$value->name;
            $detailQty[$value->id_Project][$value->Qty]=$value->Qty;
        }
        // echo"<pre>";
        // print_r($detailQty);
        // die();
        return view('form.table',compact('item','detail','detailCode','detailName','detailQty','itemUnit'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

   
    public function create()
    {
        $list= DB::select("select distinct name from m__item_unit");   
        $i=1;
        $j=1;
        $kategori = M_kategori::get();
        return view('form.add',compact('list','i','j','kategori'));
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
        // echo"<pre>";
        // print_r($request->name);
        // die();
        ## Insert Header
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            // $data['image']= $filename;
            // $data['id_header']= $head_id;
        }else{
            $filename="";
        }
        $head_id=M_Item::insertGetId([
            'Code' => $request->code,
            'id_branch' => '1',
            'Name' => $request->nameinpt,
            'id_category' => $request->kategori,
            'brand' => $request->brand,
            'xPicture' => $filename,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);
        if ($request->name) {
            $until=count($request->name);
            for ($i=0; $i <$until ; $i++) { 
                M_ItemUnit::insert([
                    'Code' => $request->code,
                    'name' => $request->name[$i],
                    'id_Project' => $head_id,
                    'Qty' => $request->idput[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ]);
            }
        }
        return redirect()->route('formtable.index');
    }

    public function edit($id)
    {
        $list= DB::select("select distinct name from m__item_unit");  
        $kategori = M_kategori::get();
        $image = M_FormTable::where('id_header','=',$id)->first();
        $item = M_Item::where('id','=',$id)->first();
        $itemUnit= M_ItemUnit::where('id_Project','=',$id)->get();
        $i=1;
        $j=1;
        return view('form.edit',compact('item','kategori','itemUnit','image','i','list','j'));
    }

    public function update(Request $request, $id)
    {
        // echo"<pre>";
        // print_r($request->name);
        // die();
        DB::statement("UPDATE m_item SET  Code = '".$request->code."',Name = '".$request->nameinpt."',id_category='".$request->kategori."',Brand='".$request->brand."' WHERE id = '".$id."' ");
        if($request->file('image')){
            $img=M_FormTable::where('id_header','=',$id)->first();
            if ($img) {
                $file_path="public/Image/".$img->image;
                unlink($file_path);
            }
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            DB::statement("UPDATE postimages SET  image = '".$filename."' WHERE id_header = '".$id."' ");
        }
        // if ($request->nameEdit) {
        //     $untilEdit=count($request->nameEdit);
        //     for ($i=0; $i <$untilEdit ; $i++) { 
        //         M_ItemUnit::insert([
        //             'Code' => $request->code,
        //             'name' => $request->nameEdit[$i],
        //             'id_Project' => $id,
        //             'Qty' => $request->idputEdit[$i],
        //             'created_at' => date('Y-m-d h:i:s'),
        //             'updated_at' => date('Y-m-d h:i:s')
        //         ]);
        //     }
        // }
        if ($request->name) {
            M_ItemUnit::where('id_Project', '=', $id)->delete();
            $until=count($request->name);
            for ($i=0; $i <$until ; $i++) { 
                M_ItemUnit::insert([
                    'Code' => $request->code,
                    'name' => $request->name[$i],
                    'id_Project' => $id,
                    'Qty' => $request->idput[$i],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ]);
                // DB::statement("UPDATE m__item_unit SET  Code = '".$request->code."',Qty='".$request->idput[$i]."' WHERE id_Project = '".$id."' AND name = '".$request->name[$i]."' ");
            }
        }
        return redirect()->route('formtable.index')
                        ->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        $img=M_FormTable::where('id_header','=',$id)->first();
        // echo"<pre>";
        // print_r($file_path);
        // die();
        M_Item::where('id', '=', $id)->delete();
        M_ItemUnit::where('id_Project', '=', $id)->delete();
        M_FormTable::where('id_header', '=', $id)->delete();
        if ($img) {
            $file_path="public/Image/".$img->image;
            unlink($file_path);
        }
        return redirect()->route('formtable.index')
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
