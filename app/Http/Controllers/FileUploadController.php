<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParserServiceInterface;
use App\Services\PersisterServiceInterface;
use App\Http\Resources\ApiResponse;

class FileUploadController extends Controller
{
    public function __construct(
        private ParserServiceInterface $parser,
        private PersisterServiceInterface $persister,
    ) {
    }

    /**
     * @OA\Post(
     *      path="/upload/",
     *      operationId="uploadCrewDTRForUser",
     *      tags={"Upload"},
     *      summary="Upload the schedule for a crew member",
     *      description="Upload the schedule for a crew member.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="File to upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"file"},
     *                  @OA\Property(
     *                      property="file",
     *                      description="File to upload",
     *                      type="string",
     *                      format="binary"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UploadResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No file uploaded",
     *      )
     * )
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $contentFromFile = $file->getContent();
            $parsedData = $this->parser->parseDocument($contentFromFile, $file->getClientOriginalExtension());
            if (!isset($parsedData['error'])) {
                $details = $this->persister->saveEntries($parsedData);
            } else {
                return response()->json(ApiResponse::error($parsedData['message'], 400), 400);
            }

            return response()->json(ApiResponse::success($details, 'File uploaded successfully', 200), 200);
        } else {
            return response()->json(ApiResponse::error('No file uploaded', 400), 400);
        }
    }
}
