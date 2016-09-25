<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Carbon\Carbon;

use App\Modules\Geo\Location as GeoLocation;
use App\Modules\Geo\EntityInterface as GeoEntity;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/ctrl/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * {@inheritdoc}
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->doVerification($request, $user);
    }

    /**
     * Do further verification.
     *
     * @param  Request $request
     * @param  User    $user
     * 
     * @return \Illuminate\Http\Response
     */
    private function doVerification(Request $request, User $user)
    {
        $geoRecord = $this->getOriginCountry();

        if ( ! ($geoRecord instanceOf GeoEntity)) {
            return $geoRecord;
        }

        $this->saveActivity($user, $geoRecord);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get user current origin country.
     * 
     * @return \App\Modules\Geo\EntityInterface || \Illuminate\Http\Response
     */
    private function getOriginCountry()
    {
        if (app()->environment('local')) {
            $_SERVER['REMOTE_ADDR'] = '180.253.234.115';
        }

        try {
            $record = $this->geoLocation()->locateByIP();
        } catch (RecordNotFoundException $e) {
            return $this->getLogout();
        }

        return $record;
    }

    /**
     * Save current user login activity.
     *
     * @param  User      $user
     * @param  GeoEntity $geoRecord
     * 
     * @return \App\Modules\User\Models\UserLoginHistory
     */
    private function saveActivity(User $user, GeoEntity $geoRecord)
    {
        $activity      = null;
        $browserInfo   = $this->browserInfo();
        $totalActivity = $user->loginActivities()->count();

        $data = [
            'user_id'               => $user->id, 
            'ip_address'            => $_SERVER['REMOTE_ADDR'], 
            'country_code'          => $geoRecord->countryCode, 
            'country_name'          => $geoRecord->countryName, 
            'os_family'             => (isset($browserInfo['osFamily'])) ? strip_tags($browserInfo['osFamily']) : '', 
            'is_mobile'             => (isset($browserInfo['isMobile'])) ? (int) $browserInfo['isMobile'] : 0, 
            'is_tablet'             => (isset($browserInfo['isTablet'])) ? (int) $browserInfo['isTablet'] : 0, 
            'is_desktop'            => (isset($browserInfo['isDesktop'])) ? (int) $browserInfo['isDesktop'] : 0, 
            'browser_family'        => (isset($browserInfo['browserFamily'])) ? strip_tags($browserInfo['browserFamily']) : '', 
            'browser_version_major' => (isset($browserInfo['browserVersionMajor'])) ? (int) $browserInfo['browserVersionMajor'] : 0, 
            'browser_version_minor' => (isset($browserInfo['browserVersionMinor'])) ? (int) $browserInfo['browserVersionMinor'] : 0, 
            'browser_version_patch' => (isset($browserInfo['browserVersionPatch'])) ? (int) $browserInfo['browserVersionPatch'] : 0, 
            'device_family'         => (isset($browserInfo['deviceFamily'])) ? strip_tags($browserInfo['deviceFamily']) : '', 
            'device_model'          => (isset($browserInfo['deviceModel'])) ? strip_tags($browserInfo['deviceModel']) : '', 
            'is_saved'              => ($totalActivity > 0) ? 0 : 1, 
            'last_activity'         => new \DateTime()
        ];

        unset($browserInfo);

        if ($totalActivity > 0) {
            // Find existing activity
            $activity = $user->loginActivities()->newQuery()
                            ->where('user_id', '=', $data['user_id'])
                            ->where('os_family', '=', $data['os_family'])
                            ->where('is_mobile', '=', $data['is_mobile'])
                            ->where('is_tablet', '=', $data['is_tablet'])
                            ->where('is_desktop', '=', $data['is_desktop'])
                            ->where('browser_family', '=', $data['browser_family'])
                            ->where('browser_version_major', '=', $data['browser_version_major'])
                            ->where('browser_version_minor', '=', $data['browser_version_minor'])
                            ->where('browser_version_patch', '=', $data['browser_version_patch'])
                            ->where('device_family', '=', $data['device_family'])
                            ->where('device_model', '=', $data['device_model'])
                            ->first();

            if (is_object($activity)) {
                $createdAt = new Carbon($activity->created_at);
                $currentAt = new Carbon();
                
                if ($createdAt->diffInDays($currentAt, false) < 30) {
                    $activity->last_activity = new \DateTime();
                    $activity->save();   
                }
            }
        }

        if ( ! is_object($activity)) {
            $activity = $user->loginActivities()->create($data);
        }

        return $activity;
    }

    /**
     * Get current browser info.
     *
     * @return Array
     */
    private function browserInfo()
    {
        // Detect the current visitor's informations.
        return \BrowserDetect::detect()->toArray();
    }

    /**
     * Get the GeoLocation instance.
     *
     * @return \Sule\Geo\Location
     */
    protected function geoLocation()
    {
        return app(GeoLocation::class);
    }
}
