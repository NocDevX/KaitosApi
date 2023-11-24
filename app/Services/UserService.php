<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserService
{
    public function getUser(Request $request = null): Collection
    {
        return $this->buildQuery($request)->get();
    }

    protected function buildQuery(Request $request = null): Builder
    {
        $query = User::query();

        if (!empty($request->name)) {
            $query->where('name', $request->string('name'));
        }

        if (!empty($request->email)) {
            $query->where('email', $request->string('email'));
        }

        return $query;
    }
}
