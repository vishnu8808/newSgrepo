<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Commision Details Of ') .@$data->name}}

            <div class="card border-primary shadow-lg float-end" style="width: 14rem;margin-top:-16px">
                <div class="card-body text-primary">
                    <p class="card-text">Total Payouts :{{@$total_payout}}</p>
                </div>
            </div>
        </h2>
        
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference Name</th>
                                <th>User Name</th>
                                <th>Level</th>
                                <th>Created Date</th>
                                <th>Sales Amount</th>
                                <th>Payout</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>

<script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('com.list')}}',  // Replace with your endpoint route
            type: 'GET',
        },
        searching: true,  // Disable search bar
        paging: false,     // Disable pagination
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'sales_name', name: 'sales_name'},
            {data: 'name', name: 'name'},
            {data: 'level_name', name: 'level_name'},
            {data: 'created_date', name: 'date'},
            {data: 'sales_amount', name: 'sales_amount'},
            {data: 'com_amount', name: 'com_amount'},
            
        ]
    });
    
});



</script>