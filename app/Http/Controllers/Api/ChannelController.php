<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    public function saveImg($img): string
    {
        $path = Storage::putFile('public', $img); //Where to put the file
        $url = Storage::url($path); //url() - Get the URL for the file at the given path.
        return $url;
    }

    public function createChannel(User $user, ChannelRequest $request)
    {
        $ch = Channel::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $request->image ? $this->saveImg($request->image) : null,
            'user_id'     => $user->id
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Channel ' . $ch->name .' create!',
        ]);
    }
}


