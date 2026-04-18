@extends('user.layout')

@section('content')

<main class="main">
           <!-- End .breadcrumb-nav -->
	        	<div class="page-header page-header-big text-center" style="background-image: url('assets/images/contact-header-bg.jpg')">
        			<h1 class="page-title text-white">Contact us<span class="text-white">keep in touch with us</span></h1>
	        	</div><!-- End .page-header -->

            <div class="page-content pb-0">
                <div class="container">

                    {{-- Success / Error Alerts --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow mb-3"
                         style="border-left:4px solid #28a745; border-radius:6px;">
                        <i class="icon-check mr-2" style="color:#28a745;"></i>
                        <strong>Thank you!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow mb-3"
                         style="border-left:4px solid #dc3545; border-radius:6px;">
                        <strong>Oops!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                    @endif

                	<div class="row">
                		<div class="col-lg-6 mb-2 mb-lg-0">
                			<h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
                			<p class="mb-3">We'd love to hear from you! Whether you have a question about an order, need styling advice, or just want to say hello — our team is always happy to help. Reach out to us anytime.</p>
                			<div class="row">
                				<div class="col-sm-7">
                					<div class="contact-info">
                						<h3>Our Studio</h3>

                						<ul class="contact-list">
                							<li>
                								<i class="icon-map-marker"></i>
	                							12, Swastik Society, C.G. Road,
                                                Navrangpura, Ahmedabad,
                                                Gujarat — 380009, India
	                						</li>
                							<li>
                								<i class="icon-phone"></i>
                								<a href="tel:+916354789012">+91 63547 89012</a>
                							</li>
                							<li>
                								<i class="icon-envelope"></i>
                								<a href="mailto:support@thestylestudio.in">support@thestylestudio.in</a>
                							</li>
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-7 -->

                				<div class="col-sm-5">
                					<div class="contact-info">
                						<h3>Working Hours</h3>

                						<ul class="contact-list">
                							<li>
                								<i class="icon-clock-o"></i>
	                							<span class="text-dark">Monday – Saturday</span> <br>10am – 7pm IST
	                						</li>
                							<li>
                								<i class="icon-calendar"></i>
                								<span class="text-dark">Sunday</span> <br>11am – 5pm IST
                							</li>
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-5 -->
                			</div><!-- End .row -->
                		</div><!-- End .col-lg-6 -->

                		<div class="col-lg-6">
                			<h2 class="title mb-1">Got Any Questions?</h2><!-- End .title mb-2 -->
                			<p class="mb-2">Use the form below to get in touch with our team — we usually respond within 24 hours.</p>

                			<form action="{{ route('contact.submit') }}" method="POST" class="contact-form mb-3">
                                @csrf
                				<div class="row">
                					<div class="col-sm-6">
                                        <label for="cname" class="sr-only">Name</label>
                						<input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="cname" name="name"
                                               placeholder="Name *"
                                               value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}"
                                               required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                					</div><!-- End .col-sm-6 -->

                					<div class="col-sm-6">
                                        <label for="cemail" class="sr-only">Email</label>
                						<input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="cemail" name="email"
                                               placeholder="Email *"
                                               value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                               required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                					</div><!-- End .col-sm-6 -->
                				</div><!-- End .row -->

                				<div class="row">
                					<div class="col-sm-6">
                                        <label for="cphone" class="sr-only">Phone</label>
                						<input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                               id="cphone" name="phone"
                                               placeholder="Phone"
                                               value="{{ old('phone') }}">
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                					</div><!-- End .col-sm-6 -->

                					<div class="col-sm-6">
                                        <label for="csubject" class="sr-only">Subject</label>
                						<input type="text" class="form-control @error('subject') is-invalid @enderror"
                                               id="csubject" name="subject"
                                               placeholder="Subject"
                                               value="{{ old('subject') }}">
                                        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                					</div><!-- End .col-sm-6 -->
                				</div><!-- End .row -->

                                <label for="cmessage" class="sr-only">Message</label>
                				<textarea class="form-control @error('message') is-invalid @enderror"
                                          cols="30" rows="4"
                                          id="cmessage" name="message"
                                          required
                                          placeholder="Message *">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror

                				<button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm mt-2">
                					<span>SUBMIT</span>
            						<i class="icon-long-arrow-right"></i>
                				</button>
                			</form><!-- End .contact-form -->
                		</div><!-- End .col-lg-6 -->
                	</div><!-- End .row -->

                	<hr class="mt-4 mb-5">

                	<div class="stores mb-4 mb-lg-5">
	                	<h2 class="title text-center mb-3">Our Stores</h2><!-- End .title text-center mb-2 -->

	                	<div class="row">
	                		<div class="col-lg-6">
	                			<div class="store">
	                				<div class="row">
	                					<div class="col-sm-5 col-xl-6">
	                						<figure class="store-media mb-2 mb-lg-0">
	                							<img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?w=400&h=300&fit=crop" alt="Style Studio C.G. Road">
	                						</figure><!-- End .store-media -->
	                					</div><!-- End .col-xl-6 -->
	                					<div class="col-sm-7 col-xl-6">
	                						<div class="store-content">
	                							<h3 class="store-title">Style Studio — C.G. Road</h3><!-- End .store-title -->
	                							<address>12, Swastik Society, C.G. Road, Navrangpura, Ahmedabad, Gujarat — 380009</address>
	                							<div><a href="tel:+916354789012">+91 63547 89012</a></div>

	                							<h4 class="store-subtitle">Store Hours:</h4><!-- End .store-subtitle -->
                								<div>Monday – Saturday: 10am to 7pm</div>
                								<div>Sunday: 11am to 5pm</div>

                								<a href="https://maps.google.com/?q=C.G.+Road+Navrangpura+Ahmedabad" class="btn btn-link" target="_blank"><span>View Map</span><i class="icon-long-arrow-right"></i></a>
	                						</div><!-- End .store-content -->
	                					</div><!-- End .col-xl-6 -->
	                				</div><!-- End .row -->
	                			</div><!-- End .store -->
	                		</div><!-- End .col-lg-6 -->

	                		<div class="col-lg-6">
	                			<div class="store">
	                				<div class="row">
	                					<div class="col-sm-5 col-xl-6">
	                						<figure class="store-media mb-2 mb-lg-0">
	                							<img src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?w=400&h=300&fit=crop" alt="Style Studio Satellite">
	                						</figure><!-- End .store-media -->
	                					</div><!-- End .col-xl-6 -->

	                					<div class="col-sm-7 col-xl-6">
	                						<div class="store-content">
	                							<h3 class="store-title">Style Studio — Satellite</h3><!-- End .store-title -->
	                							<address>47, Anand Nagar, Satellite Road, Ahmedabad, Gujarat — 380015</address>
	                							<div><a href="tel:+916354789013">+91 63547 89013</a></div>

	                							<h4 class="store-subtitle">Store Hours:</h4><!-- End .store-subtitle -->
												<div>Monday – Friday: 10am to 8pm</div>
												<div>Saturday: 10am to 7pm</div>
												<div>Sunday: 11am to 5pm</div>

                								<a href="https://maps.google.com/?q=Satellite+Road+Ahmedabad" class="btn btn-link" target="_blank"><span>View Map</span><i class="icon-long-arrow-right"></i></a>
	                						</div><!-- End .store-content -->
	                					</div><!-- End .col-xl-6 -->
	                				</div><!-- End .row -->
	                			</div><!-- End .store -->
	                		</div><!-- End .col-lg-6 -->
	                	</div><!-- End .row -->
                	</div><!-- End .stores -->
                </div><!-- End .container -->
            	<div id="map">
                <div style="display:flex; width:100%; height:450px;">

                    {{-- Store 1: C.G. Road, Navrangpura --}}
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.8!2d72.5560!3d23.0226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84fa861745b3%3A0x8369743e6f1d7d1e!2sCG%20Road%2C%20Navrangpura%2C%20Ahmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1713000000000!5m2!1sen!2sin"
                        width="50%"
                        height="450"
                        style="border:0; display:block;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    {{-- Store 2: Satellite Road --}}
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3672.3!2d72.5230!3d23.0105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9b2ba9c9cf67%3A0x9b79b6debc97c250!2sSatellite%20Rd%2C%20Ahmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1713000000001!5m2!1sen!2sin"
                        width="50%"
                        height="450"
                        style="border:0; display:block;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>
            </div><!-- End #map -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<script>
    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (el) {
            el.classList.remove('show');
            el.classList.add('fade');
            setTimeout(function () { el.remove(); }, 300);
        });
    }, 4000);
</script>

@endsection