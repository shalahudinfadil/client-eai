@extends('layout')

@section('title','View Ticket')

@section('content')
  <div class="container-fluid py-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h4 class="text-center">Ticket #{{$ticket->number}}</h4>
        <hr>
        <table class="table table-bordered">
          <tr>
            <td>Module - Submodule</td>
            <td>{{$ticket->moduls->name}} - {{$ticket->submoduls->name}}</td>
          </tr>
          <tr>
            <td>Priority</td>
            <td>{!! $ticket->priority !!}</td>
          </tr>
          <tr>
            <td>Status</td>
            <td>{{ $ticket->status }}</td>
          </tr>
          <tr>
            <td>Sender</td>
            <td>{{$ticket->pics->name}}</td>
          </tr>
          <tr>
            <td>Title</td>
            <td>{{$ticket->title}}</td>
          </tr>
          <tr>
            <td>Message</td>
            <td>{{$ticket->message}}</td>
          </tr>
          <tr>
            <td>Attached Image(s)</td>
            <td>
              @if ($ticket->img_links != null)
                <div class="row justify-content-left">
                  @foreach ($ticket->img_links as $key => $img_link)
                    <div class="col-md-3 p-3">
                      <div class="card">
                        <a data-fancybox="gallery" href="{{\Cloudder::secureShow($img_link)}}"><img class="img-thumbnail" src="{{\Cloudder::secureShow($img_link)}}"></a>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                No Image Attached
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
@endsection
