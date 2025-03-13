<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class UserController extends BaseController
{
    protected $helpers = ['auth'];
    protected $userModel;
    protected $groupModel;
    protected $db;
    protected $config;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect();
        $this->config = config('Auth');

        // Pastikan hanya admin yang dapat mengakses

        helper(['auth']);
        if (!in_groups('admin')) {
            return redirect()->to('/');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru',
            'groups' => $this->groupModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('users/create', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->find($id),
            'groups' => $this->groupModel->findAll(),
            'userGroups' => $this->groupModel->getGroupsForUser($id),
            'validation' => \Config\Services::validation()
        ];

        if (empty($data['user'])) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        return view('users/edit', $data);
    }
    public function store()
    {
        $user = new \Myth\Auth\Entities\User();
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        $this->userModel->save($user);

        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->request->getVar('group');
        $this->groupModel->addUserToGroup($userId, $groupId);

        return redirect()->to('admin/users')->with('message', 'User berhasil ditambahkan');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        // Periksa username unik jika diubah
        $newUsername = $this->request->getVar('username');
        if ($user->username != $newUsername) {
            $existingUser = $this->userModel->where('username', $newUsername)->first();
            if ($existingUser) {
                return redirect()->back()->withInput()->with('error', 'Username sudah digunakan');
            }
        }

        // Periksa email unik jika diubah
        $newEmail = $this->request->getVar('email');
        if ($user->email != $newEmail) {
            $existingEmail = $this->userModel->where('email', $newEmail)->first();
            if ($existingEmail) {
                return redirect()->back()->withInput()->with('error', 'Email sudah digunakan');
            }
        }

        // Periksa password jika diisi
        $password = $this->request->getVar('password');
        $passConfirm = $this->request->getVar('pass_confirm');
        if (!empty($password)) {
            if ($password != $passConfirm) {
                return redirect()->back()->withInput()->with('error', 'Password dan konfirmasi tidak sama');
            }
        }

        // Update data user
        $data = [
            'id' => $id,
            'username' => $newUsername,
            'email' => $newEmail,
            'active' => $this->request->getVar('status') ? 1 : 0,
        ];

        // Update password jika diisi
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $userObject = new User($data);

        // Simpan perubahan
        $this->userModel->save($data);
        return redirect()->to('admin/users')->with('message', 'User berhasil diupdate');
    }


    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        $this->userModel->delete($id);

        return redirect()->to('admin/users')->with('message', 'User berhasil dihapus');
    }
}
