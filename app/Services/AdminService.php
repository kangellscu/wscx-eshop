<?php
namespace App\Services;

use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin as AdminModel;
use App\Exceptions\Admins\AdminPasswordIncorrectException;

class AdminService
{
    /**
     * Change admin's password
     */
    public function changePassword(
        string $adminId, string $currPassword, string $password
    ) {
        $admin = AdminModel::find($adminId);

        if ( ! Hash::check($currPassword, $admin->password)) {
            throw new AdminPasswordIncorrectException('当前密码不正确');
        }

        $admin->password = Hash::make($password);
        $admin->save();
        Auth::guard('admin')->logout();
    }
}
