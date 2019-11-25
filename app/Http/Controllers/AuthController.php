<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthController extends Controller
{
  public $client;

  public function __construct()
  {
    $this->client = new Client(['base_uri' => 'http://consultant-eai.herokuapp.com/api/']);
  }

  public function welcome()
  {
    $req = $this->client->get('register/clients');

    $resp = json_decode((string)$req->getBody());

    return view('welcome', compact('resp'));
  }

  public function login(Request $request)
  {
    $req = $this->client->post('login',[
      'form_params' => [
        'email' => $request->email,
        'password' => $request->password,
      ]
    ]);

    $resp = json_decode((string)$req->getBody());

    if ($resp->code == 200) {
      session([
        'account' => $resp->account,
      ]);

      return redirect('/dashboard');
    } elseif ($resp->code == 403) {
      $resp403 = $resp->message;
      return redirect('/')->with('status',$resp403);
    } else {
      return redirect('/')->with('status',$resp->message);
    }
  }

  public function register(Request $request)
  {
    $req = $this->client->post('register',[
      'form_params' => [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'confirmpassword' => $request->confirmpassword,
        'client_id' => $request->client_id,
      ]
    ]);

    $resp = json_decode((string)$req->getBody());

    if ($resp->code == 200) {
      return redirect('/')->with('status',$resp->message);
    } else {
      return redirect('/')->with('status',"Error Occurred, PLease Try Again Later");
    }
  }

  public function logout()
  {
    session()->flush();
    return redirect('/')->with('status',"Logged Out");
  }
}
