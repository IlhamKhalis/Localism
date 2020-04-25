<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\artikelModel;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
class Artikel extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
            $validator=Validator::make($req->all(),
            [
                'judul'=>'required',
                'id_petugas'=>'required',
                'id_kategori'=>'required',
                'artikel'=>'required',
                'id_brand'=>'required',
                'tanggal'=>'required',
            ]
            );
            if($validator->fails()){
                return Response()->json($validator->errors());
            }

            $simpan=artikelModel::create([
                'judul'=>$req->judul,
                'id_petugas'=>$req->id_petugas,
                'id_kategori'=>$req->id_kategori,
                'artikel'=>$req->artikel,
                'id_brand'=>$req->id_brand,
                'tanggal'=>$req->tanggal,
            ]);
            $status=1;
            $message="Artikel Berhasil Ditambahkan";
            if($simpan){
            return Response()->json(compact('status','message'));
            }else {
            return Response()->json(['status'=>0]);
            }
        }
      else if(Auth::user()->level=="penulis"){
        $validator=Validator::make($req->all(),
        [
            'judul'=>'required',
            'id_petugas'=>'required',
            'id_kategori'=>'required',
            'artikel'=>'required',
            'id_brand'=>'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=artikelModel::create([
            'judul'=>$req->judul,
            'id_petugas'=>$req->id_petugas,
            'id_kategori'=>$req->id_kategori,
            'artikel'=>$req->artikel,
            'id_brand'=>$req->id_brand,
            'tanggal'=>date("Y-m-d H-i-s"),
        ]);
        $status=1;
        $message="Artikel Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      } 
  }

    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'judul'=>'required',
                'id_petugas'=>'required',
                'id_kategori'=>'required',
                'artikel'=>'required',
                'id_brand'=>'required',
                'tanggal'=>'required',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=artikelModel::where('id',$id)->update([
            'judul'=>$request->judul,
            'id_petugas'=>$request->id_petugas,
            'id_kategori'=>$request->id_kategori,
            'artikel'=>$request->artikel,
            'id_brand'=>$request->id_brand,
            'tanggal'=>$request->tanggal
        ]);
        $status=1;
        $message="Artikel Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
        else if(Auth::user()->level=="penulis"){
            $validator=Validator::make($request->all(),
                [
                    'judul'=>'required',
                    'id_petugas'=>'required',
                    'id_kategori'=>'required',
                    'artikel'=>'required',
                    'id_brand'=>'required',
                ]
            );

            if($validator->fails()){
            return Response()->json($validator->errors());
            }
    
            $ubah=artikelModel::where('id',$id)->update([
                'judul'=>$request->judul,
                'id_petugas'=>$request->id_petugas,
                'id_kategori'=>$request->id_kategori,
                'artikel'=>$request->artikel,
                'id_brand'=>$request->id_brand,
            ]);
            $status=1;
            $message="Artikel Berhasil Diubah";
            if($ubah){
            return Response()->json(compact('status','message'));
            }else {
            return Response()->json(['status'=>0]);
            }
            }
    else {
    return response()->json(['status'=>'anda bukan admin atau penulis']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="admin"){
            $hapus=artikelModel::where('id',$id)->delete();
            $status=1;
            $message="Artikel Berhasil Dihapus";
            if($hapus){
            return Response()->json(compact('status','message'));
            }else {
            return Response()->json(['status'=>0]);
            }
        } 
        else if(Auth::user()->level=="penulis"){
            $hapus=artikelModel::where('id',$id)->delete();
            $status=1;
            $message="artikel Berhasil Dihapus";
            if($hapus){
            return Response()->json(compact('status','message'));
            }else {
            return Response()->json(['status'=>0]);
            }
        }
    else {
        return response()->json(['status'=>'anda bukan admin atau penulis']);
        }
    }

    public function tampil_brand(Request $req){
            $datas = DB::table('artikel')->join('kategori','kategori.id','=','artikel.id_kategori')
            ->join('brand','brand.id','=','artikel.id_brand')
            ->join('petugas','petugas.id','=','artikel.id_petugas')
            ->where('brand.nama_brand','=',$req->nama_brand)
            ->select('artikel.id','judul','nama_petugas','nama_kategori','artikel','nama_brand')
            ->get();
            $count = $datas->count();
            $artikel = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $artikel[] = array(
                    'id' => $dt_pl->id,
                    'Judul' => $dt_pl->judul,
                    'Nama Petugas' => $dt_pl->nama_petugas,
                    'Kategori' => $dt_pl->nama_kategori,
                    'Artikel' => $dt_pl->artikel,
                    'Nama Brand' => $dt_pl->nama_brand
                );
            }
            return Response()->json(compact('count','artikel'));
    }
    
    public function tampil_kategori(Request $req){
            $datas = DB::table('artikel')->join('kategori','kategori.id','=','artikel.id_kategori')
            ->join('brand','brand.id','=','artikel.id_brand')
            ->join('petugas','petugas.id','=','artikel.id_petugas')
            ->where('kategori.nama_kategori','=',$req->nama_kategori)
            ->select('artikel.id','judul','nama_petugas','nama_kategori','artikel','nama_brand')
            ->get();
            $count = $datas->count();
            $artikel = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $artikel[] = array(
                    'id' => $dt_pl->id,
                    'Judul' => $dt_pl->judul,
                    'Nama Petugas' => $dt_pl->nama_petugas,
                    'Kategori' => $dt_pl->nama_kategori,
                    'Artikel' => $dt_pl->artikel,
                    'Nama Brand' => $dt_pl->nama_brand
                );
            }
            return Response()->json(compact('count','artikel'));
    }
}
