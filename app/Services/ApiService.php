<?php
  
namespace App\Services;
  
use Illuminate\Support\Facades\Http;
  
class APIService
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function getData(int $records, string $primary_api_url, string $fallback_api_url)
    {        
        $primary_api_url .= '/?results='.$records;

        $userResponse = Http::get($primary_api_url);

        $success = true;

        //we have received a response

        if( $userResponse->status() == 200 )
        {
            $userJsonData = $userResponse->json();

           //no error
            if( !isset($userJsonData['error']) )
            {
                $arrUser = [];

                if( !empty($userJsonData['results']) )
                {
                    foreach($userJsonData['results'] as $key => $data)
                    {
                        $arrUser[$key]['gender'] = $data['gender'];
                        $arrUser[$key]['name'] = $data['name'];
                        $arrUser[$key]['address'] = $data['location'];
                        $arrUser[$key]['email_id'] = $data['email'];
                        $arrUser[$key]['dob'] = $data['dob']['date'];
                        $arrUser[$key]['age'] = $data['dob']['age'];
                        $arrUser[$key]['registration_date'] = $data['registered']['date'];
                        $arrUser[$key]['phone'] = $data['phone'];
                        $arrUser[$key]['cell'] = $data['cell'];
                        $arrUser[$key]['profile_pictures'] = $data['picture'];
                    }
                }

               $users = $arrUser;
            }
            else
            {
                $success = false;
            }          
        }
        else
        {
            $success = false;
        }   

        if($success)
        {
            return json_encode(['users_data' => $users]);
        }

        if( !$success )
        {
            $activityResponse = Http::get($fallback_api_url);
            if( $activityResponse->status() == 200 )
            {
                $activityJsonData = $activityResponse->json();                
                return json_encode(['activity_data' => $activityJsonData]);
            }
        }

        return json_encode(['no_data' => true]);        
    }
}