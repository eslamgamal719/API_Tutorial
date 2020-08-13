<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{

use GeneralTrait;

    
      public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required",
                "password" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

             $credentials = $request -> only(['email','password']) ;
             $token = Auth::guard('admin-api') -> attempt($credentials);   // Make Login by email and Pass and return token

           if(!$token)
               return $this->returnError('E001', 'Entry Data Is Not Found');  


        //return token
           $admin = Auth::guard('admin-api')->user();    //(user()) Get All admin Data From Table Admins 
           $admin->api_token = $token;
           return $this->returnData('admin', $admin);
  

         } catch(\Exception $e) {            //Both Are Exception method
             return $this->returnError($e->getCode(), $e->getMessage());
        }

    }	

}
