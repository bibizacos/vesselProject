<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiV1;
use App\RequestedUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\VarDumper\VarDumper;

class TrackerController extends Controller
{

    protected static $MAX_REQUESTED_NUMBER = 10;

    protected $type;
    protected $mmsis;
    protected $latitudeRange;
    protected $longitudeRange;
    protected $timeStampRange;

    public function __construct(Request $request)
    {
        $this->type = Input::get('type');
        $this->mmsis = Input::get('mmsi');
        $this->latitudeRange = [Input::get('minLat'), Input::get('maxLat')];
        $this->longitudeRange = [Input::get('minLon'), Input::get('maxLon')];
        $this->timeStampRange = [Input::get('minTstamp'), Input::get('maxTstamp')];
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function resolveMethod(Request $request)
    {
        if (!$this->isRequestValid($request)) {
            return response(['error' => ' Service unavailable'], 503)
                ->header('Content-Type', 'application/json');
        }
        if ($this->type == 'application/json') {
            return $this->asJson($request);
        }
        if ($this->type == 'application/xml') {
            return $this->asXml($request);
        }
        if ($this->type == 'text/csv') {
            return $this->asCsv($request);
        }
        return response(['error' => 'invalid content Content-Type'], 415)
            ->header('Content-Type', 'application/json');
    }


    /**
     *  Return api response as json
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function asJson(Request $request)
    {
        $this->pushLog('REQUEST:', [$request->fullUrl()]);
        $apiV1Response = ApiV1::getVessels($this->mmsis, $this->latitudeRange, $this->longitudeRange, $this->timeStampRange);
        $this->pushLog('RESPONSE:', $apiV1Response->all());
        return response($apiV1Response->toJson(), 200)
            ->header('Content-Type', 'application/json');
    }


    /**
     *  Return api response as Csv
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function asCsv(Request $request)
    {
        //TODO
    }


    /**
     *  Return api response as Xml
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function asXml(Request $request)
    {
        //TODO
    }


    /**
     *
     * Push logs to log file ../storage/logs/api.log
     * @param $name
     * @param $log
     * @throws \Exception
     */
    protected function pushLog($name, $log)
    {
        $logger = new Logger(ApiV1::class);
        $logger->pushHandler(new StreamHandler('../storage/logs/api.log', Logger::DEBUG));
        $logger->addDebug($name, $log);
    }


    /**
     * Check if use requests are lower than 10 & update tale users
     * @param Request $request
     * @return bool
     */
    protected function isRequestValid(Request $request)
    {
        $isRequestValid = false;
        $user = RequestedUsers::where('ip', $request->ip())->first();
        if (is_null($user)) {
            $isRequestValid = true;
            RequestedUsers::create(['ip' => $request->ip(), 'requests' => 1, 'updated_at' => now(), 'created_at' => now()]);
        } else {
            $requestedTstamp = strtotime($user->updated_at);
            $requestedDate = date('Y-m-d', $requestedTstamp);
            $requestedHour = date('H', $requestedTstamp);
            $currentTstamp = strtotime(now());
            $currentDate = date('Y-m-d', $currentTstamp);
            $currentHour = date('H', $currentTstamp);
            if ($requestedDate == $currentDate AND $requestedHour == $currentHour AND $user->requests > self::$MAX_REQUESTED_NUMBER) {
                RequestedUsers::where('ip', $request->ip())->update(['ip' => $request->ip(), 'requests' => $user->requests + 1, 'updated_at' => now()]);
            } else {
                RequestedUsers::where('ip', $request->ip())->update(['ip' => $request->ip(), 'requests' => $user->requests + 1, 'updated_at' => now()]);
                $isRequestValid = true;
            }

        }
        return $isRequestValid;
    }


}
