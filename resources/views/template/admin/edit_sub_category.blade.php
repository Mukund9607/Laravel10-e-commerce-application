@extends('layout_for_admin.main')
@section('main-section')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sub_category.list') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('subcategory.store') }}" method="post" id="subcategoryForm" name="categoryForm">
                @method('PUT')
                @csrf
                <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="category_id" id="category" class="form-control">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option  {{ ($subcategory->category_id == $category->id) ? 'selected': ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $subcategory->name }}">	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Slug</label>
                            <input type="text" name="slug" id="slug" readonly class="form-control" placeholder="Slug" value="{{ $subcategory->slug }}">	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option {{ ($subcategory->status ==1) ? 'selected': ''}} value="1">Active</option>
                                <option {{ ($subcategory->status ==0) ? 'selected': ''}}  value="0">Blog</option>
                            </select>

                        </div>
                    </div>									
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">edit</button>
                <a href="{{ route('sub_category.list') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>          	
            </form>						
        </div>
        
    </div>
    <!-- /.card -->
</section>
@endsection

@section('customejs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // generate the slug
        $('#name').on('input', function() {
        var name = $(this).val().trim().toLowerCase();
        var slug = name.replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
        $('#slug').val(slug);
        });


        // store the category through ajax call 

        $('#subcategoryForm').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $.ajax({
            type: 'POST',
            url: '{{ route("sub_category.update",['id' => $subcategory->id]) }}',
            data: formData,
            contentType: false,
            processData: false,
           success: function(data) {
               alert('SubCategory added successfully');
               window.location.href = "{{route('sub_category.list')}}";
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

@endsection