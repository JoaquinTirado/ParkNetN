<?php include 'controllers/index.php' ?>
<!DOCTYPE html>
<html lang="en" >
	<?php include 'components/head.php' ?>
    <!-- end::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
		<?php include 'components/header.php'; ?>
		<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<?php include 'components/menu.php' ?>
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<div class="m-content">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
											New User
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form m-form--fit" name="sendForm" id="newUser">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												User Information
											</h3>
										</div>
										<div class="form-group m-form__group">
											<label for="example_input_full_name">
												Username:
											</label>
											<input id="new-user-username" type="text" class="form-control m-input" placeholder="Enter Username">
											<span class="m-form__help">
												Please enter a unique username with no spaces. Eg: ExampleUser
											</span>
										</div>

										<div class="form-group m-form__group">
											<label >
												Phone Number:
											</label>
											<br>
												<input id="new-user-phone" type="tel" class="form-control m-input" placeholder="Phone Number">
												<span id="valid-msg" class="hidden">✓ Valid</span>
												<span id="error-msg" class="hidden">Invalid number</span>
											<br>
											<span class="m-form__help">
												Please enter the phone number with the following format [area code][phone number]. Eg: 7875554444
											</span>
										</div>
										
										<div class="form-group m-form__group">
											<label >
												Email Address:
											</label>
											<div class="m-input-icon m-input-icon--left">
												<input id="new-user-email" type="email" class="form-control m-input" placeholder="Email Address">
												<span class="m-input-icon__icon m-input-icon__icon--left">
													<span>
														<i class="la la-bell"></i>
													</span>
												</span>
											</div>
											<span class="m-form__help">
												Please enter a valid email address. Eg: email@example.com
											</span>
										</div>

									</div>
								</div>
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions--solid">
										<div class="m-alert m-alert--outline alert alert-success alert-dismissible hidden" id="success-user-message" role="alert">			
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>			
											<span>Congratulations! New user was successfully created. This page will refresh automatically now.</span>		
										</div>
										<button id="m_new_user_submit" class="btn btn-success">
											Submit
										</button>
										<button type="reset" class="btn btn-secondary">
											Cancel
										</button>
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Portlet-->

					</div>
				</div>
			</div>
			<!-- end:: Body -->
			<?php include 'components/footer.php' ?>
		</div>
		<!-- end:: Page -->
	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<input type="hidden" id="pageid" value="new-user">
		<!-- end::Scroll Top -->
    	<?php include 'components/foot-scripts.php' ?>
	</body>
	<!-- end::Body -->
</html>
