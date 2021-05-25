<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $users = User::create($request->all());
            DB::commit();
            // return a vaild http response
            return response()->json($users, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving user failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request): Request
    {
        $datetime = new \DateTime($request->published);
        $request['published'] = $datetime;
        return $request;
    }

    public function findById(int $id) {
        $user = User::where('id',$id)->
        with(['vaccination'])->first();
        return $user;
    }

    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::get()
                ->where('id', $id)->first();
            if ($user != null) {
                $request = $this->parseRequest($request);
                $user->update($request->all());
            }
            DB::commit();
            $loc = User::get()
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($loc, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }
    }

    public function delete(string $id): JsonResponse
    {
        $user = User::where('id', $id)->first();
        if ($user != null) {
            $user->delete();
        } else
            throw new \Exception("user couldn't be deleted - it does not exist");
        return response()->json('user (' . $id . ') successfully deleted', 200);
    }
}
