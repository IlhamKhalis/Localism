<?php

namespace App\Http\Controllers;

use App\Kategori;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
            $validator=Validator::make($req->all(),[
                'nama_kategori'=>'required'
            ]);

            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $simpan=Kategori::create([
                'nama_kategori'=>$req->nama_kategori
            ]);
            $status=1;
            $message="Kategori Berhasil Ditambahkan";
            if($simpan){
                return Response()->json([$simpan]);
            }else {
                return Response()->json(['status'=>0]);
            }
        }
        else {
            return Response()->json(['Anda Bukan Admin HEHE']);
        }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
            $validator=Validator::make($request->all(),[
                'nama_kategori'=>'required'
            ]);
    
            if($validator->fails()){
            return Response()->json($validator->errors());
            }
    
            $ubah=Kategori::where('id',$id)->update([
                'nama_kategori'=>$request->nama_kategori
            ]);
            $status=1;
            $message="Kategori Berhasil Diubah";
            if($ubah){
                return Response()->json(compact('status','message'));
            }else {
                return Response()->json(['status'=>0]);
            }
        }
        else {
            return Response()->json(['Anda Bukan Admin HEHE']);
        }
}
    public function destroy($id){
        if(Auth::user()->level=='admin'){
            $hapus=Kategori::where('id',$id)->delete();
            $status=1;
            $message="Kategori Berhasil Dihapus";
            if($hapus){
                return Response()->json(compact('status','message'));
            }else {
                return Response()->json(['status'=>0]);
            }   
        }
    }
  
    public function tampil(){
        $data = Kategori::get();
        $count = $data->count();
        $kategori = array();
        $status = 1;
        foreach ($data as $k){
            $kategori[] = array(
                'id' => $k->id,
                'nama_kategori' => $k->nama_kategori
            );
        }
        return Response()->json(compact('count','kategori'));
    }
}
