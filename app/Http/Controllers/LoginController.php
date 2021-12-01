<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\MemberToken;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

    public function login(){
        $email = request()->post('email');
        $password = request()->post('password');

        $member = Registrasi::where('email', $email)->first();
        if(empty($member)){
            return $this->responseHasil(404, false, 'Email tidak ditemukan');
        }

        if( ! Hash::check($password, $member->password)){
            return $this->responseHasil(404, false, 'Password tidak benar');
        }

        $data = [
            'auth_key' => Hash::make(md5(date('Y-m-d H:i:s').rand(9, 99999).$member->id)),
            'member_id' => $member->id
        ];
        try{
            MemberToken::create($data);
            return $this->responseHasil(200, true,[
                'token' => $data['auth_key'],
                'user' => $member
            ]);
        }catch(Exception $e){
            return $this->responseHasil(500, false, $e->getMessage());
        }

        
    }
}