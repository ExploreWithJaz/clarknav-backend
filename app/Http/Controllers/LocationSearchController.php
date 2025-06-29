<?php

namespace App\Http\Controllers;

use App\Models\LocationSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationSearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
        $this->middleware(['auth:api', 'checkAdmin'])->only(['index', 'show', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/location-searches",
     *     summary="Get all location searches",
     *     tags={"Location Searches"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of location searches",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $searches = LocationSearch::all();
        return response()->json($searches);
    }

    /**
     * @OA\Post(
     *     path="/api/location-searches",
     *     summary="Store a new location search",
     *     tags={"Location Searches"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"origin","destination"},
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location search created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
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
        ]);
    
        $search = LocationSearch::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'origin' => $request->origin,
            'destination' => $request->destination,
        ]);
    
        return response()->json($search, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/location-searches/{id}",
     *     summary="Get a specific location search",
     *     tags={"Location Searches"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location search details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location search not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location search not found.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $search = LocationSearch::findOrFail($id);
        return response()->json($search);
    }

    /**
     * @OA\Put(
     *     path="/api/location-searches/{id}",
     *     summary="Update a location search",
     *     tags={"Location Searches"},
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
     *             required={"origin","destination"},
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location search updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="origin", type="string", example="New York"),
     *             @OA\Property(property="destination", type="string", example="Los Angeles"),
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
     *         description="Location search not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location search not found.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
        ]);

        $search = LocationSearch::findOrFail($id);
        $search->update($validatedData);

        return response()->json($search);
    }

    /**
     * @OA\Delete(
     *     path="/api/location-searches/{id}",
     *     summary="Delete a location search",
     *     tags={"Location Searches"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Location search deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location search not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Location search not found.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $search = LocationSearch::findOrFail($id);
        $search->delete();

        return response()->json(null, 204);
    }
}