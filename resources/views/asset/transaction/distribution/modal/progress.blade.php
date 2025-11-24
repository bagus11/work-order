
<div class="modal fade" id="progressModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Confirmation Asset Progress </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form class="form" id="progress_form" enctype="multipart/form-data">
           <div class="modal-body p-0 mx-2 mb-2">

                <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="progressTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="software-tab" data-toggle="tab" href="#softwareTab" role="tab" aria-controls="softwareTab" aria-selected="true">
                        Software Information
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="confirmation-tab" data-toggle="tab" href="#confirmationTab" role="tab" aria-controls="confirmationTab" aria-selected="false">
                        Confirmation Form
                    </a>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content mt-3" id="progressTabContent">

                <!-- Software Information -->
                <div class="tab-pane fade show active" id="softwareTab" role="tabpanel" aria-labelledby="software-tab">
                    <div id="software_container"></div>
                </div>

                <!-- Confirmation Form -->
                <div class="tab-pane fade" id="confirmationTab" role="tabpanel" aria-labelledby="confirmation-tab">
                    <fieldset class="p-3 border rounded">
                        <legend class="w-auto px-2">Confirmation Form</legend>
                        <div class="row mb-2">
                            <div class="col-2 mt-2">
                                <p>Notes</p>
                            </div>
                            <div class="col-10">
                                <textarea name="ict_notes_progress" class="form-control mb-2" id="ict_notes_progress" cols="30" rows="10"></textarea>
                                <span style="color:red;font-size:9px" class="message_error text-red block ict_notes_progress_error"></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 mt-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-4">
                                <input type="file" class="form-control" id="ict_progress_attachment">
                                <span style="color:red;font-size:9px" class="message_error text-red block ict_progress_attachment_error"></span>
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <button class="btn btn-sm btn-success" id="btn_progress_asset" type="submit">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </fieldset>
                </div>

            </div>


                <!-- Tabs Content -->
                <div class="tab-content mt-3" id="progressTabContent">

                    <!-- Software Information -->
                    <div class="tab-pane fade show active" id="softwareTab" role="tabpanel" aria-labelledby="software-tab">
                            <div id="software_container"></div>
                    </div>

                    <!-- Confirmation Form -->
                    <div class="tab-pane fade" id="confirmationTab" role="tabpanel" aria-labelledby="confirmation-tab">
                        <fieldset class="p-3 border rounded">
                            <legend class="w-auto px-2">Confirmation Form</legend>
                            <div class="row mb-2">
                                <div class="col-2 mt-2">
                                    <p>Notes</p>
                                </div>
                                <div class="col-10">
                                    <textarea name="ict_notes_progress" class="form-control mb-2" id="ict_notes_progress" cols="30" rows="10"></textarea>
                                    <span style="color:red;font-size:9px" class="message_error text-red block ict_notes_progress_error"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2 mt-2">
                                    <p>Attachment</p>
                                </div>
                                <div class="col-4">
                                    <input type="file" class="form-control" id="ict_progress_attachment">
                                    <span style="color:red;font-size:9px" class="message_error text-red block ict_progress_attachment_error"></span>
                                </div>
                            </div>
                            <div class="mt-2 text-end">
                                <button class="btn btn-sm btn-success" id="btn_progress_asset" type="submit">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </fieldset>
                    </div>

                </div>
            </div>

        </form>
        </div>
    </div>
</div>

<style>
    #progressModal .modal-body {
    max-height: 70vh; /* atur sesuai kebutuhan */
    overflow-y: auto;
}

</style>