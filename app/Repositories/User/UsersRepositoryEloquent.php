<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersRepositoryEloquent implements UsersRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user
            ->where('user_id', $this->loggedUser->id)->get();

        return (new Collection($user))->paginate(10);
    }

    public function store(Request $request)
    {
        $request['user_id'] = $this->loggedUser->id;
        $user = $this->user->create($request->all());
        $user->save();

        return $user;
    }

    public function show(int $id)
    {
        return $this->user
            ->where('id', $id)
            ->where('user_id', $this->loggedUser->id)
            ->first();
    }

    public function update(int $id, Request $request)
    {
        $user = $this->user
            ->find($id);

        if ($user) {
            $user->update($request->all());
        }

        return $user ? $user : [];
    }

    public function destroy(int $id)
    {
        $user = $this->user->find($id);

        if ($user) {
            $user->delete();
        }

        return $user ? 1 : [];
    }
}
