<?php

namespace App\Http\Controllers;

use App\Mail\Notification;
use App\Models\Shop;
use App\Models\Shop_staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function showUsers()
    {
        $users = User::paginate(10);

        return view('users', compact('users'));
    }

    public function showShops()
    {
        $shops = Shop::with(['users' => function ($query) {
            $query->role('ShopOwner');
        }])->paginate(10);

        return view('shops', compact('shops'));
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->id;
        User::find($userId)->delete();

        return redirect()->back()->with('success', 'ユーザーID:' . $userId . 'を削除しました');
    }

    public function interactions($shop_id)
    {
        $shop = Shop::with('items.comments.user')->find($shop_id);

        $comments = [];

        foreach ($shop->items as $item) {
            foreach ($item->comments as $comment) {
                $userId = $comment->user->id;
                $shopStaff = Shop_staff::where('user_id', $userId)
                    ->where('shop_id', $shop_id)
                    ->first();
                $comments[] = [
                    'shopStaff' => $shopStaff ?? null,
                    'comment' => $comment->comment,
                    'userName' => $comment->user->name,
                    'userIcon' => $comment->user->img_url,
                ];
            };
        }

        return view('interactions', compact('comments'));
    }

    public function sendNotification(Request $request) {
        $destination = $request->input('destination');
        $messageContent = $request->input('message');

        if ($destination === 'all') {
            $users = User::all();
        } elseif ($destination === 'user') {
            $users = User::doesntHave('roles')->get();
        } else {
            $role = Role::findByName($destination);
            $users = $role ? $role->users : collect();
        }

        foreach ($users as $user) {
            Mail::to($user->email)->send(new Notification($user, $messageContent));
        }

        return back()->with('success', '送信完了しました。');
    }
}