<div class="modal fade bs-example-modal-lg" id="addCompanyModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                    &nbsp; Add New Compnay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/company_server.php?add_company_data=true" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <label>Company Name</label>
                        <input name="company_name" placeholder="Enter Company Name" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Company Logo</label>
                        <input name="company_logo"  class="form-control" type="file">
                    </div>
                    <div class="form-group mb-2">
                        <label>Fullname</label>
                        <input name="fullname" placeholder="Enter Fullname" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input name="username" placeholder="Enter Username" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Passowrd</label>
                        <input name="password" placeholder="Enter Passowrd" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Mobile Number</label>
                        <input class="form-control" type="text" name="mobile_number" id="mobile_number"
                            placeholder="Type Mobile Number" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email"
                            placeholder="Type Your Email" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Type Your Address" />
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


<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                    &nbsp;Update Company Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/company_server.php?update_company_data=true" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-group mb-2 d-none">
                        <input name="id" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Company Name</label>
                        <input name="company_name" placeholder="Enter Company Name" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Fullname</label>
                        <input name="fullname" placeholder="Enter Fullname" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input name="username" placeholder="Enter Username" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label>Passowrd</label>
                        <input name="password" placeholder="Enter Passowrd" class="form-control" type="text">
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Mobile Number</label>
                        <input class="form-control" type="text" name="mobile_number" id="mobile_number"
                            placeholder="Type Mobile Number" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email"
                            placeholder="Type Your Email" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Type Your Address" />
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
