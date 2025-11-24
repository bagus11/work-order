<!-- Modal Detail OPX -->
<div class="modal fade" id="infoOPXModal" tabindex="-1" role="dialog" aria-labelledby="infoOPXModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="detailOPXModalLabel">Detail OPX</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <strong style="font-size: 12px">General Information</strong>
                    <div class="row">
                        <div class="col-2"><p>Category</p></div>
                        <div class="col-4"><p id="opx_category">-</p></div>
                        
                        <div class="col-2"><p>Location</p></div>
                        <div class="col-4"><p id="opx_location">-</p></div>
                        
                        <div class="col-2"><p>Created By</p></div>
                        <div class="col-4"><p id="opx_created_by">-</p></div>
                        
                        <div class="col-2"><p>Created At</p></div>
                        <div class="col-4"><p id="opx_created">-</p></div>
                    </div>
                      <h6>Log in Same Month</h6>
                      <div class="row">
                        <div class="col-12">
                            <table class="datatable-bordered nowrap display" id="opx_log_table">
                               <thead>
                                   <tr>
                                       <th>#</th>
                                       <th>Category</th>
                                       <th>Product</th>
                                       <th>Description</th>
                                       <th>Price</th>
                                       <th>PPN</th>
                                       <th>DPH</th>
                                       <th>PPH</th>
                                       <th>Created At</th>
                                   </tr>
                               </thead>
                               <tbody></tbody>
                           </table>

                        </div>
                      </div>
                      <p class="text-right font-weight-bold p-0 mt-2">
                            Total Price: <span id="opx_log_total_price">Rp 0</span> |
                            Total PPN: <span id="opx_log_total_ppn">Rp 0</span> |
                            Total DPH: <span id="opx_log_total_dph">Rp 0</span> |
                            Total PPH: <span id="opx_log_total_pph">Rp 0</span>
                        </p>
                </fieldset>
            </div>
        </div>
    </div>
</div>
