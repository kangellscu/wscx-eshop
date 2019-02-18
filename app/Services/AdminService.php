<?php
namespace App\Services;

use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin as AdminModel;
use App\Exceptions\Admins\AdminPasswordIncorrectException;
use App\Exceptions\Admins\AdminExistsException;

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

    /**
     * Add new admin user
     *
     * @param String $name      admin username
     * @param String $password  admin password
     * 
     * @return String           new admin user unique id
     */
    public function addAdminUser(String $name, String $password) : String {
        $admin = AdminModel::where('name', $name)->first();
        if ($admin) {
            throw new AdminExistsException();
        }

        $admin = AdminModel::create([
            'name'      => $name,
            'password'  => $password,
            ]);

        return $admin->id;
    }

    /**
     * List all admin user, sorted by creation time desc
     *
     * @return Collection   elements as below:
     *                      - admins Collection
     *                          - id uuid                   admin user uuid
     *                          - name  String              admin username
     *                          - createdAt \Carbon\Carbon  admin user created time
     */
    public function getAllAdminUsers() : object {
        $admins = AdminModel::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($admin) {
                return (object) [
                    'id'        => $admin->id,
                    'name'      => $admin->name,
                    'createdAt' => $admin->created_at,
                    ];
            });

        return (object) [
            'admins'    => $admins,
            ];
    }

    /**
     * Delete admin user by id
     *
     * @param String $adminId
     */
    public function delAdminUser(String $adminId) : void {
        AdminModel::where('id', $adminId)->delete();
    }

    /**
     * Reset admin user password
     *
     * @param String $adminId
     * @param String $password
     */
    public function resetPassword(String $adminId, String $password) : void {
        AdminModel::where('id', $adminId)
            ->update(['password'    => bcrypt($password)]);
    }
}
