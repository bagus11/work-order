<style>
    :root{
        /* --primary-color:rgb(40, 158, 197); */
        --primary-color:#03C988;

    }
    *,
    *::before,
    *::after{
        box-sizing: border-box
    }
       @keyframes animate{
        from{
            transform: scale(1,0);
            opacity: 0;
        }to{
            transform: scale(1,1);
            opacity: 1;
        }
    }
    .form-step{
        display: none;
        transform-origin: top;
        animation: animate 0.5s;
        /* transition: animate 0.5s; */
    }
    .form-step-active{
        display: block;
    }
    .progressbar{
        position: relative;
        display: flex;
        justify-content: space-between;
        counter-reset: step;
        margin: 2rem 0 4rem;
    }
    .progress-step{
        width   : 2.1875rem;
        height  : 2.1875rem;
        background-color: #dcdcdc;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
    }
    .progress-step::before{
        counter-increment: step;
        content:counter(step);

    }
    .progressbar::before, .progress{
        content: "";
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        width: 100%;
        background-color: #dcdcdc;
        counter-reset: step;
        
    }
    .progress{
        background-color: var(--primary-color);
        width: 0%;
        transition: 0.5s;
    }
    .progress-step::after{
        content: attr(data-title);
        position: absolute;
        top: calc(100% + 0.5rem);
        font-size: 0.75rem;
        color: #666666;

    }
    .progress-step-active{
        background-color: var(--primary-color);
        color: #f3f3f3;
    }
</style>
<div class="modal fade" id="detailWO">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Detail Work Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="card card-dark card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Comment</a>
                                    </li>
                                
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    {{-- Status Steper --}}
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">  
                                        <div class="containerpx-8">
                                            <div class="row" style="margin-top:-30px">
                                                <div class="container" style="width: 40%; min-width:300px;margin:0 auto">
                                                    <div class="progressbar mt-6">
                                                        <div class="progress" id="progress">
                                        
                                                        </div>
                                                        <div class="progress-step progress-step-active" data-title="Created"></div>
                                                        <div class="progress-step" data-title="Responded"></div>
                                                        <div class="progress-step" data-title="Fixed"></div>
                                                        <div class="progress-step" data-title="Closed"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Request By</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                    <input type="hidden" class="form-control" id="wo_id_detail" >
                                                    <input type="hidden" class="form-control" id="requestCodeWo" >
                                                   <span id="username_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Request Code</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                  <span id="request_code_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Request Type</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                    <span for="" id="select_request_type_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Categories</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                    <span id="select_categories_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Problem Type</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                  <span for="" id="select_problem_type_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Subject</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                  <span id="subject_detail"></span>
                                                </div>
                                           
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Status</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                   <label for="" id="status_wo_detail"></label>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">PIC</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                   <label for="" id="pic_wo_detail"></label>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Additional Info</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-10  mt-2">
                                                  <span for="" id="add_info_detail"></span>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Attachment User</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                        <div id="attachment_user_detail"></div>
                                                </div>
                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                    <label for="">Attachment PIC</label>
                                                </div>
                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                        <div id="attachment_pic_detail">
                                                            <span>:-</span>
                                                        </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="form-step form-step-active">
                                            <table class="datatable-stepper" id="stepperTable" style="margin-top:-10px">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center" colspan="2">Created By</th>
                                                        <th style="text-align:center" colspan="2">Responded By</th>
                                                        <th style="text-align:center" colspan="2">Fixed By</th>
                                                        <th style="text-align:center" colspan="2">Closed By</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Date</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Name</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Date</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Name</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Date</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Name</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Date</th>
                                                        <th style="text-align:center;width:12%;padding: 10px 40px 10px 40px">Name</th>
                                                    </tr>
                                                </thead>
                                            </table>  
                                        </div>
                                    </div>
                                    {{-- End Status Steper --}}
                                    {{-- Detail --}}
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="direct-chat-messages" id="logMessage">
    
                                                    </div>   
                                                </div>
                                            </div>
                                    </div>
                                    {{-- End Detail --}}
                                </div>
                            </div>
                        </div>
                          
            
            </div>
           
            <div class="modal-footer justify-content-end">
            </div>
        </div>
    </div>
</div>