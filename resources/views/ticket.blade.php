@extends('layout')

@section('title','Ticket')

@section('content')
  <div class="container-fluid py-2">
    <div class="row justify-content-center">
      <div class="col-md-10 text-center">
        <h4>Tickets</h4>
      </div>
      <div class="col-md-2 text-center">
        <a href="/new" class="btn btn-primary">
          <i class="fa fa-plus-circle" aria-hidden="true"></i> New Ticket
        </a>
      </div>
      <div class="col-md-12 pt-3 pr-2 text-center">
        @if (session('status'))
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <div class="form-group">
          <select class="form-control" id="filter">
            <option value="1" selected>All Tickets</option>
            <option value="2">Your Tickets</option>
          </select>
        </div>
        <table id="ticketTable" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Loading -->
  <div class="modal fade bd-example-modal-sm" id="loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <i class="fa fa-circle-o-notch fa-spin align-middle" style="font-size:24px"></i> Please Wait...
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script type="text/javascript">
    var table = $('#ticketTable');
    var filter = $('#filter');
    var timeout;
    var id;

    function getTickets(id) {
      if (id == 1) {
        $.get('/tickets/client',function(resp) {
          table.clear().draw();
          table.rows.add(resp).draw();
        });
      } else {
        $.get('/tickets/pic',function(resp) {
          table.clear().draw();
          table.rows.add(resp).draw();
        });
      }
      timeout = setTimeout(function () {
        getTickets(id)
      }, 5000);
      $('#loading').modal('hide');
    };

    $(document).ready(function() {
      table = $('#ticketTable').DataTable({
        serverSide: false,
        processing: true,
        paging: true,
        language: {
            emptyTable: "No Ticket Found"
        },
        data: [],
        columns: [
          {data: 'number'},
          {data: 'title'},
          {data: 'priority'},
          {data: 'status'},
          {data: 'created_at'},
        ]
      });

      $('#ticketTable').on('click', 'tbody tr', function() {
        var id = table.row(this).data()['id'];
        window.location.href = '/ticket/'+id;
      });

      getTickets(filter.val());

      filter.on('change',function() {
        $('#loading').modal('show');
        clearTimeout(timeout);
        getTickets(filter.val());
      });

    });
  </script>
@endpush
