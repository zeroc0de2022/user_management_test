<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::paginate(10); // Пагинация по 10 пользователей на странице
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(['name'     => 'required|string|max:255',
                            'email'    => 'required|email|unique:users,email',
                            'password' => 'required|string|min:6',
                            'ip'       => 'nullable|string|max:15',
                            'comment'  => 'nullable|string',]);

        $user = User::create(['name'     => $request->name,
                              'email'    => $request->email,
                              'password' => bcrypt($request->password),
                              'ip'       => $request->ip,
                              'comment'  => $request->comment,]);

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
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        $request->validate(['name'     => 'sometimes|string|max:255',
                            'email'    => 'sometimes|email|unique:users,email,' . $id,
                            'password' => 'sometimes|string|min:6',
                            'ip'       => 'nullable|string|max:15',
                            'comment'  => 'nullable|string',]);
        $user->update(['name'     => $request->name ?? $user->name,
                       'email'    => $request->email ?? $user->email,
                       'password' => $request->password
                           ? bcrypt($request->password)
                           : $user->password,
                       'ip'       => $request->ip ?? $user->ip,
                       'comment'  => $request->comment ?? $user->comment,]);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Пользователь удален'], 200);
    }
}
