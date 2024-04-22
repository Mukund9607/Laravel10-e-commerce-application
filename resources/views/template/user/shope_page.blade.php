@extends('layout.main_layout')
@section('main-section')
<main>

    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <div class="accordion accordion-flush" id="accordionExample">
                                @foreach ($categories as $key => $category )
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}"
                                            aria-expanded="false" aria-controls="collapseOne-{{ $key }}">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne-{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @foreach($category->subcategories as $subcategory)
                                                <a href="{{ route('shop_page',[$category->slug, $subcategory->slug])}}"
                                                    class="nav-item nav-link">{{ $subcategory->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                            {{-- <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    $0-$100
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $100-$200
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $200-$500
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $500+
                                </label>
                            </div> --}}
                        </div>
                    </div>

                    {{-- <div class="card">
                        <form action="{{ route('shop_page',[$categoryslug , $subcategroyslug]) }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <!-- Include hidden fields for category and subcategory slugs -->
                                <input type="hidden" name="categoryslug" value="{{ $categoryslug }}">
                                <input type="hidden" name="subcategroyslug" value="{{ $subcategroyslug }}">

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" value="0,100" name="price_range"
                                        id="price_range_0_100">
                                    <label class="form-check-label" for="price_range_0_100">
                                        $0-$100
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" value="100,200" name="price_range"
                                        id="price_range_100_200">
                                    <label class="form-check-label" for="price_range_100_200">
                                        $100-$200
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" value="200,500" name="price_range"
                                        id="price_range_200_500">
                                    <label class="form-check-label" for="price_range_200_500">
                                        $200-$500
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" value="500,2000" name="price_range"
                                        id="price_range_500_2000">
                                    <label class="form-check-label" for="price_range_500_2000">
                                        $500-$2000
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Apply Filters</button>

                            </div>
                        </form>
                    </div> --}}
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <input type="hidden" name="categoryslug" value="{{ $categoryslug }}">
                                            <input type="hidden" name="subcategroyslug" value="{{ $subcategroyslug }}">
                                            <a name="sort" value="latest" class="dropdown-item" href="{{ route('shop_page', ['categoryslug' => $categoryslug,
                                             'subcategroyslug' => $subcategroyslug, 'sort' => 'latest']) }}">Latest</a>
                                            <a name="sort" value="low_price" class="dropdown-item" href="{{ route('shop_page', ['categoryslug' => $categoryslug,
                                             'subcategroyslug' => $subcategroyslug, 'sort' => 'high_price']) }}">Price
                                                High</a>
                                            <a name="sort" value="high_price" class="dropdown-item" href="{{ route('shop_page', ['categoryslug' => $categoryslug, 
                                            'subcategroyslug' => $subcategroyslug, 'sort' => 'low_price']) }}">Price
                                                Low</a>
                                        </div>
                                    </div> --}}
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{($sort=='latest' ) ? 'selected' : '' }}>latest</option>
                                        <option value="price_asc" {{($sort=='price_asc' ) ? 'selected' : '' }}>
                                            price_High</option>
                                        <option value="price__desc" {{($sort=='price__desc' ) ? 'selected' : '' }}>
                                            price_low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @foreach ($products as $product )
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="{{ route('front_product',$product->slug) }}" class="product-img"><img class="card-img-top"
                                            src="{{ asset($product->image) }}" alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                            <i class="fa fa-shopping-cart"></i>&nbsp;Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $product->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{ $product->price }}</strong></span>
                                        <span class="h6 text-underline"><del>{{ $product->compare_price }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-md-12 pt-5">
                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> --}}
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>
@endsection

@section('frontjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var jq = jQuery.noConflict();
    jq(document).ready(function() {
        rangeSlider = $(".js-range-slider").ionRangeSlider({
    type: "double",
    min: 0,
    max: 10000,
    from: {{ ($price_min) }},
    step: 10,
    to: {{ ($price_max) }},
    skin: "round",
    max_postfix: "+",
    // Remove the prefix option
    onFinish: function() {
        apply_filters();
    }
});

var slider = $(".js-range-slider").data("ionRangeSlider");


    $('#sort').change(function () {
        apply_filters();
      });
      function apply_filters() {
        var url = '{{ url()->current() }}?';
        url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;
        url += '&sort='+$('#sort').val();
        var keyword = $('#search').val();

        if(keyword.length >0){
            url += '&search='+keyword;
        }
        window.location.href = url;
    }

    

});




    
</script>
@endsection