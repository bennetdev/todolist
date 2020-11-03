<div class="modal fade" id="editModalTodo">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Todo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="app/edit.php" method="post">
            <div class="form-group">
              <label for="todo-name">
              
              <input type="text" name="name" placeholder="name" id="todo-name" class="form-control" required>
            </label>
            </div>
            <div class="form-group">
              <label for="todo-description">Description:</label>
              <textarea class="form-control" rows="4" id="todo-description" placeholder="description"></textarea>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input checked" id="todo-done">
              <label class="custom-control-label" for="todo-done">Done</label>
            </div>
          </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer modal-footer-todo">
        <button type="button" id="submit-edit" class="btn submit" data-dismiss="modal">Edit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      <p class="debugModal"></p>

    </div>
  </div>
</div>