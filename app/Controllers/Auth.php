<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Controllers\AuthController;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class Auth extends AuthController
{
    protected $auth;
    protected $config;
    protected $userModel;
    protected $groupModel;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();

        $this->auth = service('authentication');
    }
    public function login()
    {
        // Custom logic login
        return parent::login();
    }

    public function attemptLogin()
    {
        // Custom validation atau logic tambahan
        $response = parent::attemptLogin();
        // Jika parent sudah melakukan redirect, langsung return
        return $this->redirectBasedOnRole($response);
    }

    private function redirectBasedOnRole(RedirectResponse $response)
    {
        $userId = user_id();
        // $this->groupModel->removeUserFromGroup(+$userId, 2);

        if ($userId == null) {
            return $response;
        }

        $userGroups = $this->groupModel->getGroupsForUser($userId);

        foreach ($userGroups as $group) {
            if ($group['name'] === 'admin') {
                return redirect()->to('admin/dashboard');
            } else if ($group['name'] === 'lecturer') {
                return redirect()->to('lecturer/dashboard');
            } else if ($group['name'] === 'student') {
                return redirect()->to('student/dashboard');
            }
        }

        return redirect()->to('/');
    }


    public function register()
    {
        return parent::register();
    }


    public function attemptRegister()
    {
        $response = parent::attemptRegister();

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user == null) {
            return $response;
        }

        if ($user) {
            // Tambahkan ke group role sesuai yang dipilih
            $userRoleGroup = $this->groupModel->where('name', 'student')->first();
            if ($userRoleGroup) {
                $this->groupModel->addUserToGroup($user->id, $userRoleGroup->id);
            }
        }
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }

    public function addUserToGroupForm()
    {
        return view('Auth/addUserToGroup');
    }

    public function addUserToGroup()
    {
        $data = $this->request->getPost();
        $userId = $data['userId'];
        $role = $data['role'];
        $this->groupModel->addUserToGroup(+$userId, +$role);
        echo "User berhasil ditambahkan ke grup $role.";
    }

    public function attemptReset()
    {
        // Custom validation atau logic tambahan
        $response = parent::attemptReset();
        // Jika parent sudah melakukan redirect, langsung return
        return $response;
    }
}
