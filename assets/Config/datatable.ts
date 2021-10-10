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
    "scrollY": false,
    "scrollCollapse": true,
    "scrollX":     false,
    "scroller": {
        "loadingIndicator": true
    },
    ajax:           {},
    "columnDefs":[],
    /*"drawCallback": function ( settings ) {
        var api = this.api();
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;
       
        api.column(groupColumn, {page:'current'} ).data().each( function ( group, i, arr ) {
            if ( last !== group ) {
             
                $(rows).eq( i ).before(
                    `<tr class="group">
                        <td colspan="5">`+group+`</td>
                        <td>`+arr.toArray().filter(x => x==group).length+`</td>
                    </tr>`
                );
               
                last = group;
            }
        } );
    }*/
    "fnDrawCallback": function () {
    }
}
