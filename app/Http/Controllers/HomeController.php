<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\StateProvince;
use App\Models\City;

class HomeController extends Controller
{
    // public function setCountries()
    // {
    //     $servername = "localhost";
    //     $username = "root";
    //     $password = "";
    //     $dbname = "world";

    //     $conn = mysqli_connect($servername, $username, $password, $dbname);
    //     if (!$conn) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }

    //     $sql = "SELECT id, name, iso2 FROM countries";
    //     $result = $conn->query($sql);

    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $country = new Country();
    //             $country->country_name = $row["name"];
    //             $country->country_code = $row["iso2"];
    //             $country->save();
    //         }
    //         echo 'Success';
    //     } else {
    //         echo "0 results";
    //     }
    //     $conn->close();
    // }

    // public function setStates()
    // {
    //     $servername = "localhost";
    //     $username = "root";
    //     $password = "";
    //     $dbname = "world";

    //     $conn = mysqli_connect($servername, $username, $password, $dbname);
    //     if (!$conn) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }

    //     $sql = "SELECT id, name, country_id FROM states";
    //     $result = $conn->query($sql);

    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $state = new StateProvince();
    //             $state->id = $row["id"];
    //             $state->name = $row["name"];
    //             $state->country_id = $row["country_id"];
    //             $state->save();
    //         }
    //         echo 'Success';
    //     } else {
    //         echo "0 results";
    //     }
    //     $conn->close();
    // }

    // public function setCities()
    // {
    //     $servername = "localhost";
    //     $username = "root";
    //     $password = "";
    //     $dbname = "world";

    //     $conn = mysqli_connect($servername, $username, $password, $dbname);
    //     if (!$conn) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }

    //     $sql = "SELECT id, name, state_id FROM cities WHERE country_id BETWEEN 201 AND 250;";
    //     $result = $conn->query($sql);

    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $city = new City();
    //             $city->city_name = $row["name"];
    //             $city->state_province_id = $row["state_id"];
    //             $city->save();
    //         }
    //         echo 'Success';
    //     } else {
    //         echo "0 results";
    //     }
    //     $conn->close();
    // }

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
}
