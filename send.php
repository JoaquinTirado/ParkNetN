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
											New Key Form
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form m-form--fit" name="sendForm">
								<input type="hidden" id="keyid" value="">
								<input type="hidden" id="puertoRicoTimestamp" value="<?php date_default_timezone_set('America/Puerto_Rico');	echo time(); ?>">
								<input type="hidden" id="startTimestamp" value="0">
								<input type="hidden" id="endTimestamp" value="9000000000">
								<input type="hidden" id="zoneId" value="<?php echo $_SESSION['allowedZones']; ?>">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												Key Information
											</h3>
										</div>
										<div class="form-group m-form__group">
											<label for="example_input_full_name">
												Recipient Name:
											</label>
											<input id="recipient-name" type="text" class="form-control m-input" placeholder="Enter full name">
											<span class="m-form__help">
												Please enter the full name
											</span>
										</div>

										<div class="m-form__group form-group">
											<label for="">
												Choose where to send key to:
											</label>
											<div class="m-radio-list">
												<label class="m-radio">
													<input type="radio" name="sendTo" value="email">
													Email
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="sendTo" value="text">
													Phone (SMS)
													<span></span>
												</label>
											</div>
											<span class="m-form__help">
												Please select one
											</span>
										</div>

										<div id="receiver-text" class="form-group m-form__group hidden">
											<label>
												Recipient Phone Number:
											</label>
											<br>
												<input id="recipient-phone" type="tel" class="form-control m-input" placeholder="Phone number">
												<span id="valid-msg" class="hidden">✓ Valid</span>
												<span id="error-msg" class="hidden">Invalid number</span>
											<br>
											<span class="m-form__help">
												Please enter the phone number with the following format [area code][phone number]. Eg: 7875554444
											</span>
										</div>

										<div id="receiver-email" class="form-group m-form__group hidden">
											<label>
												Recipient Email:
											</label>
											<div class="m-input-icon m-input-icon--left">
												<input id="recipient-email" type="email" class="form-control m-input" placeholder="Email address">
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
									<div class="m-form__seperator m-form__seperator--dashed"></div>
									<div class="m-form__section m-form__section--last">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												Key Type
											</h3>
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Choose Recipient access:
											</label>
											<div class="m-radio-list">
												<label class="m-radio">
													<input type="radio" name="keytype" value="always">
													Always Active
														(A key that is always active.)
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="keytype" value="workingHours">
													Working Hours
														(A key that is active between 9am and 6pm.)
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="keytype" value="period">
													By Period
														(A key that is active within a selected time period.)
													<span></span>
												</label>
											</div>
											<span class="m-form__help">
												Please select one
											</span>
										</div>

										<!-- Calendars -->
										<div id="datepickers" class="hidden">
											<div class="form-group m-form__group row">
												<label class="col-form-label col-lg-2 col-sm-12">
													Start Date
												</label>
												<div class="col-lg-4 col-md-4 col-sm-12">
													<div class="input-group date">
														<input type="text" class="form-control m-input" readonly value="01/01/2018 00:30" id="m_datetimepicker_3"/>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar glyphicon-th"></i>
															</span>
														</div>
													</div>
													<span class="m-form__help">
														Please select the START day of the period
													</span>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-form-label col-lg-2 col-sm-12">
													End Date
												</label>
												<div class="col-lg-4 col-md-4 col-sm-12">
													<div class="input-group date">
														<input type="text" class="form-control m-input" readonly value="01/01/2018 00:30" id="m_datetimepicker_2"/>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar-check-o glyphicon-th"></i>
															</span>
														</div>
													</div>
													<span class="m-form__help">
														Please select the END day of the period
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions--solid">
										<button id="m_key_submit" class="btn btn-success">
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
		<input type="hidden" id="pageid" value="send">
		<!-- end::Scroll Top -->
    	<?php include 'components/foot-scripts.php' ?>
	</body>
	<!-- end::Body -->
</html>
