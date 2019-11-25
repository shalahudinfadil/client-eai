<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public $client;

    public function __construct()
    {
      $this->client = new Client(['base_uri' => 'http://consultant-eai.herokuapp.com/api/']);
    }

    public function dashboard()
    {
      return view('dashboard');
    }

    public function ticket()
    {
      return view('ticket');
    }

    public function getClientTickets()
    {
      $req = $this->client->post('tickets/client',[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());

      return $resp->data;
    }

    public function getPICTickets()
    {
      $req = $this->client->post('tickets/pic',[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());

      return $resp->data;
    }

    public function getTicket($id)
    {
      $req = $this->client->post('ticket/'.$id,[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());
      $ticket = $resp->data;

      return view('view_ticket', compact('ticket'));
    }

    public function newTicket()
    {
      $req = $this->client->post('modul',[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());
      $modul = $resp->data;

      return view('new_ticket', compact('modul'));
    }

    public function getSubmodules($id)
    {
      $req = $this->client->post('submodul/'.$id,[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());

      return $resp->data;
    }

    public function postTicket(Request $request)
    {
      $multipart = [
        [
          'name' => 'modul_id',
          'contents' => $request->modul_id,
        ],
        [
          'name' => 'submodul_id',
          'contents' => $request->submodul_id,
        ],
        [
          'name' => 'priority',
          'contents' => $request->priority,
        ],
        [
          'name' => 'title',
          'contents' => $request->title,
        ],
        [
          'name' => 'message',
          'contents' => $request->message,
        ],
        [
          'name' => 'id',
          'contents' => session('account')->id,
        ],
        [
          'name' => 'client_id',
          'contents' => session('account')->client_id,
        ],
        [
          'name' => 'token',
          'contents' => session('account')->token,
        ],
      ];

      if ($request->hasFile('images.0')) {
        $cloudder = [];
        foreach ($request->file('images') as $key => $image) {
          \Cloudder::upload($image[0],null);
          $cloudder = [\Cloudder::getPublicId()];
        }
        $multipart[] = [
          'name' => 'img_links',
          'contents' => json_encode($cloudder),
        ];
      }

      $req = $this->client->post('ticket/create',[
        'multipart' => $multipart,
      ]);

      $resp = json_decode((string)$req->getBody());



      return redirect('/ticket')->with('status',$resp->success);

    }

    public function updateInfo(Request $request)
    {
      $req = $this->client->post('profile/update',[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
          'email' => $request->email,
          'name' => $request->name,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());

      session()->flush();
      session([
        'account' => $resp->account,
      ]);

      return redirect()->back()->withSucess($resp->message);
    }

    public function changePassword(Request $request)
    {
      $req = $this->client->post('profile/password',[
        'form_params' => [
          'token' => session('account')->token,
          'id' => session('account')->id,
          'password' => $request->password,
          'confirmpassword' => $request->confirmpassword,
        ]
      ]);

      $resp = json_decode((string)$req->getBody());

      return redirect()->back()->withSucess($resp->message);
    }
}
