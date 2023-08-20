<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\LikeService;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function __construct(
        private LikeService $likeService,
    ) {}

    /**
     * Лайк сущности
     * @OA\Post(
     *       path="/api/{user}/{model}/{modelId}/like",
     *       operationId="LikeTheme",
     *       tags={"Like"},
     *       summary="Лайк сущности",
     *       @OA\Parameter(
     *              name="user",
     *              description="id пользователя",
     *              required=true,
     *              in="query",
     *              @OA\Schema(
     *                  type="integer"
     *              )
     *       ),
     *       @OA\Parameter(
     *              name="model",
     *              description="Название модели",
     *              required=true,
     *              in="query",
     *              @OA\Schema(
     *                  type="string"
     *              )
     *        ),
     *      @OA\Parameter(
     *              name="modelId",
     *              description="id записи которую лайкаем",
     *              required=true,
     *              in="query",
     *              @OA\Schema(
     *                  type="integer"
     *              )
     *       ),
     *       @OA\Response(
     *           response="200",
     *           description="OK",
     *           @OA\JsonContent(
     *                @OA\Property(
     *                    property="status",
     *                    type="boolean",
     *                ),
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                ),
     *           ),
     *       )
     *   )
     *
     * @param User $user
     * @param string $model
     * @param int $model_id
     * @return JsonResponse
     */
    public function likeTheme(User $user, string $model, int $model_id): JsonResponse
    {
        $this->likeService->like($user, $model, $model_id);

        return response()->json([
            'status'  => true,
            'message' => 'Like/dislike',
        ]);
    }
}
