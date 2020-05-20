<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Achievements Controller
 *
 * @property \App\Model\Table\AchievementsTable $Achievements
 *
 * @method \App\Model\Entity\Achievement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AchievementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $achievements = $this->paginate($this->Achievements);

        $this->set(compact('achievements'));
    }

    /**
     * View method
     *
     * @param string|null $id Achievement id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $achievement = $this->Achievements->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('achievement', $achievement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $achievement = $this->Achievements->newEntity();
        if ($this->request->is('post')) {
            $achievement = $this->Achievements->patchEntity($achievement, $this->request->getData());
            if ($this->Achievements->save($achievement)) {
                $this->Flash->success(__('The achievement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The achievement could not be saved. Please, try again.'));
        }
        $users = $this->Achievements->Users->find('list', ['limit' => 200]);
        $this->set(compact('achievement', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Achievement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $achievement = $this->Achievements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $achievement = $this->Achievements->patchEntity($achievement, $this->request->getData());
            if ($this->Achievements->save($achievement)) {
                $this->Flash->success(__('The achievement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The achievement could not be saved. Please, try again.'));
        }
        $users = $this->Achievements->Users->find('list', ['limit' => 200]);
        $this->set(compact('achievement', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Achievement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $achievement = $this->Achievements->get($id);
        if ($this->Achievements->delete($achievement)) {
            $this->Flash->success(__('The achievement has been deleted.'));
        } else {
            $this->Flash->error(__('The achievement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
