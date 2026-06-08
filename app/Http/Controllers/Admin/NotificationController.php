<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
        }
        return back();
    }
}
