<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use App\Models\User;
use App\Service\UploadPhotoService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    public function __construct(
        private UploadPhotoService $uploadPhotoService
    ) {}

    /**
     * Создание канала
     * @OA\Post(
     *      path="/api/{user}/create-channel",
     *      operationId="CreateChannel",
     *      tags={"Channel"},
     *      summary="Создание канала",
     *      @OA\Parameter(
     *            name="name",
     *            description="Название канала",
     *            required=true,
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *      ),
     *      @OA\Parameter(
     *             name="description",
     *             description="Описание канала",
     *             required=true,
     *             in="query",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *      ),
     *      @OA\Parameter(
     *             name="image",
     *             description="Изображение для канала",
     *             required=false,
     *             in="query",
     *             @OA\Schema(
     *                 type="file"
     *             )
     *       ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                   property="status",
     *                   type="boolean",
     *               ),
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *               ),
     *          ),
     *      )
     *  )
     * @param User $user
     * @param ChannelRequest $request
     * @return JsonResponse
     */
    public function createChannel(User $user, ChannelRequest $request): JsonResponse
    {
        $ch = Channel::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $request->image ?
                $this->uploadPhotoService->upload($request->image) :
                null,
            'user_id'     => $user->id
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Channel ' . $ch->name .' create!',
        ]);
    }

    /**
     * Получение каналов
     * @OA\Get(
     *       path="/api/{user}/channels",
     *       operationId="GetChannel",
     *       tags={"Channel"},
     *       summary="Получение каналов",
     *       @OA\Response(
     *           response="200",
     *           description="OK",
     *       )
     *   )
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function getChannel(User $user): LengthAwarePaginator
    {
        return $user->channels()->paginate(5);
    }
}


