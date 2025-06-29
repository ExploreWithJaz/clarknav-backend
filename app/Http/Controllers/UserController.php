<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Info(title="User API", version="1.0")
     */

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get list of users",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="isAdmin", type="boolean", example=false),
     *             @OA\Property(property="isUser", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 00:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 00:00:00")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        return User::select('id', 'first_name', 'last_name', 'email', 'isAdmin', 'isUser', 'created_at', 'updated_at')->get();
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get user by ID",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="isAdmin", type="boolean", example=false),
     *             @OA\Property(property="isUser", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 00:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 00:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show($id)
    {
        return User::select('id', 'first_name', 'last_name', 'email', 'isAdmin', 'isUser', 'created_at', 'updated_at')->findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="isAdmin", type="boolean", example=false),
     *             @OA\Property(property="isUser", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="isAdmin", type="boolean", example=false),
     *             @OA\Property(property="isUser", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 00:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 00:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Map the request data directly to the database fields
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'isAdmin' => $request->input('isAdmin'),
            'isUser' => $request->input('isUser'),
        ];
    
        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
    
        $user->update($data);
        return $user;
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}