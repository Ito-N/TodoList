<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Achievements', 'Tasks'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            //ログにimageを出力
            $this->log($this->request->data['image'],"debug");
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // image変数にファイルを代入
            $dir = realpath(WWW_ROOT . "/upload_img");
            $limitFileSize = 1024 * 1024;
            try {
              $user['image'] = $this->file_upload($this->request->data['image'], $dir, $limitFileSize);
            } catch (RuntimeException $e){
              $this->Flash->error(__('ファイルのアップロードができませんでした.'));
              $this->Flash->error(__($e->getMessage()));
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー登録が完了しました！'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('ユーザー登録に失敗しました。内容を確認し、再登録をお願いします'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function editImage($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->log($this->request->data,"debug");
            $user = $this->Users->patchEntity($user, $this->request->getData());

            //以下を追加
            $dir = realpath(WWW_ROOT . "/upload_img");
            // deleteボタンがクリックされたとき
            if(isset($this->request->data["file_delete"])){
                try {
                    $del_file = new File($dir . "/". $this->request->data["file_before"]);
                    // ファイル削除処理実行
                    if($del_file->delete()) {
                        $user['image'] = "";
                    } else {
                        $user['image'] = $this->request->data["file_before"];
                        throw new RuntimeException('ファイルの削除ができませんでした.');
                    }
                } catch (RuntimeException $e){
                    $this->Flash->error(__($e->getMessage()));
                }
            } else {
                // ファイルが入力されたとき
                if($this->request->data["image"]["name"]){
                    $limitFileSize = 1024 * 1024;
                    try {
                        $user['image'] = $this->file_upload($this->request->data['image'], $dir, $limitFileSize);
                        // ファイル更新の場合は古いファイルは削除
                        if (isset($this->request->data["file_before"])){
                            // ファイル名が同じ場合は削除を実行しない
                            if ($this->request->data["file_before"] != $user['image']){
                                $del_file = new File($dir . "/". $this->request->data["file_before"]);
                                if(!$del_file->delete()) {
                                    $this->log("ファイル更新時に下記ファイルが削除できませんでした。","debug");
                                    $this->log($this->request->data["file_before"],"debug");
                                }
                            }
                        }
                    } catch (RuntimeException $e){
                        // アップロード失敗の時、既登録ファイルがある場合はそれを保持
                        if (isset($this->request->data["file_before"])){
                            $user['image'] = $this->request->data["file_before"];
                        }
                        $this->Flash->error(__('ファイルのアップロードができませんでした.'));
                        $this->Flash->error(__($e->getMessage()));
                    }
                } else {
                    // ファイルは入力されていないけど登録されているファイルがあるとき
                    if (isset($this->request->data["file_before"])){
                        $user['image'] = $this->request->data["file_before"];
                    }
                }
            }   //ここまで！！！！！


            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                //以下追加
                if(isset($this->request->data["file_delete"])){
                  $this->set(compact('user'));
                  return $this->redirect(['action' => 'edit', $id]);
                } else {
                  return $this->redirect(['action' => 'index']);
                }  //ここまで！！！！！！

            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        //以下を追記
        $dir = realpath(WWW_ROOT . "/upload_img");
        try {
            $del_file = new File($dir . "/". $user->image);
            // ファイル削除処理実行
            if($del_file->delete()) {
                $user['image'] = "";
            } else {
                throw new RuntimeException('ファイルの削除ができませんでした.');
            }
        } catch (RuntimeException $e){
            $this->log($e->getMessage(),"debug");
            $this->log($news->file_name,"debug");
        }    //ここまで！！！！！

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login() {
      if ($this->request->is('post')) {
        $user = $this->Auth->identify();
        if ($user) {
          $this->Auth->setUser($user);
          $this->Flash->success('ログインしました！');
          return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__('登録されたメールアドレス、パスワードと一致しません'));
      }
    }

    public function logout() {
      $this->Flash->success('ログアウトしました！');
      return $this->redirect($this->Auth->logout());
    }


    public function file_upload ($file = null,$dir = null, $limitFileSize = 1024 * 1024){
    try {
        // ファイルを保存するフォルダ $dirの値のチェック
        if ($dir){
            if(!file_exists($dir)){
                throw new RuntimeException('指定のディレクトリがありません。');
            }
        } else {
            throw new RuntimeException('ディレクトリの指定がありません。');
        }

        // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
        if (!isset($file['error']) || is_array($file['error'])){
            throw new RuntimeException('Invalid parameters.');
        }

        // エラーのチェック
        switch ($file['error']) {
            case 0:
                break;
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // ファイル情報取得
        $fileInfo = new File($file["tmp_name"]);

        // ファイルサイズのチェック
        if ($fileInfo->size() > $limitFileSize) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // ファイルタイプのチェックし、拡張子を取得  array_search(検索する値, 検索対象の配列, 型の比較を行うか)
        if (false === $ext = array_search($fileInfo->mime(),
                                          ['jpg' => 'image/jpeg',
                                           'JPG' => 'image/JPG',
                                           'png' => 'image/png',
                                           'gif' => 'image/gif',],
                                          true)){
            throw new RuntimeException('Invalid file format.');
        }

        // ファイル名の生成
        //            $uploadFile = $file["name"] . "." . $ext;
        $uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

        // ファイルの移動 ただ、「move_uploaded_file()」関数は、正常にファイル移動ができない場合は、「false」を返すとともに、
        //Warningを出力するため、CakePHP3ではそこで止まってしまう。
        //そのため「@move_uploaded_file()」とすることで Warningを出さないように対処。
        if (!@move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)){
            throw new RuntimeException('Failed to move uploaded file.');
        }

        // 処理を抜けたら正常終了
        //            echo 'File is uploaded successfully.';

    } catch (RuntimeException $e) {
        throw $e;
    }
    return $uploadFile;
  }
}
