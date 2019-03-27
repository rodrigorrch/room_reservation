<div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="roomModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" value="" name="reunion-id" id="reunion-id">
                    <input type="hidden" value="" name="reunion-date" id="reunion-date">
                    <input type="hidden" value="" name="reunion-hour" id="reunion-hour">
                    <input type="hidden" value="" name="reunion-reference" id="reunion-reference">
                    <div class="form-group">
                        <label for="reunion-name" name="reunion-name" class="col-form-label">Name:</label>
                        <input type="text" required class="form-control" id="reunion-name">
                    </div>
                    <div class="form-group">
                        <label for="reunion-desc" name="reunion-desc" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="reunion-desc"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary room-save">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rooRemoveModal" tabindex="-1" role="dialog" aria-labelledby="rooRemoveModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" value="" name="reunion-id" id="reunion-id">
                    <input type="hidden" value="" name="reunion-date" id="reunion-date">
                    <input type="hidden" value="" name="reunion-reference" id="reunion-reference">
                    <p>Do you really want to remove this appointment ?</p>
                    <div class="form-group">
                        <label for="reunion-name" name="reunion-name" class="col-form-label">Name:</label>
                        <input type="text" required class="form-control" id="reunion-name" disabled>
                    </div>
                    <div class="form-group">
                        <label for="reunion-desc" name="reunion-desc" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="reunion-desc" disabled></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger room-delete">Remove</button>
            </div>
        </div>
    </div>
</div>

