<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }
        return view('auth/login', ['title' => 'Sign In']);
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();
        $email = trim((string) $this->request->getVar('email'));
        $password = (string) $this->request->getVar('password');

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id'    => $user['user_id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to(base_url())->with('msg', 'Welcome back, ' . explode(' ', $user['name'])[0] . '!');
        }

        $session->setFlashdata('error', 'Invalid email address or password.');
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }
        return view('auth/register', ['title' => 'Create Account']);
    }

    public function attemptRegister()
    {
        $model = new UserModel();
        $rules = [
            'name'            => 'required|min_length[3]|max_length[255]',
            'email'           => 'required|valid_email|is_unique[users.email]',
            'password'        => 'required|min_length[8]',
            'confirmpassword' => 'matches[password]',
        ];

        if ($this->validate($rules)) {
            $model->save([
                'name'     => trim((string) $this->request->getVar('name')),
                'email'    => trim((string) $this->request->getVar('email')),
                'password' => password_hash((string) $this->request->getVar('password'), PASSWORD_DEFAULT),
                'role'     => 'customer'
            ]);
            return redirect()->to(base_url('login'))->with('msg', 'Account created! You can now sign in and start ordering.');
        }

        return view('auth/register', [
            'title'      => 'Create Account',
            'validation' => $this->validator
        ]);
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $orderModel = new OrderModel();
        $userModel = new UserModel();

        $data = [
            'title'  => 'My Profile',
            'user'   => $userModel->find(session()->get('user_id')),
            'orders' => $orderModel->where('user_id', session()->get('user_id'))->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('profile', $data);
    }

    public function updateProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $name = trim((string) $this->request->getPost('name'));
        $phone = trim((string) $this->request->getPost('phone'));
        $address = trim((string) $this->request->getPost('address'));

        if (strlen($name) < 3) {
            return redirect()->back()->with('error', 'Name must be at least 3 characters.');
        }

        $userModel = new UserModel();
        $userModel->update($userId, [
            'name'    => $name,
            'phone'   => $phone,
            'address' => $address
        ]);

        session()->set('name', $name);
        return redirect()->to(base_url('profile'))->with('msg', 'Profile details updated.');
    }

    public function orderDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $order = $orderModel->where('order_id', $id)
                            ->where('user_id', session()->get('user_id'))
                            ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $items = $orderItemModel->select('order_items.*, products.name as product_name')
                                ->join('products', 'products.product_id = order_items.product_id')
                                ->where('order_id', $id)
                                ->findAll();

        return view('order_detail', [
            'title' => 'Order Details #' . $id,
            'order' => $order,
            'items' => $items
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
