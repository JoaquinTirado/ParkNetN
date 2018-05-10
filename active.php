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
 <!--Begin::Section-->
						<div class="row">
							<div class="col-xl-12">
								<div class="m-portlet m-portlet--mobile ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Active Keys <span class="m-badge m-badge--success m-badge--wide"><?php echo $active_keys_count ?></span>
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
										<!--begin: Search Form -->
										<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
											<div class="row align-items-center">
												<div class="col-xl-8 order-2 order-xl-1">
													<div class="form-group m-form__group row align-items-center">
														<div class="col-md-6">
															<div class="m-input-icon m-input-icon--left">
																<input type="text" class="form-control m-input" onkeyup="search()" placeholder="Search..." id="generalSearch">
																<span class="m-input-icon__icon m-input-icon__icon--left">
																	<span>
																		<i class="la la-search"></i>
																	</span>
																</span>
															</div>
														</div>
															<div class="col-md-4">
																<div class="m-form__group m-form__group--inline">
																	<div class="btn-group m-btn-group" role="group" aria-label="...">
																		<button type="button" class="btn btn-success" id="btnExport" onclick="javascript:xport.toCSV('m-datatable__table', 'Active Keys');">
																			CSV
																		</button>
																		<!-- <button type="button" class="btn btn-success" onclick="javascript:demoFromHTML();">
																			PDF
																		</button> -->
																	</div>
																</div>
																<div class="d-md-none m--margin-bottom-10"></div>
															</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Search Form -->
										<!--begin: Datatable -->
										<button onclick = "Change()">Change Color</button>
										<div class="m_datatable" id="ajax_data"></div>
										<div class="m_datatable_csv hidden"></div>
										<!--Data table style: -->

										<!--end: Datatable -->
									</div>
								</div>
							</div>
						</div>
						<!--End::Section-->

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
		<input type="hidden" id="pageid" value="active">
		<!-- end::Scroll Top -->
    	<?php include 'components/foot-scripts.php' ?>



<script type="text/javascript">

var Random = setInterval(Swap, 110);

function Swap() {
    
    $("[class='m-datatable__pager m-datatable--paging-loaded clearfix']").each(function () {
        $(this).insertBefore($(this).prev("[class='m-datatable__table']"));
    });

}

function Change() {
$("h3").css("color", "red");
$("[class='m-datatable__row']").css("background-color", "red");
$("div.myclass").hover(function() {
  $(this).css("background-color","blue")
});
}


</script>




	</body>
	<!-- end::Body -->
</html>
