<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="exampleModalLabel">View Project</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Project Name:</strong>
            <p class="form-control-plaintext">{{ $project->name }}</p>
        </div>
        <div class="col-md-6">
            <strong>Merchant:</strong>
            <p class="form-control-plaintext">{{ $project->user->name }}</p>
        </div>
        <div class="col-md-6">
            <strong>Service:</strong>
            <p class="form-control-plaintext">{{ $project->service->name }}</p>
        </div>
        <div class="col-md-6">
            <strong>Service Status:</strong>
            <p class="form-control-plaintext">{{ $project->status }}</p>
        </div>
        <div class="col-md-6">
            <strong>Priority:</strong>
            <p class="form-control-plaintext">{{ $project->priority }}</p>
        </div>
    </div>
    <div class="mb-3">
        <strong>Guidelines:</strong>
        <p class="form-control-plaintext">{{ $project->guidelines }}</p>
    </div>
    <div class="mb-3">
        <strong>Notes:</strong>
        <p class="form-control-plaintext">{{ $project->notes }}</p>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
