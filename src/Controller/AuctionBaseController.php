<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

class AuctionBaseController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
        'authorize' => ['Controller'],
        'authenticate' => [
          'Form' => [
        'fields' => [
          'username' => 'username',
          'password' => 'password'
        ]
          ]
        ],
        'loginRedirect' => [
          'controller' => 'Users',
          'action' => 'login'
        ],
        'logoutRedirect' => [
          'controller' => 'Users',
          'action' => 'logout'
        ],
        'authError' => 'ログインしてください。'
        ]);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if (!empty($user)) {
                $this->Auth->setUser($user);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('ユーザー名かパスワードが間違っています。');
        }
    }

    public function logout()
    {
        $this->request->session()->destroy();

        return $this->redirect($this->Auth->logout());
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([]);
    }

    public function isAuthorized($user = null)
    {
        if ($user['role'] === 'admin') {
            return true;
        }
        if ($user['role'] === 'user') {
            if ($this->name == 'Auction') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
