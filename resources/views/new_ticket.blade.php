@extends('layout')

@section('title','New Ticket')

@section('content')
  <div class="container-fluid py-2">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h4>New Ticket</h4>
        <hr>
        <form action="/new" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row justify-content-center">
            <div class="col-md-4">
              <div class="form-group">
                <label for="module">Module</label>
                <select class="form-control" name="modul_id" id="modul" required>
                  <option value="">--Select Module--</option>
                  @foreach ($modul as $element)
                    <option value="{{$element->id}}">{{$element->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="submodule">Submodule</label>
                <select class="form-control" name="submodul_id" id="submodul" required disabled>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="priority">Priority</label>
              <select class="form-control" name="priority" required>
                <option value="">--Select Priority--</option>
                <option value="1">Low</option>
                <option value="2">Medium</option>
                <option value="3">High</option>
              </select>
            </div>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" class="form-control" placeholder="Ticket Title" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea name="message" class="form-control" placeholder="Ticket Message" rows="8" cols="80" required></textarea>
            </div>
          </div>
          <p>Attach Image(s)</p>
          <div class="input-images pb-4">
          </div>
          <button type="submit" class="btn btn-block btn-primary" name="button">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
             New Ticket
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script type="text/javascript">
    $(document).ready(function(){
      $('.input-images').imageUploader({
        imagesInputName: 'images[]',
      });

      $('select').select2();

      $('#modul').on('change',function(){
        $('#submodul option').remove();
        var id = $(this).val();
        if(id != "") {
          $.get('/submodul/'+id, function(resp){
            $('#submodul').prop('disabled',false);
            $.each(resp,function(k,v){
              $('#submodul').append($('<option>', {
                value: v['id'],
                text: v['name'],
              }));
            });
          });
        } else {
          $('#submodul').prop('disabled',true);
          $('#submodul option').remove();
        }
      });
    });
  </script>
@endpush
