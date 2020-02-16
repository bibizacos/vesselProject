<?php
/**
 * Created by PhpStorm.
 * User: bibiz
 * Date: 16-Feb-20
 * Time: 3:45 PM
 */

namespace App\Http\Resources;


use App\Vessels;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiV1 extends JsonResource
{

    /**
     * ApiV1 response
     * @param $mmsis
     * @param $latitudeRange
     * @param $longitudeRange
     * @param $timeStampRange
     * @return \Illuminate\Support\Collection
     */
    public static function getVessels($mmsis, $latitudeRange, $longitudeRange, $timeStampRange)
    {
        $results = [];
        $collection = collect();
        $collection['errors'] = [
            'status' => 200,
            'message' => 'OK'
        ];
        if (is_array($mmsis)) {
            foreach ($mmsis as $index => $mmsi) {
                $results[$mmsi] = Vessels::where('mmsi', $mmsi)
                    ->whereBetween('lon', $longitudeRange)
                    ->whereBetween('lat', $latitudeRange)
                    ->whereBetween('timestamp', $timeStampRange)
                    ->get();
            }
        } else {
            $results[$mmsis] = Vessels::where('mmsi', $mmsis)
                ->whereBetween('lon', $longitudeRange)
                ->whereBetween('lat', $latitudeRange)
                ->whereBetween('timestamp', $timeStampRange)
                ->get();
        }
        $collection['data'] = $results;
        return $collection;
    }
}