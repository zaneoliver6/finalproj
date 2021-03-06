<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;

class DashboardController extends Controller
{
  public function __construct() {
      $this->middleware('auth');

      if(Auth::User() != null) {
        if(Auth::User()->role == 3) {
          Redirect::to('/dashboard/customer')->send();
        }

        if(Auth::User()->active == 0) {
          Redirect::to('/auth/logout')->send();
        }
      }
  }

  public function index() {
    $currUser = Auth::User();
    $numReq = Requests::where('clientid', Auth::User()->client->id)->count();
    $cusCount = User::where('active', 1)->where('clientid', $currUser->clientid)->count();
    return view('dashboard.index',
              array('title' => 'DashBoard',
              'sub' => $currUser->client->companyName,
              'user' => $currUser,
              'cusCount' => $cusCount,
              'numReq' => $numReq
            ));
  }
}

?>
