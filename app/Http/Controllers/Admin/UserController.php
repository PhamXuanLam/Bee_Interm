<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Service\AdministrativeService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected UserService $userService;
    protected AdministrativeService $administrativeService;

    public function __construct(UserService $userService, AdministrativeService $administrativeService)
    {
        $this->userService = $userService;
        $this->administrativeService = $administrativeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getUserByKeyword($request);

        return view("admin.user.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = $this->administrativeService->getProvinces();

        if ($provinces->isEmpty()) {
            return redirect()->route('admin.user.index')->with('error', 'có lỗi xảy ra');
        }
        return view("admin.user.create", ["provinces" => $provinces]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if ($this->userService->storeUser($request, new User()))
            return redirect()->route("admin.users.index")->with('success', "Xử lý dữ liệu thành công!");

        return redirect()->route("admin.users.index")->with('error', "Xử lý dữ liệu thất bại!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->findUserById($id);

        if($user->isEmpty()){
            return redirect()->route('admin.users.index')->with('error','Có lỗi xảy ra');
        }

        $provinces = $this->administrativeService->getProvincesWhereNotId($user->province_id);

        $districts = $this->administrativeService->getDistrictsWhereNotId($user->province_id, $user->distinct_id);

        $communes = $this->administrativeService->getCommunesWhereNotId($user->distinct_id, $user->commune_id);

        return view('admin.user.edit',[
            'user' => $user,
            'provinces' => $provinces,
            'districts' => $districts,
            'communes' => $communes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = $this->userService->findUserById($id);
        if ($user->isEmpty())
            return redirect()->route('admin.users.index')->with('error','Có lỗi xảy ra');

        if ($this->userService->storeUser($request, new User(), $id))
            return redirect()->route("admin.users.index")->with('success', "Xử lý dữ liệu thành công!");

        return redirect()->route("admin.users.index")->with('error', "Xử lý dữ liệu thất bại!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->findUserById($id);

        if($user->isEmpty()){
            return redirect()->route('admin.users.index')->with('error','Có lỗi xảy ra');
        }
        $response = $this->userService->deleteUser($user);

        return response()->json($response);
    }

    public function showImage($id, $avatar)
    {
        return Common::showImage(User::DIRECTORY_AVATAR, $id . '/' .$avatar, User::BASE_AVATAR);
    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);

        return redirect()->back();
    }
}
