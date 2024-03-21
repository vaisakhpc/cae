<?php

namespace App\OpenAPI;

// app/OpenAPI/UploadResponseSchema.php

/**
 * @OA\Schema(
 *     schema="UploadResponseSchema",
 *     title="UploadResponse",
 *     description="UploadResponse object",
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the response",
 *         example="success"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         description="HTTP status code",
 *         example=200
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         description="Data object containing the uploaded filename,count and user_id",
 *         @OA\Property(
 *             property="count_of_events",
 *             type="number",
 *             description="Count of events uploaded"
 *         ),
 *     @OA\Property(
 *             property="user_id",
 *             type="string",
 *             description="Id of the new/existing user"
 *         )
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Additional message",
 *         example="File uploaded successfully"
 *     )
 * )
 */


class UploadResponseSchema
{
}
