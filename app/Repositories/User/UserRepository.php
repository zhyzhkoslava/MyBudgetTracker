<?php


namespace App\Repositories\User;


use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserInfo(int $userId)
    {
        return $this->user->with('accounts','currencies')->findOrFail($userId);
    }

    public function update(User $user, array $userData)
    {
        return $user->update($userData);
    }

}
