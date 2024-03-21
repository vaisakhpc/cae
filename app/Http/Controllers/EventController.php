<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReaderServiceInterface;
use App\Http\Resources\ApiResponse as Api;


/**
 *  * @OA\Info(
 *     title="Get All events between time periods",
 *     version="1.0.0",
 *     description="Get All events between time periods",
 *     @OA\Contact(
 *         email="vaisakhkolathara@gmail.com"
 *     ),
 *     @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * */
class EventController extends Controller
{

    public function __construct(private ReaderServiceInterface $reader)
    {
    }

    /**
     * @OA\Get(
     *      path="/events/{userId}",
     *      operationId="getEventsByUserId",
     *      tags={"Events"},
     *      summary="Get events by user ID",
     *      description="Returns events for the specified user ID within the specified date range.",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          required=true,
     *          description="ID of the user",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="from",
     *          in="query",
     *          required=true,
     *          description="Start date of the range (eg: 'Mon 10')",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="to",
     *          in="query",
     *          required=true,
     *          description="End date of the range (eg: 'Tue 11')",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EventResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No events found",
     *      )
     * )
     */
    public function index(Request $request, int $userId)
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');
        $response = $this->reader->getEventsBetweenDates($userId, $from, $to);
        if ($response->count()) {
            return response()->json(Api::success($response->toArray($request)['data'], 'Fetched successfully!'));
        } else {
            return response()->json(Api::error('No events found', 404), 404);
        }
    }
}
