<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
						123 Street, New York, USA <br>
						exampl@example.com <br>
						000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
						<li><a href="about-us.php" title="About">About</a></li>
						<li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
						<li><a href="#" title="Privacy">Privacy</a></li>
						<li><a href="#" title="Privacy">Terms & Conditions</a></li>
						<li><a href="#" title="Privacy">Refund Policy</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						<li><a href="{{ route('login_user') }}" title="Sell">Login</a></li>
						<li><a href="{{ route('register_user') }}" title="Advertise">Register</a></li>
						<li><a href="#" title="Contact Us">My Orders</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="{{ asset('user_assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('user_assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('user_assets/js/slick.min.js') }}"></script>
<script src="{{ asset('user_assets/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('user_assets/js/custom.js') }}"></script>


<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}


function addToCart(id) {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $.ajax({
        url: "{{route('add-to-cart') }}", // Replace with your actual endpoint
        type: 'POST',
        data: {
            Id:id,
			// quantity: quantity,
            
        },
        
        success: function(response) {
            // Handle the response from the server
            console.log(response);
            if (response.message === 'Product already in cart') {
        alert('This product is already in your cart.');
    			} else {
        alert('Product added to cart successfully!');
    	    window.location.href = "{{ route('cart') }}";
    }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle errors
            console.error(textStatus, errorThrown);
            alert('An error occurred while adding the product to the cart.');
        }
    });
}

</script>
<script>
	window.embeddedChatbotConfig = {
	chatbotId: "OeH9ulWI4dDRgc7Go-jQE",
	domain: "www.chatbase.co"
	}
	</script>
	<script
	src="https://www.chatbase.co/embed.min.js"
	chatbotId="OeH9ulWI4dDRgc7Go-jQE"
	domain="www.chatbase.co"
	defer>
	</script>
@yield('frontjs')
</body>

</html>