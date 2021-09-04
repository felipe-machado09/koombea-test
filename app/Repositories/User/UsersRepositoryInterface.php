<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

interface UsersRepositoryInterface
{
    public function index();
    public function show(int $id);
    public function store(Request $request);
    public function update(Request $request);
    public function destroy(int $id);
}
