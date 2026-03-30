<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'user_id'    => $user['user_id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ];
            $session->set($sessionData);
            return redirect()->to(base_url());
        } else {
            $session->setFlashdata('error', 'Invalid Email or Password');
            return redirect()->to(base_url('login'));
        }
    }

    public function register()
    {
        return view('auth/register', ['title' => 'Register']);
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
            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role'     => 'customer'
            ];
            $model->save($data);
            return redirect()->to(base_url('login'))->with('registration_success', 'Your account has been created successfully! You can now log in to start ordering your favorite treats.');
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }
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

    public function orderDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $orderModel = new OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();

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

        $data = [
            'title' => 'Order Details #' . $id,
            'order' => $order,
            'items' => $items
        ];

        return view('order_detail', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
