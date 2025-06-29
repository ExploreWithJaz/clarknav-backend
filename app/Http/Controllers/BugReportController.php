<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\BugCategory;
use App\Enums\BugFrequency;
use App\Enums\BugPriority;
use App\Enums\BugStatus;

class BugReportController extends Controller
{
    // Add middleware to constructor
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
        $this->middleware(['auth:api', 'checkAdmin'])->only(['index', 'show', 'update', 'destroy']);
    }

    /**
     * @OA\Post(
     *     path="/api/bug-reports",
     *     summary="Create a new bug report",
     *     tags={"Bug Reports"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","category","description","steps","expected","actual","device","frequency"},
     *             @OA\Property(property="title", type="string", example="App Crashes When Searching for Routes"),
     *             @OA\Property(property="category", type="string", example="UI/UX Issue"),
     *             @OA\Property(property="description", type="string", example="The app crashes when I try to search for a route using public transit."),
     *             @OA\Property(property="steps", type="string", example="1. Open the app\n2. Search for a route\n3. App crashes"),
     *             @OA\Property(property="expected", type="string", example="The app should display the search results."),
     *             @OA\Property(property="actual", type="string", example="The app crashes."),
     *             @OA\Property(property="device", type="string", example="iPhone 12, iOS 14.4"),
     *             @OA\Property(property="frequency", type="string", example="Always"),
     *             @OA\Property(property="screenshots", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bug report created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="App Crashes When Searching for Routes"),
     *             @OA\Property(property="category", type="string", example="UI/UX Issue"),
     *             @OA\Property(property="description", type="string", example="The app crashes when I try to search for a route using public transit."),
     *             @OA\Property(property="steps", type="string", example="1. Open the app\n2. Search for a route\n3. App crashes"),
     *             @OA\Property(property="expected", type="string", example="The app should display the search results."),
     *             @OA\Property(property="actual", type="string", example="The app crashes."),
     *             @OA\Property(property="device", type="string", example="iPhone 12, iOS 14.4"),
     *             @OA\Property(property="frequency", type="string", example="Always"),
     *             @OA\Property(property="screenshots", type="string", example="screenshots/example.png", nullable=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'steps' => 'required|string',
            'expected' => 'required|string',
            'actual' => 'required|string',
            'device' => 'nullable|string',
            'frequency' => 'required|string',
            'screenshots.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'priority' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $screenshotPaths = [];
        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $screenshot) {
                $filePath = $screenshot->store('screenshots', 'public');
                $screenshotPaths[] = $filePath;
            }
        }

        $validatedData['screenshots'] = json_encode($screenshotPaths);
        $validatedData['user_id'] = auth()->check() ? auth()->id() : null;

        $bugReport = BugReport::create($validatedData);

        return response()->json($bugReport, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/bug-reports",
     *     summary="Get all bug reports",
     *     tags={"Bug Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="List of bug reports",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="App Crashes When Searching for Routes"),
     *             @OA\Property(property="category", type="string", example="UI/UX Issue"),
     *             @OA\Property(property="description", type="string", example="The app crashes when I try to search for a route using public transit."),
     *             @OA\Property(property="steps", type="string", example="1. Open the app\n2. Search for a route\n3. App crashes"),
     *             @OA\Property(property="expected", type="string", example="The app should display the search results."),
     *             @OA\Property(property="actual", type="string", example="The app crashes."),
     *             @OA\Property(property="device", type="string", example="iPhone 12, iOS 14.4"),
     *             @OA\Property(property="frequency", type="string", example="Always"),
     *             @OA\Property(property="screenshots", type="string", example="screenshots/example.png", nullable=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $bugReports = BugReport::all();
        return response()->json($bugReports);
    }

    /**
     * @OA\Get(
     *     path="/api/bug-reports/{id}",
     *     summary="Get a specific bug report",
     *     tags={"Bug Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bug report details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="App Crashes When Searching for Routes"),
     *             @OA\Property(property="category", type="string", example="UI/UX Issue"),
     *             @OA\Property(property="description", type="string", example="The app crashes when I try to search for a route using public transit."),
     *             @OA\Property(property="steps", type="string", example="1. Open the app\n2. Search for a route\n3. App crashes"),
     *             @OA\Property(property="expected", type="string", example="The app should display the search results."),
     *             @OA\Property(property="actual", type="string", example="The app crashes."),
     *             @OA\Property(property="device", type="string", example="iPhone 12, iOS 14.4"),
     *             @OA\Property(property="frequency", type="string", example="Always"),
     *             @OA\Property(property="screenshots", type="string", example="screenshots/example.png", nullable=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bug report not found"
     *     )
     * )
     */
    public function show($id)
    {
        $bugReport = BugReport::findOrFail($id);
        return response()->json($bugReport);
    }

    /**
     * @OA\Put(
     *     path="/api/bug-reports/{id}",
     *     summary="Update a bug report status",
     *     tags={"Bug Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"OPEN","IN_PROGRESS","RESOLVED","CLOSED"}, example="IN_PROGRESS")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bug report updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="App Crashes When Searching for Routes"),
     *             @OA\Property(property="category", type="string", example="UI/UX Issue"),
     *             @OA\Property(property="description", type="string", example="The app crashes when I try to search for a route using public transit."),
     *             @OA\Property(property="steps", type="string", example="1. Open the app\n2. Search for a route\n3. App crashes"),
     *             @OA\Property(property="expected", type="string", example="The app should display the search results."),
     *             @OA\Property(property="actual", type="string", example="The app crashes."),
     *             @OA\Property(property="device", type="string", example="iPhone 12, iOS 14.4"),
     *             @OA\Property(property="frequency", type="string", example="Always"),
     *             @OA\Property(property="screenshots", type="string", example="screenshots/example.png", nullable=true),
     *             @OA\Property(property="status", type="string", example="IN_PROGRESS"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bug report not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:' . implode(',', BugStatus::values()),
        ]);

        $bugReport = BugReport::findOrFail($id);
        $bugReport->update($validatedData);

        return response()->json($bugReport);
    }

    /**
     * @OA\Delete(
     *     path="/api/bug-reports/{id}",
     *     summary="Delete a bug report",
     *     tags={"Bug Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bug report deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bug report not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $bugReport = BugReport::findOrFail($id);
        $bugReport->delete();

        return response()->json(['message' => 'Bug report deleted successfully']);
    }
}