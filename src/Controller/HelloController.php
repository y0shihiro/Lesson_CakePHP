<?php
namespace App\Controller;

use App\Controller\AppController;

class HelloController extends AppController
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function initialize()
    {
        $this->viewBuilder()->setLayout('hello');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        // $this->viewBuilder()->autoLayout(false);
        $this->set('title', 'Hello!!');

        if ($this->request->isPost()) {
            $this->set('data', $this->request->data['Form1']);
        } else {
            $this->set('data', []);
        }

        $this->set('header', ['subtitle' => 'from Controller with Love♡']);
        $this->set('footer', ['copyright' => '名無しの権兵衛']);
    }
}
