import "datatables.net";
import "datatables-responsive";
import "datatables.net-dt";
import "datatables.net-bs4";
import "datatables.net-scroller";
import "datatables.net-buttons";

export default {
    "dom": 'Bfrtip',
    "buttons": [
        'copy', 'csv', 'excel', 'pdf'
    ],
    "processing": true,
    "language": {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
    },
    "searching": true,
    "serverSide": true,
    "paging":true,
    "sAjaxDataProp": "data",
    "pageLength": 50,
    "length": 40,
    "deferRender": true,
    "scrollY": "600px",
    "scrollCollapse": true,
    "scrollX":     false,
    "scroller": {
        "loadingIndicator": true
    },
    ajax:           {},
    "columnDefs":[],
    "fnDrawCallback": function () {

    }
}