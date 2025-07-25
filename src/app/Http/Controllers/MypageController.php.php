<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('shops');
        $shop = $user->shops->first() ?? null;
        if ($shop) {
            $img_url = $shop->img_url;
        } else {
            $img_url = $user->img_url;
        }

        $sellItems = $user->items;
        $soldItems = $user->soldToItems ?? null;
        $hasAnyRole = $user->roles->count() > 0;

        $data = [
            'user' => $user,
            'shop' => $shop,
            'img_url' => $img_url,
            'sellItems' => $sellItems,
            'soldItems' => $soldItems,
            'hasAnyRole' => $hasAnyRole,
        ];

        return view('mypage', $data);
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->profile) {
            $profile = $user->profile;
        }

        return view('profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userForm = $request->only('name');
        unset($request->all()['_token']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('flea-market', $filename, 's3');
            $imgUrl = Storage::disk('s3')->url($path);

            $userForm['img_url'] = $imgUrl;
        }

        $user->update($userForm);

        $profile = $user->profile;
        $profileForm = $request->only(['postcode', 'address', 'building']);

        if ($profile) {
            $profile->update($profileForm);
        } else {
            $user->profile()->create($profileForm);
        }

        return redirect()->back()->with('success','プロフィールを変更しました');
    }
}