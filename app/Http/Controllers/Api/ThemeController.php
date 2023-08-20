<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThemeCreateRequest;
use App\Models\Channel;
use App\Models\Theme;
use App\Models\User;
use App\Service\LikeService;
use App\Service\UploadPhotoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __construct(
        private UploadPhotoService $uploadPhotoService,
    ) {}

    /**
     * Создание новой темы
     * @OA\Post(
     *      path="/api/{channel}/create-theme",
     *      operationId="CreateTheme",
     *      tags={"Theme"},
     *      summary="Создание темы",
     *      @OA\Parameter(
     *             name="name",
     *             description="Создание темы",
     *             required=true,
     *             in="query",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *      ),
     *      @OA\Parameter(
     *             name="description",
     *             description="Описание темы",
     *             required=true,
     *             in="query",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *       ),
     *     @OA\Parameter(
     *             name="images[]",
     *             description="Дополнителыние изображения",
     *             required=true,
     *             in="query",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *      ),
     *      @OA\Parameter(
     *             name="comments_active",
     *             description="Статус комментариев",
     *             required=false,
     *             in="query",
     *             @OA\Schema(
     *                 type="integer"
     *             )
     *      ),
     *      @OA\Parameter(
     *            name="repost_id",
     *            description="Тема с репостом",
     *            required=false,
     *            in="query",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *      ),
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
     * @param Channel $channel
     * @param ThemeCreateRequest $request
     * @return JsonResponse
     */
    public function createTheme(Channel $channel, ThemeCreateRequest $request): JsonResponse
    {
        $th = Theme::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'channel_id'      => $channel->id,
            'images'          => $request->images ?
                $this->uploadPhotoService->upload($request->images, true) :
                null,
            'comments_active' => $request->comments_active,
            'repost_id'       => $request->repost_id
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Theme ' . $th->name .' create!',
        ]);
    }
}
