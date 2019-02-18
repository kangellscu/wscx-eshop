<?php

namespace App\Http\Controllers\Admins;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller as BaseController;
use App\Services\AdminService;


class AuthController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Show password changing form
     */
    public function showPasswordChangingForm()
    {
        return view('admin.passwordChanging');
    }

    /**
     * Change admin himself password
     */
    public function passwordChanging(
        Request $request,
        AdminService $adminService        
    ) {
        $this->validate($request, [
            'currPassword'  => 'required|password',
            'password'      => 'required|password|confirmed',
        ]);

        $adminService->changePassword(
            Auth::id(),
            $request->request->get('currPassword'),
            $request->request->get('password')
        );

        return redirect()->route('admin.dashboard');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username()   => 'required|string|max:32',
            'password'          => 'required|password',
        ]);
    }

    public function username() : string
    {
        return 'name';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function redirectTo() : string
    {
        return 'admin/clients';
    }
}
