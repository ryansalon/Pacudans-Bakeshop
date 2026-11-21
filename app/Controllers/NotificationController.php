<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;

class NotificationController extends BaseController
{
    use ResponseTrait;

    public function fetchUnread()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->failUnauthorized();
        }

        $userId = session()->get('user_id');
        $model = new NotificationModel();
        $notifications = $model->getUnread($userId);

        return $this->respond([
            'status' => 'success',
            'count'  => count($notifications),
            'data'   => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->failUnauthorized();
        }

        $model = new NotificationModel();
        $notif = $model->find($id);

        if (!$notif || (int) $notif['user_id'] !== (int) session()->get('user_id')) {
            return $this->failForbidden();
        }

        $model->update($id, ['is_read' => 1]);
        return $this->respond(['status' => 'success']);
    }

    public function markAllAsRead()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->failUnauthorized();
        }

        $userId = session()->get('user_id');
        $model = new NotificationModel();

        $model->where('user_id', $userId)
              ->where('is_read', 0)
              ->set(['is_read' => 1])
              ->update();

        return $this->respond(['status' => 'success']);
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->failUnauthorized();
        }

        $model = new NotificationModel();
        $notif = $model->find($id);

        if ($notif && (int) $notif['user_id'] === (int) session()->get('user_id')) {
            $model->delete($id);
            return $this->respond(['status' => 'success']);
        }

        return $this->failForbidden();
    }
}
