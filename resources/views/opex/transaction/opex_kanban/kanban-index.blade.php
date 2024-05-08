@extends('rfp.layout.master_rfp')
@section('title', 'Detail RFP')
@section('content')


    <div class="justify-content-center row">
      <input type="hidden" id="request_code" value="{{$request_code}}" >
          <div class="mt-4 mx-4">
            <div id="kanban-board" class="row">
              <div id="todo" class="col kanban-column">
                <div class="card mb-3">
                  <div class="card-header bg-info">
                    To Do
                  </div>
                  <div class="card-body kanban-cards" id="kanban_new">
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
          
              <div id="in-progress" class="col kanban-column">
                <div class="card  mb-3">
                  <div class="card-header bg-warning">
                    In Progress
                  </div>
                  <div class="card-body kanban-cards" id="kanban_progress">
               
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
          
              <div id="pending" class="col kanban-column">
                <div class="card mb-3">
                  <div class="card-header bg-dark">
                    Pending
                  </div>
                  <div class="card-body kanban-cards" id="kanban_pending">
                
                  </div>

                  
                  <div class="card-footer"></div>
                </div>
              </div>
         

          <div id="done" class="col kanban-column">
            <div class="card mb-3">
              <div class="card-header bg-success">
                Done
              </div>
              <div class="card-body kanban-cards" id="kanban_done">
              
              </div>

              
              <div class="card-footer"></div>
            </div>
          </div>
        
</div>
          
    </div>
    <style>
      .kanban-column{
        min-width: 300px !important;
      }
      .card{
        border-radius: 15px !important;
      }
      .card-header{
        border-radius: 15px 15px 15px 15px; 
      }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" integrity="sha512-MrA7WH8h42LMq8GWxQGmWjrtalBjrfIzCQ+i2EZA26cZ7OBiBd/Uct5S3NP9IBqKx5b+MMNH1PhzTsk6J9nPQQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    @include('rfp.rfp_kanban.modal.detail_rfp')
@endsection
@push('custom-js')
@include('rfp.rfp_kanban.rfp-js')
@endpush