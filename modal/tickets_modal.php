
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-success">
                    <h5 class="modal-title text-white " id="exampleModalLabel">Ticket Add&nbsp;&nbsp;<i class="mdi mdi-account-plus"></i></h5>
                    
                </div>
                <form action="include/tickets_server.php?add_ticket_data=true" method="POST" id="ticket_modal_form">
                    <div class="modal-body">
                        <div class="from-group mb-2">
                            <label>Customer Name</label>
                            <select class="form-select" name="customer_id" id="ticket_customer_id" style="width: 100%;"></select>
						</div>
                        <div class="from-group mb-2">
                            <label for="">Ticket For</label>
                            <select id="ticket_for" name="ticket_for" class="form-select" required>
                                <option value="Home Connection">Home Connection</option>
                                <option value="POP">POP Support</option>
                                <option value="Corporate">Corporate</option>
                                
                            </select>
                        </div>
                        <div class="from-group mb-2">
                            <label for=""> Complain Type </label>
                            <select id="ticket_complain_type" name="ticket_complain_type" class="form-select" style="width: 100%;" ></select>

                        </div>
                        <div class="from-group mb-2">
                            <label for="">Ticket Priority</label>
                            <select id="ticket_priority" name="ticket_priority" type="text" class="form-select" style="width: 100%;">
                            <option >---Select---</option>
                            <option value="1">Low</option>
                            <option value="2">Normal</option>
                            <option value="3">Standard</option>
                            <option value="4">Medium</option>
                            <option value="5">High</option>
                            <option value="6">Very High</option>
                            </select>
						</div>
                        <div class="from-group mb-2">
                            <label for="">Assigned To</label>
                            <select id="ticket_assigned" name="assigned" class="form-select" style="width: 100%;"></select>
                        </div>
                        <div class="from-group mb-2">
                            <label for="">Note</label>
                            <input id="notes" type="text" name="notes" class="form-control" placeholder="Enter Your Note">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>