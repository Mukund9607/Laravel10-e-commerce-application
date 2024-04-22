@extends('layout_for_admin.main')
@section('main-section')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('category.list')}}" class="btn btn-primary">Back</a>
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
            <form action="{{ route("category.update",['id' => $category->id ]) }}" method="put" id="categoryForm" name="categoryForm"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"  placeholder="Name" value="{{ $category->name }}">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control"  placeholder="Slug" value="{{ $category->slug }}"
                                    readonly>

                            </div>
                        </div>

                        @if ($category->image)
                        <div class="row mb-3">
                            <div class="col">
                                <img src="{{ asset($category->image) }}" style="width: 80px; margin-top: 10px;"
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($category->status ==1) ? 'selected': ''}} value="1">Active</option>
                                    <option {{ ($category->status ==0) ? 'selected': ''}}  value="0">Blog</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">edit</button>
                    <a href="{{route('category.list')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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

        $('#categoryForm').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $.ajax({
            type: 'POST',
            url: '{{ route("category.update",['id' => $category->id]) }}',
            data: formData,
            contentType: false,
            processData: false,
           success: function(data) {
               alert('Category added successfully');
               window.location.href = "{{route('category.list')}}";
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