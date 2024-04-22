@extends('layout_for_admin.main')
@section('main-section')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('product-list') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="{{ route('product_update',['id' => $product->id ]) }}" method="post" id="productupdateForm" name="productupdateForm"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input value="{{ $product->title }}" type="text" name="title" id="title"
                                            class="form-control" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input value="{{ $product->slug }}" type="text" name="slug" id="slug"
                                            class="form-control" placeholder="Slug" readonly>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10"
                                            class="summernote"
                                            placeholder="Description">{{ $product->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @if ($product->image)
                    <div class="row mb-3">
                        <div class="col">
                            <img src="{{ asset($product->image) }}" style="width: 80px; margin-top: 10px;"
                                alt="Avatar Image">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image">Category Image</label>
                            <input type="file" name="image" id="image" class="form-control" placeholder="image">
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input for="text" type="text" name="price" id="price" class="form-control"
                                            placeholder="Price" value="{{ $product ->price }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control"
                                            placeholder="Compare Price" value="{{ $product->compare_price }}">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at
                                            price. Enter a lower value into Price.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="track_qty">Track Quantity</label>
                                        <input for="{{ $product->qty }}" type="text" name="qty" id="qty"
                                            class="form-control" placeholder="qty">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($product->status ==1) ? 'selected': ''}} value="1">Active</option>
                                    <option {{ ($product->status ==0) ? 'selected': ''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option {{ ($product->category_id == $category->id) ? 'selected' : '' }} value="{{
                                        $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="subcategory_id" id="subcategory" class="form-control">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subcategories as $subcategory)
                                    <option {{ ($product->subcategory_id == $subcategory->id) ? 'selected' : '' }}
                                        value="{{ $subcategory->id }}">{{ $subcategory->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('product-list') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
    <!-- /.card -->
</section>
@endsection
@section('customejs')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // generate the slug
        $('#title').on('input', function() {
        var name = $(this).val().trim().toLowerCase();
        var slug = name.replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
        $('#slug').val(slug);
        });


        // store the category through ajax call 

        $('#productupdateForm').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $.ajax({
            type: 'POST',
            url: '{{ route("product_update",['id' => $product->id]) }}',
            data: formData,
            contentType: false,
            processData: false,
           success: function(data) {
               alert('product added successfully');
               window.location.href = "{{route('product-list')}}";
           },
           error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    // Clear existing error messages
                    $('.error-message').remove();
                    $.each(errors, function(key, value) {
                        // Append error message below each input field
                        $('#' + key).after('<div class="error-message" style="color: red;">' + value[0] + '</div>');
                    });
                }
       });
   });
});
</script>

<script>
    $(document).ready(function() {
        $('#category').change(function() {
            var categoryId = $(this).val(); // Get the selected category ID
            
            // Clear existing subcategory options
            $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
            
            // If a category is selected
            if (categoryId) {
                // Make an AJAX request to fetch subcategories
                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-subcategories') }}",
                    data: { category_id: categoryId }, // Pass the selected category ID as data
                    dataType: 'json',
                    success: function(response) {
                        // Populate subcategory dropdown with fetched subcategories
                        $.each(response, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching subcategories:', error);
                    }
                });
            }
        });
    });
</script>

@endsection