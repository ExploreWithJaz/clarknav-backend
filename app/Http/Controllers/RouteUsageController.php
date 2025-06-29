<?php

namespace App\Http\Controllers;

use App\Models\RouteUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteUsageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
        $this->middleware(['auth:api', 'checkAdmin'])->only(['index', 'show', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/route-usages",
     *     summary="Get all route usages",
     *     tags={"Route Usages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of route usages",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $routeUsages = RouteUsage::all();
        return response()->json($routeUsages);
    }

    /**
     * @OA\Post(
     *     path="/api/route-usages",
     *     summary="Store a new route usage",
     *     tags={"Route Usages"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"route_id","route_name","description","color","origin","destination","route_type"},
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Route usage created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney"),
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
        $validatedData = $request->validate([
            'route_id' => 'required|string',
            'route_name' => 'required|string',
            'description' => 'nullable|string',
            'color' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'route_type' => 'required|in:Jeepney,Bus,Taxi,Walking', // Use lowercase values
        ]);
    
        $validatedData['user_id'] = Auth::check() ? Auth::id() : null;
    
        $routeUsage = RouteUsage::create($validatedData);
        return response()->json($routeUsage, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/route-usages/{id}",
     *     summary="Get a specific route usage",
     *     tags={"Route Usages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Route usage details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Route usage not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Route usage not found.")
     *         )
     *     )
     * )
     *      
     * */
    public function show($id)
    {
        $routeUsage = RouteUsage::findOrFail($id);
        return response()->json($routeUsage);
    }

    /**
     * @OA\Put(
     *     path="/api/route-usages/{id}",
     *     summary="Update a specific route usage",
     *     tags={"Route Usages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Route usage updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="route_id", type="string", example="J1"),
     *             @OA\Property(property="route_name", type="string", example="Jeepney Route 1 Green"),
     *             @OA\Property(property="description", type="string", example="Bayanihan Terminal - Mt. Pinatubo Comm."),
     *             @OA\Property(property="color", type="string", example="#228B22"),
     *             @OA\Property(property="origin", type="string", example="Astro Park"),
     *             @OA\Property(property="destination", type="string", example="Clark Airport Parking"),
     *             @OA\Property(property="route_type", type="string", example="Jeepney"),
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Route usage not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Route usage not found.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'route_id' => 'sometimes|required|string',
            'route_name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'color' => 'sometimes|required|string',
            'origin' => 'sometimes|required|string',
            'destination' => 'sometimes|required|string',
            'route_type' => 'sometimes|required|in:Jeepney,Bus,Taxi,Walking', // Use lowercase values
        ]);

        $routeUsage = RouteUsage::findOrFail($id);
        $routeUsage->update($validatedData);

        return response()->json($routeUsage);
    }

    /**
     * @OA\Delete(
     *     path="/api/route-usages/{id}",
     *     summary="Delete a specific route usage",
     *     tags={"Route Usages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Route usage deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Route usage not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Route usage not found.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $routeUsage = RouteUsage::findOrFail($id);
        $routeUsage->delete();

        return response()->json(null, 204);
    }
}