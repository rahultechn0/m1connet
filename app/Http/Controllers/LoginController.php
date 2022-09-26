<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Sneaker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'required',
            'secret_key' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors(), ], 400);
        }

        $auth = User::where('wallet_address', $request->wallet_address)->first();
        if (!$auth) {
            $auth = new User();
            $auth->wallet_address = $request->wallet_address;
            $auth->secret_key = $request->secret_key;
            $auth->save();

            // return response([
            //     'message' => 'The provided credentials are incorrect.'
            // ], 401);

            // return Redirect::to('http://139.162.13.117:8000/app_login');
        }

        $token = $auth->createToken('myToken')->accessToken;
        return response(['auth' => $auth,'token' => $token,],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'age' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors(), ], 400);
        }

        $id = auth('api')->user()->id;
        $found = User::find($id);
        $found->username = $request->username;
        $found->age = $request->age;
        $found->gender = $request->gender;

        $image =$request->file('image');
        if($request->hasFile('image')){
            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $request->image->storeAs('image', $new_name, 'public');
            $found['image'] = $new_name;
        }else{
            return response()->json('image null');
        }

        $found->save();
        return Response::json(['success' => true, 'message' => 'updated successfully!',
                            'updated_data' => $found], 200);

    }

    public function show()
    {
        $id = auth('api')->user()->id;
        $show = User::select('wallet_address','secret_key','username','age','gender', 'image')->where('id',$id)->first();
        return response()->json(['data' => $show,'status' => true,'message' => 'successful']);
    }

    public function sneaker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'trans_id' => 'required|unique:sneakers|max:255',
            'name' => 'required',
            'level' => 'required',
            'color' => 'required',
            'rarity' => 'required',
            'time_type' => 'required',
            'charisma' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors(), ], 400);
        }

        $sneaker = new Sneaker();
        $sneaker->user_id = $request->user_id;
        $sneaker->trans_id = $request->trans_id;
        $sneaker->name = $request->name;
        $sneaker->level = $request->level;
        $sneaker->color = $request->color;
        $sneaker->rarity = $request->rarity;
        $sneaker->time_type = $request->time_type;
        $sneaker->charisma = $request->charisma;
        $sneaker->save();
        return response()->json(['status'=>true, 'message'=> 'sneaker added successfully'],200);
    }

    public function showSneaker()
    {
        $id = auth('api')->user()->id;
        $sneaker = Sneaker::select('user_id','trans_id','name','level','color', 'rarity','time_type','charisma')->where('user_id',$id)->get();
        return response()->json(['data' => $sneaker,'status' => true,'message' => 'Sneaker show successfully'],200);
    }

    public function createReward(Request $request)
    {
        $id = auth('api')->user()->id;
        $reward = new Reward();
        $reward->user_id = $id;
        $reward->sneaker_id = $request->sneaker_id;
        $reward->distance = $request->distance;
        $reward->reward = $request->distance * 20;
        $reward->save();
        return response()->json(['data' => $reward,'status' => true,'message' => 'Reward created successfully'],200);
    }

    public function userTotalReward()
    {
        $id = auth('api')->user()->id;
        $totalReward = Reward::select('user_id','sneaker_id','distance','reward')->where('user_id',$id)->sum('reward');
        return response()->json(['data' => $totalReward,'status' => true,'message' => 'Total Reward show successfully'],200);
    }

    public function userTotalDistance()
    {
        $id = auth('api')->user()->id;
        $totalDistance = Reward::select('user_id','sneaker_id','distance','reward')->where('user_id',$id)->sum('distance');
        return response()->json(['data' => $totalDistance,'status' => true,'message' => 'Total Distance show successfully'],200);
    }

    public function showAllSneaker(Request $request)
    {
        $showSneaker = Reward::select('user_id','sneaker_id','distance','reward')->where('sneaker_id', $request->sneaker_id)->get();
        return response()->json(['data' => $showSneaker,'status' => true,'message' => 'Reward show successfully'],200);
    }

    public function snIdTotalReward(Request $request)
    {
        $SneakerTotalReward = Reward::select('user_id','sneaker_id','distance','reward')->where('sneaker_id', $request->sneaker_id)->sum('reward');
        return response()->json(['data' => $SneakerTotalReward,'status' => true,'message' => 'Total Reward show successfully'],200);
    }

    public function snIdTotalDist(Request $request)
    {
        $SneakerTotalReward = Reward::select('user_id','sneaker_id','distance','reward')->where('sneaker_id', $request->sneaker_id)->sum('distance');
        return response()->json(['data' => $SneakerTotalReward,'status' => true,'message' => 'Total Distance show successfully'],200);
    }
}
