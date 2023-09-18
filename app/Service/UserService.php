<?php

namespace App\Service;

use App\Helpers\Common;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function deleteUser(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            $response = [
                'success' => true,
                'message' => 'Xóa dữ liệu thành công'
            ];
            DB::commit();
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Xóa dữ liệu thất bại'
            ];
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
        }
        return $response;
    }
    public function getUserByKeyword(Request $request)
    {
        $users = User::query()
            ->select(['id', 'avatar', 'user_name', 'email', 'address', 'birthday', 'first_name', 'last_name', 'status']);

        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $users = $users
                ->where("user_name", "LIKE", "%{$keyword}%")
                ->orWhere("first_name", "LIKE", "%{$keyword}%")
                ->orWhere("last_name", "LIKE", "%{$keyword}%")
                ->orWhere("email", "LIKE", "%{$keyword}%");
        }

        return $users->paginate(User::NUMBER_OF_PAGE);
    }

    public function findUserById(string $id)
    {
        return User::query()
            ->select(['*'])
            ->find($id);
    }

    public function storeUser(Request $request, User $user, $id = null)
    {
        DB::beginTransaction();
        try {
            $user->email = $request->email;
            $user->birthday = $request->birthday;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->user_name = $request->user_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->province_id = $request->provine;
            $user->district_id = $request->district;
            $user->commune_id = $request->commune;
            $user->address = AdministrativeService::getAddress($request->province, $request->district, $request->commune);
            $user->save();
            if ($request->hasFile("avatar") && $id == null) {
                $user->avatar = Common::uploadImage($user->id, User::DIRECTORY_AVATAR, $request->file("avatar"));
            } elseif ($request->hasFile("avatar") && $id != null) {
                $user->avatar = Common::uploadImage($user->id, User::DIRECTORY_AVATAR, $request->file("avatar"), $user->avatar);
            } elseif (!$request->hasFile("avatar")) {
                $user->avatar = time() . '.png';
            }
            $user->save();
            $emailJob = new SendEmail($user);
            dispatch($emailJob);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return false;
        }
    }

    public function getUsers()
    {
        return User::query()->select(['*'])->get();
    }
}
