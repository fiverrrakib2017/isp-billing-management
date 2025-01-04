
<div class="modal fade bs-example-modal-lg" id="addSupplierModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span
                    class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/supplier_backend.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-2 d-none">
                        <input name="add_supplier_data" class="form-control" type="text" >
                    </div>
                    <div class="form-group mb-2">
                        <label>Fullname</label>
                        <input name="fullname" placeholder="Enter Fullname" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Company</label>
                        <input name="company" placeholder="Enter Company" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Phone Number</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Type Phone Number" required/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Type Your Email"/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Address</label>
                        <input class="form-control" type="text" name="address" id="address" placeholder="Type Your Address" required/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status</label>
                        <select class="form-control" type="text" name="status">
                            <option value="">---Select---</option>
                            <option value="1">Active</option>
                            <option value="0">Expire</option>
                        </select>
                    </div>
                                    
                    <div class="modal-footer ">
                        <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>