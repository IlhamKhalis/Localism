<?php

namespace App\Http\Controllers;

use App\Brand;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=='admin'){
            $validator=Validator::make($req->all(),[
                'nama_brand'=>'required'
            ]);
    
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
    
            $simpan=Brand::create([
                'nama_brand'=>$req->nama_brand
            ]);
    
            if($simpan){
                return Response()->json([$simpan]);
            }else {
                return Response()->json(['status'=>0]);
            }
        }
    }
    public function update($id,Request $request){
        if(Auth::user()->level=='admin'){
            $validator=Validator::make($request->all(),[
                'nama_brand'=>'required'
            ]);
    
            if($validator->fails()){
            return Response()->json($validator->errors());
            }
    
            $ubah=Brand::where('id',$id)->update([
                'nama_brand'=>$request->nama_brand
            ]);
            $status=1;
            $message="Brand Berhasil Diubah";
            if($ubah){
                return Response()->json(compact('status','message'));
            }else {
                return Response()->json(['status'=>0]);
            }
        }
    }
    public function destroy($id){
        if(Auth::user()->level=='admin'){
            $hapus=Brand::where('id',$id)->delete();
            $status=1;
            $message="Brand Berhasil Dihapus";
            if($hapus){
                return Response()->json(compact('status','message'));
            }else {
                return Response()->json(['status'=>0]);
            }
        }
    }
  
    public function tampil(){
        $data = Brand::get();
        $count = $data->count();
        $brand = array();
        $status = 1;
        foreach ($data as $b){
            $brand[] = array(
                'id' => $b->id,
                'nama_brand' => $b->nama_brand
            );
        }
        return Response()->json(compact('count','brand'));
    }
}
