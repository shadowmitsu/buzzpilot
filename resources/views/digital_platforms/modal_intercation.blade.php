<!-- Add Modal -->
<div class="modal fade" id="addInteractionTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Interaction Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('interaction_types.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Platform Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Interaction</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editInteractionTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Interaction Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editInteractionTypeForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name_interaction" class="form-label">Platform Name</label>
                        <input type="text" id="name_interaction" class="form-control" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Platform</button>
                </form>
            </div>
        </div>
    </div>
</div>
