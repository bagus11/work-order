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
                    <legend>General Information</legend>
                    <div class="row">
                        <div class="col-2"><p>Category</p></div>
                        <div class="col-4"><p id="opx_category">-</p></div>
                        
                        <div class="col-2"><p>Location</p></div>
                        <div class="col-4"><p id="opx_location">-</p></div>
                        
                        <div class="col-2"><p>Created By</p></div>
                        <div class="col-4"><p id="opx_created_by">-</p></div>
                        
                        <div class="col-2"><p>Created At</p></div>
                        <div class="col-4"><p id="opx_created">-</p></div>

                        <!-- Tambahan Total Price -->
                        <div class="col-2"><p>Total Price</p></div>
                        <div class="col-4"><p id="opx_sum_price">-</p></div>
                    </div>
                  
                </fieldset>

                <h6 class="mt-3">Log in Same Month</h6>
                <table class="table table-sm table-bordered" id="opx_log_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>PPN</th>
                            <th>DPH</th>
                            <th>PPH</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                  <p class="text-right font-weight-bold mt-2">
                        Total Price: <span id="opx_log_total_price">Rp 0</span> |
                        Total PPN: <span id="opx_log_total_ppn">Rp 0</span> |
                        Total DPH: <span id="opx_log_total_dph">Rp 0</span> |
                        Total PPH: <span id="opx_log_total_pph">Rp 0</span>
                    </p>
            </div>
        </div>
    </div>
</div>
