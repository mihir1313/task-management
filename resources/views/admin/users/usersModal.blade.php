<div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form onsubmit="return false" id="userForm">
             @csrf
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">username</label>
              <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="hid" name="hid">
                <input type="hidden" class="form-control" id="role" name="role" value="user">
                <input type="text" class="form-control" id="username" name="username">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Mail</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="pass" name="pass">
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>