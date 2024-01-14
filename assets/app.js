/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
window.$ = window.jQuery = $;

import './dist/olixbo.js';

import Routing from "./dist/scripts/routing";
import "devbridge-autocomplete";

$('#sdSearch').autocomplete({
  serviceUrl: Routing.generate('sidebar_autocomplete'),
  onSelect: function (suggestion) {
      console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
  }
});



//import './scripts/switch-theme';

/*
const webpack = require('webpack')

environment.plugins.append('Provide',
    new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        Popper: ['popper.js', 'default']
    })
)

module.exports = environment
 
 */


/*
$(document).ready(function () {

  var selector = "#sg-datatables-server_datatable";
  var oTable;

  var defaults = {
  };

  var language = {

  };

  var ajax = {

    "serverSide": true,
    "ajax": $.fn.dataTable.pipeline({
      "method": "GET",

      "pages": 10
    }),
  };

  var options = {
    "order": [[0, "asc"]],
    "orderCellsTop": true,


  };

  var features = {
  };

  var callbacks = {
  };

  var extensions = {




  };

  var columns = {
    "columns": [
      {
        "title": "Id",
        "searchable": false,
        "visible": true,
        "orderable": true,

        "data": "id",
      },
      {
        "title": "Hostname",
        "searchable": true,
        "visible": true,
        "orderable": true,

        "data": "hostname",
      },
      {
        "defaultContent": "",
        "title": "Adresse IP",
        "searchable": true,
        "visible": true,
        "orderable": true,

        "data": "addrip.ip",
      },
      {
        "title": "Virtuel",
        "searchable": false,
        "visible": true,
        "className": "text-center",
        "orderable": true,

        "data": "virtual",
      },
      {
        "title": "Environnement",
        "searchable": true,
        "visible": true,
        "orderable": true,

        "data": "environment",
      },
      {
        "defaultContent": "",
        "title": "OS",
        "searchable": false,
        "visible": true,
        "orderable": false,

        "data": "os",
      },
      {
        "defaultContent": "",
        "searchable": false,
        "visible": false,
        "className": "never ",
        "orderable": true,

        "data": "operatingSystem.name",
      },
      {
        "defaultContent": "",
        "searchable": false,
        "visible": false,
        "className": "never ",
        "orderable": true,

        "data": "operatingSystem.bits",
      },
      {
        "defaultContent": "",
        "searchable": false,
        "visible": false,
        "className": "never ",
        "orderable": true,

        "data": "operatingSystem.version",
      },
      {
        "defaultContent": "",
        "searchable": false,
        "visible": false,
        "className": "never ",
        "orderable": true,

        "data": "operatingSystem.additional",
      },
      {
        "title": "Statut",
        "searchable": false,
        "visible": true,
        "orderable": true,

        "data": "state",
      },
      {
        "title": "Supprim\u00e9",
        "searchable": false,
        "visible": true,
        "orderable": true,

        "data": "deletedAt",
      },
      {
        "searchable": false,
        "visible": true,
        "className": "text-right text-nowrap",
        "orderable": false,

        "data": "12",
      },
    ]
  };

  var initialSearch = {
    "searchCols": [
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
    ]
  };

  function postCreateDatatable(pipeline) {
  }

  function createDatatable() {
    $.extend(defaults, language);
    $.extend(defaults, ajax);
    $.extend(defaults, options);
    $.extend(defaults, features);
    $.extend(defaults, callbacks);
    $.extend(defaults, extensions);
    $.extend(defaults, columns);
    $.extend(defaults, initialSearch);

    if (!$.fn.dataTable.isDataTable(selector)) {
      $(selector)
        ;

      oTable = $(selector)
        .DataTable(defaults)
        .on('draw.dt', function () { postCreateDatatable(10) })
        ;

      function drawTable() {
        oTable.clearPipeline().draw();
      }

      var search = $.fn.dataTable.util.throttle(
        function (event) {
          if (event.type == "keyup") {
            if (
              event.keyCode == 37 ||
              event.keyCode == 38 ||
              event.keyCode == 39 ||
              event.keyCode == 40 ||
              event.keyCode == 16 ||
              event.keyCode == 17 ||
              event.keyCode == 18
            )
              return;
          }

          oTable
            .column($(event.currentTarget).data("search-column-index"))
            .search($(this).val());
          drawTable();
        },
        options.searchDelay
      );

      $(selector + '-filterrow').find("input.sg-datatables-individual-filtering").on("keyup change", search);

      $(selector + '-filterrow').find("select.sg-datatables-individual-filtering").on("keyup change", function (event) {
        var searchValue = $(this).val();
        searchValue = searchValue ? searchValue.toString() : '';
        oTable
          .column($(event.currentTarget).data("search-column-index"))
          .search(searchValue);
        drawTable();
      });
    }
  }

  createDatatable();

});*/