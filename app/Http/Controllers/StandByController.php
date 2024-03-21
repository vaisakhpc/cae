<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReaderServiceInterface;
use App\Http\Resources\ApiResponse;

class StandByController extends Controller
{

    public function __construct(private ReaderServiceInterface $reader) {}

    /**
     * @OA\Get(
     *      path="/standbys/{userId}",
     *      operationId="getStandBysForNextWeekForUser",
     *      tags={"StandBy"},
     *      summary="Get stand by days by user ID for next week",
     *      description="Returns stand by days for the specified user ID for next week.",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          required=true,
     *          description="ID of the user",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EventResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No flights found",
     *      )
     * )
     */
    public function index(Request $request, int $userId)
    {
        $response = $this->reader->getStandBysForNextWeek($userId);
        if($response->count()) {
            return response()->json(ApiResponse::success($response->toArray($request)['data'], 'Fetched successfully!')); 
        } else {
            return response()->json(ApiResponse::error('No standbys found', 404), 404);
        }
        
    }
}