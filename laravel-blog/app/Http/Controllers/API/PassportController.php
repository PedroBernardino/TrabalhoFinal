<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use DB;

class PassportController extends Controller
{
    public $successStatus = 200;
    public function login () {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]) || Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user-> createToken('MyApp')->accessToken;
            return response()->json(['success' => $success],$this->successStatus);
        }
        else {
            return response() -> json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register (Request $request) {
        $validator = Validator::make($request -> all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator -> fails()) {
            return response() ->json(['error' => $validator->errors()], 401);
        }
        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->username = $request->username;
        $newUser->save();
        $success['token'] = $newUser->createToken('MyApp')->accessToken;
        $success['name'] = $newUser-> name;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function getDetails() {
       $user = Auth::user();
       return response()->json(['success' => $user], $this->successStatus); 
    }
    public function logout() {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update([
            'revoked' => true
        ]);
        $accessToken->revoke();
        return response()->json('Usuário deslogado');
    }
}
