<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Exception;

class AuctionController extends AuctionBaseController
{
    public $useTable = false;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Users');
        $this->loadModel('Biditems');
        $this->loadModel('Bidinfo');
        $this->loadModel('Bidrequests');
        $this->loadModel('Bidmessages');
        $this->set('authuser', $this->Auth->user());
        $this->viewBuilder()->setLayout('auction');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $auction = $this->paginate('Biditems', [
        'order' => ['endtime' => 'desc'],
        'limit' => 10
        ]);
        $this->set(compact('auction'));
    }

    /**
     * Undocumented function
     *
     * @param [type] $id test
     * @return void
     */
    public function view($id = null)
    {
        $biditem = $this->Biditems->get($id, [
        'contain' => ['Users', 'Bidinfo', 'Bidinfo.Users']
        ]);
        if ($biditem->endtime < new \DateTime('now') && $biditem->finished == 0) {
            $biditem->finished = 1;
            $this->Biditems->save($biditem);
            $bidinfo = $this->Bidinfo->newEntity();
            $bidinfo->biditem_id = $id;
            $bidrequest = $this->Bidrequests->find('all', [
            'conditions' => ['biditem_id' => $id],
            'contain' => ['Users'],
            'order' => ['price' => 'desc']
            ])->first();
            if (!empty($bidrequest)) {
                $bidinfo->user_id = $bidrequest->user->id;
                $bidinfo->user = $bidrequest->user;
                $bidinfo->price = $bidrequest->price;
                $this->Bidinfo->save($bidinfo);
            }
            $biditem->bidinfo = $bidinfo;
        }
        $bidrequests = $this->Bidrequests->find('all', [
        'conditions' => ['biditem_id' => $id],
        'contain' => ['Users'],
        'order' => ['price' => 'desc']
        ])->toArray();
        $this->set(compact('biditem', 'bidrequests'));
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function add()
    {
        $biditem = $this->Biditems->newEntity();
        if ($this->request->isPost()) {
            $biditem = $this->Biditems->patchEntity($biditem, $this->request->getData());
            if ($this->Biditems->save($biditem)) {
                $this->Flash->success(__('保存しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
        }
        $this->set(compact('biditem'));
    }

    /**
     * Undocumented function
     *
     * @param [type] $biditem_id test
     * @return mixed
     */
    public function bid($biditem_id = null)
    {
        $bidrequest = $this->Bidrequests->newEntity();
        if ($this->request->isPost()) {
            $bidrequest = $this->Bidrequests->patchEntity($bidrequest, $this->request->getData());
            if ($this->Bidrequests->save($bidrequest)) {
                $this->Flash->success(__('入札を送信しました。'));

                return $this->redirect(['action' => 'view', $biditem_id]);
            }
            $this->Flash->error(__('入札に失敗しました。もう一度入力下さい。'));
        }
        $biditem = $this->Biditems->get($biditem_id);
        $this->set(compact('bidrequest', 'biditem'));
    }

    /**
     * Undocumented function
     *
     * @param [type] $bidinfo_id test
     * @return void
     */
    public function msg($bidinfo_id = null)
    {
        $bidmsg = $this->Bidmessages->newEntity();
        if ($this->request->isPost()) {
            $bidmsg = $this->Bidmessages->patchEntity($bidmsg, $this->request->getData());
            if ($this->Bidmessages->save($bidmsg)) {
                $this->Flash->success(__('保存しました。'));
            } else {
                $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
            }
        }
        try {
            $bidinfo = $this->Bidinfo->get($bidinfo_id, [
            'contain' => ['Biditems']
            ]);
        } catch (Exception $e) {
            $bidinfo = null;
        }
        $bidmsgs = $this->Bidmessages->find('all', [
          'conditions' => ['bidinfo_id' => $bidinfo_id],
          'contain' => ['Users'],
          'order' => ['created' => 'desc']
        ]);
        $this->set(compact('bidmsgs', 'bidinfo', 'bidmsg'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function home()
    {
        $bidinfo = $this->paginate('Bidinfo', [
        'conditions' => ['Bidinfo.user_id' => $this->Auth->user('id')],
        'contain' => ['Users', 'Biditems'],
        'order' => ['created' => 'desc'],
        'limit' => 10
        ])->toArray();
        $this->set(compact('bidinfo'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function home2()
    {
        $biditems = $this->paginate('Biditems', [
        'conditions' => ['Biditems.user_id' => $this->Auth->user('id')],
        'contain' => ['Users', 'Bidinfo'],
        'order' => ['created' => 'desc'],
        'limit' => 10
        ])->toArray();
        $this->set(compact('biditems'));
    }
}
