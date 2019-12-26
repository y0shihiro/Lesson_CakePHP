<?php
namespace App\Controller;

use App\Controller\AppController;

class PeopleController extends AppController
{
    public $paginate = [
    'finder' => 'byAge',
    'limit' => 5,
    // 'sort' => 'id',
    // 'direction' => 'asc',
    'contain' => ['Messages'],
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $data = $this->paginate($this->People);
        $this->set('data', $data);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function add()
    {
        $msg = 'please type your personal data...';
        $entity = $this->People->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data['People'];
            $entity = $this->People->newEntity($data);
            if ($this->People->save($entity)) {
                return $this->redirect(['action' => 'index']);
            }
            $msg = 'Error was occurred...';
        }
        $this->set('msg', $msg);
        $this->set('entity', $entity);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function create()
    {
        if ($this->request->is('post')) {
            $data = $this->request->data['People'];
            $entity = $this->People->newEntity($data);
            $this->People->save($entity);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->request->query['id'];
        $entity = $this->People->get($id);
        $this->set('entity', $entity);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function update()
    {
        if ($this->request->is('post')) {
            $data = $this->request->data['People'];
            $entity = $this->People->get($data['id']);
            $this->People->patchEntity($entity, $data);
            $this->People->save($entity);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function delete()
    {
        $id = $this->request->query['id'];
        $entity = $this->People->get($id);
        $this->set('entity', $entity);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function destroy()
    {
        if ($this->request->is('post')) {
            $data = $this->request->data['People'];
            $entity = $this->People->get($data['id']);
            $this->People->delete($entity);
        }

        return $this->redirect(['action' => 'index']);
    }
}
