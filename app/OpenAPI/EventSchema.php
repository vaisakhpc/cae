<?php

namespace App\OpenAPI;

// app/OpenAPI/EventSchema.php

/**
 * @OA\Schema(
 *     schema="EventSchema",
 *     title="Event",
 *     description="Event object",
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         description="Date of the event (eg: 'Sat 15')"
 *     ),
 *     @OA\Property(
 *         property="checkin",
 *         type="string",
 *         description="Check-in time (eg: '0500')"
 *     ),
 *     @OA\Property(
 *         property="checkout",
 *         type="string",
 *         nullable=true,
 *         description="Check-out time (nullable)"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description="Event code"
 *     ),
 *     @OA\Property(
 *         property="activity",
 *         type="string",
 *         nullable=true,
 *         description="Activity description (nullable)"
 *     ),
 *     @OA\Property(
 *         property="remark",
 *         type="string",
 *         nullable=true,
 *         description="Remark (nullable)"
 *     ),
 *     @OA\Property(
 *         property="from",
 *         type="string",
 *         nullable=true,
 *         description="From location (nullable)"
 *     ),
 *     @OA\Property(
 *         property="std",
 *         type="string",
 *         nullable=true,
 *         description="STD (nullable)"
 *     ),
 *     @OA\Property(
 *         property="to",
 *         type="string",
 *         nullable=true,
 *         description="To location (nullable)"
 *     ),
 *     @OA\Property(
 *         property="sta",
 *         type="string",
 *         nullable=true,
 *         description="STA (nullable)"
 *     ),
 *     @OA\Property(
 *         property="hotel",
 *         type="string",
 *         nullable=true,
 *         description="Hotel information (nullable)"
 *     ),
 *     @OA\Property(
 *         property="blh",
 *         type="string",
 *         nullable=true,
 *         description="BLH (nullable)"
 *     ),
 *     @OA\Property(
 *         property="flight_time",
 *         type="string",
 *         nullable=true,
 *         description="Flight time (nullable)"
 *     ),
 *     @OA\Property(
 *         property="duration",
 *         type="string",
 *         nullable=true,
 *         description="Duration (nullable)"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         description="Creation date (eg: '2024-03-20')"
 *     )
 * )
 */


 class EventSchema
 {
    
 }