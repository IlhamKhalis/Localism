<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class Petugas extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'alamat_petugas' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'alamat_petugas' => $request->get('alamat_petugas'),
            'nohp' => $request->get('nohp'),
            'level' => $request->get('level'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function edit($id, Request $req){
        $validator = Validator::make($req->all(),[
            'nama_petugas'=>'required',
            'alamat_petugas'=>'required',
            'nohp'=>'required',
            'level'=>'required',
            'username'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return Response()->json([$validator->errors()]);
        }

        $edit=User::where('id', $id)->update([
            'nama_petugas'=>$req->nama_petugas,
            'alamat_petugas'=>$req->alamat_petugas,
            'nohp'=>$req->nohp,
            'level'=>$req->level,
            'username'=>$req->username,
            'password'=>$req->password,
        ]);

        if($edit){
            return Response()->json(['BERHASIL']);
        } else {
            return Response()->json(['GAGAL']);
        }
    }

    public function hapus($id){
        $hapus = User::where('id', $id)->delete();
        if($hapus){
            return Response()->json(['BERHASIL']);
        } else {
            return Response()->json(['GAGAL']);
        }
    }

    public function tampil(){
        $tampil = User::get();
        $count = $tampil->count();
        $petugas = array();
        foreach($tampil as $b){
            $petugas = array([
                'ID'=>$b->id,
                'Nama'=>$b->nama_petugas,
                'Alamat'=>$b->alamat_petugas,
                'No Handphone'=>$b->nohp,
                'Status'=>$b->level,
                'Username'=>$b->username,
                'Password'=>$b->password,
            ]);
        }
        return Response()->json(compact('count', 'petugas'));
    }
}
