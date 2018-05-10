//== Class definition

var DatatableRemoteAjaxDemo = function() {
  //== Private functions

  var activeKeysTable = function() {
//FLAG
    var datatable = $('.m_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            //url: 'https://keenthemes.com/metronic/preview/inc/api/datatables/demos/default.php',
            url: '../../../controllers/datatable-handler.php',
            map: function(raw) {
              // sample data mapping
              var dataSet = raw;
              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // layout definition
      layout: {
        scroll: false,
        footer: false
      },

      // column sorting
      sortable: true,

      pagination: true,

      toolbar: {
        // toolbar items

        items: {
          // pagination
          pagination: {
            // page size select
            pageSizeSelect: [10, 20, 30, 50, 100, -1],
          },
        },
      },

      // columns definition
			columns: [{
				field: "recipientName",
				title: "Recipient <i class='la la-arrow-down'></i>",
        sortable: false
			}, {
				field: "recipientPhone",
				title: "Sent To",
        sortable: false
			}, {
				field: "approvedBy",
				title: "Approved By",
        sortable: false
			}, {
				field: "keyType",
				title: "Type",
        sortable: false,
        // callback function support for column rendering
				template: function (row) {
					var types = {
						"always":       {'title': 'Always Active', 'class': 'm-badge--brand'},
						"period":       {'title': 'By Period', 'class': ' m-badge--success'},
						"workingHours": {'title': 'Working Hours', 'class': ' m-badge--info'}
					};
          if (row.keyType == 'always') {
            var keyTitle = 'Always Active';
          } else if (row.keyType == 'period') {
            var keyTitle = 'Period ('+row.startDate+' - '+row.endDate+')';
          } else if (row.keyType == 'workingHours') {
            var keyTitle = 'Working Hours (9am - 6pm)';
          }
					return '<span class="m-badge ' + types[row.keyType].class + ' m-badge--wide">' + keyTitle + '</span>';
				}
			}, {
				field: "createdDate",
				title: "Created",
        type: "date",
				format: "MM/DD/YYYY",
        sortable: false
			}, {
				field: "actions",
				title: "Action",
        sortable: false,
        width: 60
			}]
    });

    var datatable_2 = $('.m_datatable_csv').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            // url: 'https://keenthemes.com/metronic/preview/inc/api/datatables/demos/default.php',
            url: '../../../controllers/datatable-handler.php',
            map: function(raw) {
              // sample data mapping
              var dataSet = raw;
              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 999,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // columns definition
			columns: [{
				field: "recipientName",
				title: "Recipient",
        sortable: false
			}, {
				field: "recipientPhone",
				title: "Sent To",
        sortable: false
			}, {
				field: "approvedBy",
				title: "Approved By",
        sortable: false
			}, {
				field: "keyType",
				title: "Type",
        sortable: false,
        // callback function support for column rendering
        template: function (row) {
					var types = {
						"always":       {'title': 'Always Active', 'class': 'm-badge--brand'},
						"period":       {'title': 'By Period', 'class': ' m-badge--success'},
						"workingHours": {'title': 'Working Hours', 'class': ' m-badge--info'}
					};
          if (row.keyType == 'always') {
            var keyTitle = 'Always Active';
          } else if (row.keyType == 'period') {
            var keyTitle = 'Period ('+row.startDate+' - '+row.endDate+')';
          } else if (row.keyType == 'workingHours') {
            var keyTitle = 'Working Hours (9am - 6pm)';
          }
					return '<span class="m-badge ' + types[row.keyType].class + ' m-badge--wide">' + keyTitle + '</span>';
				}
			}, {
				field: "createdDate",
				title: "Created",
        type: "date",
				format: "MM/DD/YYYY",
        sortable: false
			}]
    });

  };

  var usersTable = function() {
    var datatable = $('.m_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            // url: 'https://keenthemes.com/metronic/preview/inc/api/datatables/demos/default.php',
            url: '../../../controllers/users-table-handler.php',
            map: function(raw) {
              // sample data mapping
              var dataSet = raw;
              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // layout definition
      layout: {
        scroll: false,
        footer: false
      },

      // column sorting
      sortable: true,

      pagination: true,

      toolbar: {
        // toolbar items
        items: {
          // pagination
          pagination: {
            // page size select
            pageSizeSelect: [10, 20, 30, 50, 100, -1],
          },
        },
      },

      // columns definition
			columns: [{
				field: "userName",
				title: "Name <i class='la la-arrow-down'></i>",
        sortable: false
			}, {
				field: "userEmail",
				title: "Email",
        sortable: false
			}, {
				field: "userPhone",
				title: "Phone",
        sortable: false
			}, {
				field: "userRole",
				title: "Role",
        sortable: false
			}, {
				field: "roleAction",
				title: "Role Action",
        sortable: false
			}, {
				field: "isActive",
				title: "Active",
        sortable: false
			}, {
				field: "activeAction",
				title: "Active Action",
        sortable: false
			}]
    });
  };

  return {
    // public functions
    init: function() {
      var pageid = document.getElementById('pageid').value;
      if (pageid == 'active' || pageid == 'dashboard') {
        activeKeysTable();
      } else if (pageid == 'user-management') {
        usersTable();
      }

    },
  };
}();

jQuery(document).ready(function() {
  DatatableRemoteAjaxDemo.init();

  table = document.getElementsByClassName('m-datatable__table')[0];
  var elem0 = true;
  var element0 = document.getElementsByClassName('m-datatable__cell')[0];
  element0.addEventListener("click", function(e) {
      sortTable(0);
      tr = table.getElementsByTagName("tr")[0];
      span = tr.getElementsByTagName("span")[0];
      if (elem0 == true) {
        span.innerHTML = "Recipient <i class='la la-arrow-up'></i>";
        elem0 = false;
      } else {
        span.innerHTML = "Recipient <i class='la la-arrow-down'></i>";
        elem0 = true;
      }

  }, false);

  var elem1 = true;
  var element1 = document.getElementsByClassName('m-datatable__cell')[1];
  element1.addEventListener("click", function(e) {
      sortTable(1);
      tr = table.getElementsByTagName("tr")[0];
      span = tr.getElementsByTagName("span")[1];
      if (elem1 == true) {
        span.innerHTML = "Phone <i class='la la-arrow-up'></i>";
        elem1 = false;
      } else {
        span.innerHTML = "Phone <i class='la la-arrow-down'></i>";
        elem1 = true;
      }
  }, false);

  var elem2 = true;
  var element2 = document.getElementsByClassName('m-datatable__cell')[2];
  element2.addEventListener("click", function(e) {
      sortTable(2);
      tr = table.getElementsByTagName("tr")[0];
      span = tr.getElementsByTagName("span")[2];
      if (elem2 == true) {
        span.innerHTML = "Approved By <i class='la la-arrow-up'></i>";
        elem2 = false;
      } else {
        span.innerHTML = "Approved By <i class='la la-arrow-down'></i>";
        elem2 = true;
      }
  }, false);

  var elem3 = true;
  var element3 = document.getElementsByClassName('m-datatable__cell')[3];
  element3.addEventListener("click", function(e) {
      sortTable(3);
      tr = table.getElementsByTagName("tr")[0];
      span = tr.getElementsByTagName("span")[3];
      if (elem3 == true) {
        span.innerHTML = "Type <i class='la la-arrow-up'></i>";
        elem3 = false;
      } else {
        span.innerHTML = "Type <i class='la la-arrow-down'></i>";
        elem3 = true;
      }
  }, false);

  var elem4 = true;
  var element4 = document.getElementsByClassName('m-datatable__cell')[4];
  element4.addEventListener("click", function(e) {
      sortTable(4);
      tr = table.getElementsByTagName("tr")[0];
      span = tr.getElementsByTagName("span")[4];
      if (elem4 == true) {
        span.innerHTML = "Created <i class='la la-arrow-up'></i>";
        elem4 = false;
      } else {
        span.innerHTML = "Created <i class='la la-arrow-down'></i>";
        elem4 = true;
      }
  }, false);

  setTimeout(function() {
    sortTable(0);
  }, 2000);




});

function search() {
    var input, filter, table, tr, span, i;
    input = document.getElementById("generalSearch");
    filter = input.value.toUpperCase();
    table = document.getElementsByClassName('m-datatable__table')[0];
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      if (i != 0) {
        span0 = tr[i].getElementsByTagName("span")[0];
        span1 = tr[i].getElementsByTagName("span")[1];
        span2 = tr[i].getElementsByTagName("span")[2];
        span3 = tr[i].getElementsByTagName("span")[3];
        span4 = tr[i].getElementsByTagName("span")[4];
        if (span0.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else if (span1.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else if (span2.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else if (span3.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else if (span4.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
      } else {
        tr[i].style.display = "";
      }
    }
}

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementsByClassName('m-datatable__table')[0];
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

var xport = {
  _fallbacktoCSV: true,
  toXLS: function(tableId, filename) {
    this._filename = (typeof filename == 'undefined') ? tableId : filename;

    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    if (tableId == 'logs_table' || tableId == 'csv-sample') {
      var htmltable = document.getElementById(tableId);
    } else {
      var htmltable = document.getElementsByClassName(tableId)[1];
    }
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    if (tableId == 'logs_table' || tableId == 'csv-sample') {
      var csv = this._tableToCSV(document.getElementById(tableId));
    } else {
      var csv = this._tableToCSV(document.getElementsByClassName(tableId)[1]);
    }
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }

    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it

      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};

function deactivateAction(keyid, keyrecipientname) {
    if (confirm(" Are you sure you want to deactivate the key assigned to "+keyrecipientname+"?")) {

      post_data = {
        'action'     : 'deactivate',
        'keyid'      : keyid,
      };

      $.ajax({
          type: 'POST',
          url:  'controllers/index-handler.php',
          data: post_data,
          success: function() {
            location.reload();
          },
          error: function() {
            location.reload();
          }
      });
    } else {
        console.log("You pressed no.");
    }

}

function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = document.getElementsByClassName('m-datatable__table')[0];

    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 10,
        width: 700
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF
        //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
    }, margins);
}

//Functions for Users Handling
function deactivateUser(userid) {
    if (confirm("Are you sure you want to deactivate this user?")) {

      post_data = {
        'action'     : 'deactivate',
        'userid'      : userid,
      };

      $.ajax({
          type: 'POST',
          url:  'controllers/users-handler.php',
          data: post_data,
          success: function() {
            location.reload();
          }
      });
    } else {
        console.log("You pressed no.");
    }
}

function activateUser(userid) {
    if (confirm("Are you sure you want to activate this user?")) {

      post_data = {
        'action'     : 'activate',
        'userid'      : userid,
      };

      $.ajax({
          type: 'POST',
          url:  'controllers/users-handler.php',
          data: post_data,
          success: function() {
            location.reload();
          }
      });
    } else {
        console.log("You pressed no.");
    }
}

function makeSuperadmin(userid) {
    if (confirm("Are you sure you want to make this user a Super Admin? Super Admin means that the user will be able to manage other users and all keys from this zone.")) {

      post_data = {
        'action'     : 'makeSuperadmin',
        'userid'     : userid,
      };

      $.ajax({
          type: 'POST',
          url:  'controllers/users-handler.php',
          data: post_data,
          success: function() {
            location.reload();
          }
      });
    } else {
        console.log("You pressed no.");
    }
}

function makeAdmin(userid) {
    if (confirm("Are you sure you want to make this user an Admin? Admin means that the user will no longer be able to manage other users and all keys from this zone.")) {

      post_data = {
        'action'     : 'makeAdmin',
        'userid'     : userid,
      };

      $.ajax({
          type: 'POST',
          url:  'controllers/users-handler.php',
          data: post_data,
          success: function() {
            location.reload();
          }
      });
    } else {
        console.log("You pressed no.");
    }
}





//
