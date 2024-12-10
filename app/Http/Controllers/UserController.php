<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 *
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query();
        // Поиск по имени
        if($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        // Сортировка по имени
        if($request->has('sort')) {
            $direction = $request->has('order') && $request->order === 'desc'
                ? 'desc'
                : 'asc';
            $query->orderBy($request->sort, $direction);
        }
        // Пагинация
        $users = $query->paginate(10);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::create(['name'     => $validated['name'],
                              'email'    => $validated['email'],
                              'password' => bcrypt($validated['password']),
                              'ip'       => $validated['ip'] ?? null,
                              'comment'  => $validated['comment'] ?? null,]);
        return response()->json($user, 201);
    }


    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        $validated = $request->validated();
        $user->update(['name'     => $validated['name'] ?? $user->name,
                       'email'    => $validated['email'] ?? $user->email,
                       'password' => isset($validated['password'])
                           ? bcrypt($validated['password'])
                           : $user->password,
                       'ip'       => $validated['ip'] ?? $user->ip,
                       'comment'  => $validated['comment'] ?? $user->comment,]);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Пользователь удален'], 200);
    }
}
