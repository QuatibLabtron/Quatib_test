  // ********** DataTable Common functions *******//
 
   /* To override the object kindly refer following code
            dataTableObj:{ 
            lengthMenu : [
                          [10,200,400,-1],
                          [10,200,400,"All"] // change per page values here
                         ] 
    }*/
    var common_dataTableObj = {
        responsive: false,
        "order": [],
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered to 1 from _END_ total entries)",
            "lengthMenu": "_MENU_ entries",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        "lengthMenu": [
            [100,200,400,-1],
            [100,200,400,"All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 15,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        
    }    
    //params - 
    /*
    element_id_or_class (steing), 
    url (string), 
    columns (object), 
    button (bool - optional), 
    serverside (bool - optional), 
    searchdelay (int - optional), 
    optionalParam (object - optional);
    */
    function customDatatable(element, url, columns, buttons = true, serverSide = false, delay = 1000, optParam = {})
    {
        var btn_obj = [];
        if(buttons)
        {
            btn_obj = [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
            ];
        }
        common_dataTableObj = $.extend({}, common_dataTableObj, {
            buttons: btn_obj
        });
        if(serverSide)
        {
            common_dataTableObj = $.extend({}, common_dataTableObj, {
                searchDelay: delay,
                "serverSide": true,
            });
        }   
        var dataTableObj = $.extend({}, {
                'ajax'      : url,
                'columns'   : columns
            },
            common_dataTableObj
        );
        /*if(optParam)
        {
            dataTableObj = $.extend({}, dataTableObj, optParam);
        }*/
        $(element).dataTable(dataTableObj);
    }