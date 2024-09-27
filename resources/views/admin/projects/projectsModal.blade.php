<div class="modal fade" id="projectModal" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog custom-modal-width"> 
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Projects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form onsubmit="return false" id="projectForm">
             @csrf
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Project Name</label>
              <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="hid" name="hid">
                <input type="text" class="form-control" id="projectname" name="projectname">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                {{--  <input type="" class="form-control" id="email" name="email">  --}}
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