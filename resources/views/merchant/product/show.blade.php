<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="exampleModalLabel">View Product</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Product Name:</strong>
            <p class="form-control-plaintext">{{ $product->name }}</p>
        </div>
        <div class="col-md-6">
            <strong>Brand:</strong>
            <p class="form-control-plaintext">{{ $product->brand->name }}</p>
        </div>
        <div class="col-md-6">
            <strong>Service Status</strong>
            <p class="form-control-plaintext">{{ $product->service_status ? 'Completed' : 'Pending' }}</p>
        </div>
        <div class="col-md-6">
            <strong>Brand:</strong>
            <p class="form-control-plaintext">{{ $product->brand->name }}</p>
        </div>
    </div>
    <div class="mb-3">
        <strong>Description:</strong>
        <p class="form-control-plaintext">{{ $product->description }}</p>
    </div>
    <div class="mb-3">
        <strong>Images:</strong>
        <div class="d-flex flex-wrap gap-2">
            @foreach($product->media as $media)
                <img src="{{ asset('storage/' . $media->name) }}" alt="Product Image" class="img-thumbnail" width="120">
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
