<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller as BaseController;
use App\Services\AdminService;
use App\Exceptions\Auth\AuthorizationException;

class AdminUserController extends BaseController
{
    /**
     * Show admin user creation form
     */
    public function addAdminUserForm(
        Request $request
    ) {
        return view('admin.createAdminUserForm');
    }

    /**
     * Add new admin user
     */
    public function addAdminUser(
        Request $request,
        AdminService $adminService
    ) {
        $this->validate($request, [
            'name'      => 'required|string|max:32',
            'password'  => 'required|password',
            ]);

        $adminService->addAdminUser(
            $request->request->get('name'),
            $request->request->get('password')
        );

        return redirect()->route('admin.list');
    }

    /**
     * List all admin user, sorted by creation time desc, no pagination
     */
    public function listAll(
        Request $request,
        AdminService $adminService
    ) {
        $res = $adminService->getAllAdminUsers();

        return view('admin.adminUserList', [
            'adminUsers'    => $res->admins,
            ]);
    }

    /**
     * Delete admin user
     */
    public function delAdminUser(
        Request $request,
        AdminService $adminService,
        String $adminId
    ) {
        $request->request->set('adminId', $adminId);
        $this->validate($request, [
            'adminId'   => 'required|uuid',
            ]);

        $adminService->delAdminUser($request->request->get('adminId'));

        return back();
    }

    /**
     * Show reset password form
     */
    public function resetPasswordForm(
        Request $request,
        String $adminId
    ) {
        $request->query->set('adminId', $adminId);
        $this->validate($request, [
            'adminId'   => 'required|uuid',
            ]);

        return view('admin.adminUserPasswordResetForm', [
            'adminId'   => $request->query->get('adminId'),
            ]);
    }

    /**
     * Reset admin user password
     */
    public function resetPassword(
        Request $request,
        AdminService $adminService,
        String $adminId
    ) {
        $request->request->set('adminId', $adminId);
        $this->validate($request, [
            'adminId'   => 'required|uuid',
            'password'  => 'required|password',
            ]);

        $adminService->resetPassword(
            $request->request->get('adminId'), 
            $request->request->get('password')
        );

        return redirect()->route('admin.list');
    }
}
