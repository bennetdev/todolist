<div class="modal fade" id="editModalKategorie">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="app/edit.php" method="post">
            <div class="form-group">
              <label for="kategorie-name">
              
              <input type="text" name="name" placeholder="name" id="kategorie-name" class="form-control" required>
            </label>
            </div>
          </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer modal-footer-kategorie">
        <button type="button" id="submit-edit-kategorie" class="btn submit" data-dismiss="modal">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      <p class="debugModal"></p>

    </div>
  </div>
</div>