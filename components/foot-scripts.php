<!--begin::Base Scripts -->
<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Base Scripts -->
  <!--begin::Page Vendors -->
<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
  <!--begin::Page Snippets -->
  <script src="assets/app/js/datatable.js" type="text/javascript"></script>
<script src="assets/app/js/dashboard.js" type="text/javascript"></script>
<script src="assets/app/js/send.js" type="text/javascript"></script>
<script src="assets/demo/default/custom/components/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="components/export-datatable/jspdf/jspdf.debug.js" type="text/javascript"></script>
<script src="components/export-datatable/jspdf/basic.js" type="text/javascript"></script>
<script src="components/export-datatable/jquery.base64.js" type="text/javascript"></script>
<script src="components/export-datatable/tableExport.js" type="text/javascript"></script>
<script src="components/export-datatable/jspdf/libs/sprintf.js" type="text/javascript"></script>
<script src="components/export-datatable/jspdf/libs/base64.js" type="text/javascript"></script>
<script src="components/jwt-decode/jwt-decode.min.js" type="text/javascript"></script>
<script src="node_modules/papaparse/papaparse.js" type="text/javascript"></script>
<script src="assets/intl-tel-input/build/js/intlTelInput.js"></script>
<script>
$("#recipient-phone").intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript: "assets/intl-tel-input/build/js/utils.js"
});
</script>
<script>
$("#new-user-phone").intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript: "assets/intl-tel-input/build/js/utils.js"
});
</script>
<!--end::Page Snippets -->
