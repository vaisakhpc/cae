<?php

namespace App\OpenAPI;

// app/OpenAPI/EventResponse.php

/**
 * @OA\Schema(
 *     schema="EventResponseSchema",
 *     title="API Response",
 *     description="Encapsulating API response object",
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the response (eg: 'success')"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         description="HTTP status code (eg: 200)"
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/EventSchema")
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Additional message (optional)"
 *     )
 * )
 */

 class EventResponseSchema
 {
    
 }