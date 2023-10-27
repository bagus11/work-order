

<div class="modal fade" id="importMasterCategory">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Form Upload Category
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="your_path" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 mt-2">
                            <p>Type Id</p>
                        </div>
                        <div class="col-md-1 mt-2"  style="margin-left: -30px">
                            <p>:</p>
                        </div>
                        <div class="col-md-6 mt-2" style="margin-left: -20px">
                            <div class="row">
                                <div class="col-6">
                                    <p>1.Aset</p>
                                </div>
                            </div>
                            <div class="row" style="margin-top: -10px">
                                <div class="col-6">
                                    <p>2.Consumable</p>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="datatable-stepper nowrap display">
                                <thead>
                                    <tr>
                                        <th colspan="4">Import Format</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td style="width:20%;font-weight:bold">Column Name</td>
                                    <td style="text-align: center">Type ID</td>
                                    <td style="text-align: center">Category Name</td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;font-weight:bold">Type </td>
                                        <td style="text-align: center">Integer</td>
                                        <td style="text-align: center">Varchar (255)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer"> 
                                <a class="btn btn-info btn-sm" title="Download Format" href="{{asset('storage/upload/UploadMasterCategory.xlsx')}}" id="downloadFormat" style="float: right">
                                    <i class="fas fa-download"></i>
                                </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mt-2">
                            <p>File</p>
                        </div>
                        <div class="col-md-10 mt-2">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control-file" id="upload_file" style="font-size: 10px">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_upload" type="submit" title="Upload Category" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-upload"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>