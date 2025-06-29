<?php

namespace App\Http\Controllers;

use App\Models\NavigationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationHistoryController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:api', 'checkUser'])->except(['store']);
        $this->middleware(['auth:api', 'checkUser']);
    }

    /**
     * @OA\Get(
     *     path="/api/navigation-histories",
     *     summary="Get all navigation histories",
     *     tags={"Navigation Histories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of navigation histories",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
     *             @OA\Property(property="route_details", type="array", @OA\Items(type="string"), example={"Waypoint 1", "Waypoint 2"}),
     *             @OA\Property(property="navigation_confirmed", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $userId = Auth::id();
        $histories = NavigationHistory::where('user_id', $userId)->get();
        return response()->json($histories);
    }
    /**
     * @OA\Post(
     *     path="/api/navigation-histories",
     *     summary="Store a new navigation history",
     *     tags={"Navigation Histories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"origin","destination","route_details","navigation_confirmed"},
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
     *             @OA\Property(property="route_details", type="array", @OA\Items(type="string"), example={"Waypoint 1", "Waypoint 2"}),
     *             @OA\Property(property="navigation_confirmed", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Navigation history created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
     *             @OA\Property(property="route_details", type="array", @OA\Items(type="string"), example={"Waypoint 1", "Waypoint 2"}),
     *             @OA\Property(property="navigation_confirmed", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'route_details' => 'required|array',
            'navigation_confirmed' => 'required|boolean',
        ]);

        $history = NavigationHistory::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'route_details' => $request->route_details,
            'navigation_confirmed' => $request->navigation_confirmed,
        ]);

        return response()->json($history, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/navigation-histories/{id}",
     *     summary="Delete a navigation history",
     *     tags={"Navigation Histories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Navigation history deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Navigation history not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $history = NavigationHistory::findOrFail($id);
        $history->delete();

        return response()->json(null, 204);
    }
}