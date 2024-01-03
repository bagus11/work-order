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
            <div class="modal-header bg-core">
                Detail Work Order
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
                                          
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            Detail Ticket
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <p for="">Request By</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                    <input type="hidden" class="form-control" id="wo_id_detail" >
                                                                    <input type="hidden" class="form-control" id="requestCodeWo" >
                                                                   <p id="username_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Request Code</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                  <p id="request_code_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Request Type</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                    <p for="" id="select_request_type_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Categories</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                    <p id="select_categories_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Problem Type</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                  <p for="" id="select_problem_type_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Subject</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                  <p id="subject_detail"></p>
                                                                </div>
                                                           
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Status</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                   <p for="" id="status_wo_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">PIC</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                   <p for="" id="pic_wo_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Additional Info</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-10  mt-2">
                                                                  <p for="" id="add_info_detail"></p>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Attachment User</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                        <div id="attachment_user_detail"></div>
                                                                </div>
                                                                <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                    <p for="">Attachment PIC</p>
                                                                </div>
                                                                <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                        <div id="attachment_pic_detail">
                                                                            <p>:-</p>
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
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="form-group row ">
                                            <div class="col-md-12 mx-auto">
                                                @can('viewOldTicket-work_order_list')
                                                <div class="card collapsed-card" id="oldTicketContainer">
                                                    <div class="card-header">
                                                        Old Ticket
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Request By</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketRequestBy"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Request Code</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketRequestCode"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Request Type</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketRequestType"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Categories</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketCategories"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Problem Type</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketProblemType"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Subject</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketSubject"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Additional Info</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-10  mt-2">
                                                                <span id="oldTicketAdditionalInfo"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>PIC</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-10  mt-2">
                                                                <span id="oldTicketPIC"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Attachment User</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketAttachmentUser"></span>
                                                            </div>
                                                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                                                <p>Attachment PIC</p>
                                                            </div>
                                                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                                                <span id="oldTicketAttachmentPIC"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            </div>
                                           </div>
                                        </div>
                                        
                                        
                                    </div>
                                    {{-- End Status Steper --}}
                                    {{-- Detail --}}
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-12">
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