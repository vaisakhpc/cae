<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReaderServiceInterface;
use App\Http\Resources\ApiResponse;

class FlightController extends Controller
{

    public function __construct(private ReaderServiceInterface $reader)
    {
    }

    /**
     * @OA\Get(
     *      path="/flights-next-week/{userId}",
     *      operationId="getFlightsForNextWeekForUser",
     *      tags={"Flights"},
     *      summary="Get flights by user ID",
     *      description="Returns flights for the specified user ID for next week.",
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
    public function next(Request $request, int $userId)
    {
        $response = $this->reader->getFlightsForNextWeek($userId);
        if ($response->count()) {
            return response()->json(ApiResponse::success($response->toArray($request)['data'], 'Fetched successfully!'));
        } else {
            return response()->json(ApiResponse::error('No flights found for next week', 404), 404);
        }
    }

    /**
     * @OA\Get(
     *      path="/flights-from/{userId}/{location}",
     *      operationId="getFlightsFromGivenLocation",
     *      tags={"Flights"},
     *      summary="Get flights from a specific location for a user",
     *      description="Returns flights from a specific location for the specified user ID.",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          required=true,
     *          description="ID of the user",
     *          @OA\Schema(type="integer")
     *      ),     
     *      @OA\Parameter(
     *          name="location",
     *          in="path",
     *          required=true,
     *          description="IATA code",
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
    public function from(Request $request, int $userId, string $location)
    {
        $response = $this->reader->getFlightsFromLocation($userId, $location);
        if ($response->count()) {
            return response()->json(ApiResponse::success($response->toArray($request)['data'], 'Fetched successfully!'));
        } else {
            return response()->json(ApiResponse::error('No flights found from this location', 404), 404);
        }
    }
}
