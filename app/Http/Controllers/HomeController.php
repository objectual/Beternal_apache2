<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\StateProvince;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function setCountries()
    {
        set_time_limit(1200);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "beternal";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT id, country_name, country_code FROM countries WHERE id > 1";
        $result = $conn->query($sql);

        dd($result->num_rows > 0);

        $sql = "SELECT id, name, iso2 FROM countries WHERE id > 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $country = new Country();
                $country->country_name = $row["name"];
                $country->country_code = $row["iso2"];
                $country->postal_code_format = '12345';
                $country->save();
            }
            echo 'Success';
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function setStates()
    {
        $count_state =  StateProvince::count();
        if ($count_state < 2) {
            set_time_limit(1200);
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "world";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $update_sql = "SELECT id, name, country_id FROM states WHERE id = 1";
            $result = $conn->query($update_sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $update_province = StateProvince::findOrFail(1);
                    $update_province->name = $row["name"];
                    $update_province->country_id = $row["country_id"];
                    $update_province->save();
                }
            }

            $sql = "SELECT id, name, country_id FROM states WHERE id > 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $state = new StateProvince();
                    $state->id = $row["id"];
                    $state->name = $row["name"];
                    $state->country_id = $row["country_id"];
                    $state->save();
                }
                echo 'Success';
            } else {
                echo "0 results";
            }
            $conn->close();
        }
    }

    public function setCities()
    {
        set_time_limit(1800);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "world";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $count_cities =  City::count();
        if ($count_cities == 1) {
            $update_sql = "SELECT id, name, state_id FROM cities WHERE id = 1";
            $result = $conn->query($update_sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $update_city = City::findOrFail(1);
                    $update_city->city_name = $row["name"];
                    $update_city->state_province_id = $row["state_id"];
                    $update_city->save();
                }
            }

            $sql = "SELECT id, name, state_id FROM cities";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $city = new City();
                    $city->city_name = $row["name"];
                    $city->state_province_id = $row["state_id"];
                    $city->save();
                }
                echo 'Success';
            } else {
                echo "0 results";
            }
            $conn->close();
        }

        // $cities =  City::all();
        // foreach ($cities as $city) {
        //     $city_name = $city->city_name;
        //     $id = $city->state_province_id;
        //     $sql = "INSERT INTO cities (city_name,state_province_id) VALUES ('$city_name','$id')";

        //     $add = mysqli_query($conn, $sql);
        // }
        // dd('success');
    }

    public function index()
    {
        // $title = "HOME";
        // return view('frontend.home', compact('title'));
        $title = "WELCOME";
        return view('frontend.splash.index', compact('title'));
    }

    public function contactUs()
    {
        $title = "CONTACT US";
        return view('frontend.contactUs', compact('title'));
    }

    public function splash()
    {
        $title = "WELCOME";
        return view('frontend.splash.index', compact('title'));
    }

    public function privacyPolicy()
    {
        $title = "PRIVACY POLICY";
        return view('frontend.privacyPolicy', compact('title'));
    }

    public function ourTeam()
    {

        return redirect('/');
    }

    public function ourSolution()
    {
        $title = "OUR SOLUTION";
        return view('frontend.ourSolution', compact('title'));
    }

    public function termAndConditions()
    {
        $title = "TERMS AND CONDITIONS";
        return view('frontend.termAndConditions', compact('title'));
    }

    public function helpAndSupport()
    {
        $title = "HELP AND SUPPORT";
        return view('frontend.helpAndSupport', compact('title'));
    }

    public function forgetCode()
    {
        $title = "FORGET CODE";
        return view('frontend.forgetCode', compact('title'));
    }

    public function successSignup()
    {
        $title = "SUCCESS SIGNUP";
        return view('frontend.successSignup', compact('title'));
    }

    public function survey()
    {
        $title = "HOW ARE WE DOING?";
        return view('frontend.survey', compact('title'));
    }

    public function setTimezone($user_timezone)
    {
        if ($user_timezone < 0) {
            $timezone_offset_minutes = $user_timezone - 60;
        } else {
            $timezone_offset_minutes = $user_timezone;
        }

        // Convert minutes to seconds
        $timezone_name = timezone_name_from_abbr("", $timezone_offset_minutes*60, false);
        session()->put(['user_timezone' => $timezone_name]);

        return 'success';
    }

    public function devloperTesting()
    {
        // $agent = new \Jenssegers\Agent\Agent;
   
        // $result = $agent->isMobile();
        // $result = $agent->isDesktop();
        // $result = $agent->isTablet();
        // $result = $agent->isiOS();

        // if($agent->isDesktop()) {
        //     dd('Yes desktop');
        // }

        $data = array(
            'user_name' => 'Love',
            'user_last_name' => 'Kumar'
        );

        // Mail::send('emails.testEmail', $data, function ($message) {
        //     $message->to('kumarkhatriosl2@gmail.com', 'Kumar')->subject('Test Notifications');
        //     $message->from('team@beternal.life', 'bETERNAL Team');
        // });

        dd('success');
    }
}
