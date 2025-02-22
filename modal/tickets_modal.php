<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Ticket Add&nbsp;&nbsp;<i class="fas fa-ticket-alt"></i></h5>
            </div>
            <form action="include/tickets_server.php?add_ticket_data=true" method="POST" id="ticket_modal_form">
                <div class="modal-body">
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Customer Name</label>
                                <select class="form-select" name="customer_id" id="ticket_customer_id" style="width: 100%;"></select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Ticket For</label>
                                <select id="ticket_for" name="ticket_for" class="form-select" required>
                                    <option value="Home Connection">Home Connection</option>
                                    <option value="POP">POP Support</option>
                                    <option value="Corporate">Corporate</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Complain Type</label>
                                <select id="ticket_complain_type" name="ticket_complain_type" class="form-select" style="width: 100%;"></select>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Ticket Priority</label>
                                <select id="ticket_priority" name="ticket_priority" class="form-select" style="width: 100%;">
                                    <option>---Select---</option>
                                    <option value="1">Low</option>
                                    <option value="2">Normal</option>
                                    <option value="3">Standard</option>
                                    <option value="4">Medium</option>
                                    <option value="5">High</option>
                                    <option value="6">Very High</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Assigned To</label>
                                <select id="ticket_assigned" name="assigned" class="form-control" style="width: 100%;"></select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Note</label>
                                <input id="notes" type="text" name="notes" class="form-control" placeholder="Enter Your Note">
                            </div>
                        </div>
                    </div>

                    <!-- Previous Tickets Table -->
                    <div class="mt-3 d-none" id="previous_tickets">
                        <h6>Previous Tickets</h6>
                        <table class="table table-bordered"  id="customer_tickets_table">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Issue</th>
                                    <th>Priority</th>
                                    <th>Percentage</th>
                                    <th>Acctual Work</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="customer_tickets">
                                <tr >
                                    <td colspan="4" class="text-center">No Tickets Found</td>
                                </tr>
                            </tbody>
                        </table>
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
