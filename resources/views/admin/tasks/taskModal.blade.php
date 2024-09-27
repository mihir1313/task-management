<div class="modal fade" id="taskModal" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog custom-modal-width">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form onsubmit="return false" id="taskForm">
             @csrf
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Title</label>
              <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="hid" name="hid">
                <input type="text" class="form-control" id="title" name="title">
              </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">User</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="user" name="user">
                    @if ($user > 0 && !empty($user))
                    @foreach ($user as $key => $value)
                
                    @if($key == 0){
                        <option selected value="">Select User</option>
                    }
                    @endif
                    <option value={{ isset($value['id']) ? $value['id'] : '' }}>{{ isset($value['name']) ? $value['name'] : '' }}</option>
                    @endforeach
                    @else
                        
                        <option selected>No Users Found!</option>
                    
                        @endif
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="status" name="status" required>
                        <option value="" selected disabled>Select status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
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