<?php

namespace App\Service;

use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LikeService
{
    /**
     * Если функция isLiked() вернет true, значит в бд уже есть запись
     * о том что юзер лайкал определенную запись модели. Произойдет декремент записи и
     * будет удалена запись о лайке
     *
     * Иначе инкремен записи + добавится запись о лайке
     *
     * @param User $user - кто лайкает
     * @param string $model - сущность которую лайкаем (Theme, Post и тд.)
     * @param int $model_id - id сущности которую лайкаем
     * @return void
     */
    public function like(User $user, string $model, int $model_id): void
    {
        if($this->isLiked($user, $model, $model_id)) {
            $this->dropLike($user, $model, $model_id);
        } else {
            $this->addLike($user, $model, $model_id);
        }
    }

    /**
     * Добавление лайка
     *
     * @param User $user
     * @param string $model
     * @param int $model_id
     * @return void
     */
    private function addLike(User $user, string $model, int $model_id): void
    {
        DB::transaction(function () use ($model, $user, $model_id) {
            $this->getClassWithNamespace($model)::find($model_id)
                ->increment('likes');

            Like::create([
                'user_id' => $user->id,
                'model' => $model,
                'model_id' => $model_id
            ]);
        });
    }

    /**
     * Удаление лайка
     *
     * @param User $user
     * @param string $model
     * @param int $model_id
     * @return void
     */
    private function dropLike(User $user, string $model, int $model_id): void
    {
        DB::transaction(function () use ($model, $user, $model_id) {
            $this->getClassWithNamespace($model)::find($model_id)
                ->decrement('likes');

            Like::where('user_id', $user->id)
                ->where('model', $model)
                ->where('model_id', $model_id)
                ->delete();
        });
    }

    /**
     * Проверка на существование лайка
     *
     * @param User $user
     * @param string $model
     * @param int $model_id
     * @return Like|null
     */
    private function isLiked(User $user, string $model, int $model_id): Like|null
    {
        return Like::where('user_id', $user->id)
            ->where('model', $model)
            ->where('model_id', $model_id)
            ->first();
    }

    /**
     * Получаем полный класс + namespace без подключения в use
     *
     * @param string $className
     * @return string
     */
    private function getClassWithNamespace(string $className): string
    {
        $namespace = 'App\Models';

        $lastBackslashIndex = strrpos($className, '\\');

        if ($lastBackslashIndex !== false) {
            $className = substr($className, $lastBackslashIndex + 1);
        }

        return $namespace . '\\' . $className;
    }
}
