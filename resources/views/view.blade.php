<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales Details Of ') .@$data->name}}
            <button  class="btn btn-success float-end" onClick="setModelFields()" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Sales</button>
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
                                <th>User Name</th>
                                <th>Level</th>
                                <th>Created Date</th>
                                <th>Sales Amount</th>
                                
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

<input type="hidden" value="{{@$data->id}}"id="user_id"/> 

<!-- Modal Structure -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sales Amount</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <!-- Name -->
            <form>
                <p style="color:red;font-size:12px;margin-bottom:10px">Note: Please enter both reference name and amount.Amount shoud be digit</p>
                <div>
                    <x-input-label for="name" :value="__('Reference Name')" />
                    <x-text-input id="ref_name" class="block mt-1 w-full" type="text" name="ref_name"  required autofocus autocomplete="ref_name" />
                </div>
                <div>
                    <x-input-label for="name" :value="__('Amount')" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="text" name="amount"  required autofocus autocomplete="amount" />           
                </div>
            </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
    var id=$('#user_id').val();
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('sales.list')}}',  // Replace with your endpoint route
            type: 'GET',
            data: function(d) {
                d.id = id;  // Send the ID via data object
            }
        },
        searching: true,  // Disable search bar
        paging: false,     // Disable pagination
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'level_name', name: 'level'},
            {data: 'created_date', name: 'date'},
            {data: 'amount', name: 'amount'}
            
        ]
    });

    // Handle delete button click
    $('body').on('click', '#save', function () {
            var user_id = $("#user_id").val(); 
            var amount = $("#amount").val(); 
            var ref_name = $("#ref_name").val();

            if(ref_name && amount){

                if (confirm("Are you sure you want to save this sale?")) {
                    $.ajax({
                        type: "POST",
                        url: "/sales/store",
                        data: {
                            "_token": "{{ csrf_token() }}" ,
                            "user_id":user_id,
                            "amount":amount,
                            "ref_name":ref_name
                        },
                        success: function (response) {
                            if (response.success) {
                                alert(response.success);
                                table.ajax.reload(); // Reload DataTable after deletion
                                $("#amount").val(''); 
                                $('#exampleModal').modal('hide');
                            } else if (response.error) {
                                alert(response.error);
                            }

                        },
                        error: function (xhr) {
                            alert('Error occurred while deleting sale');
                        }
                    });
                }
            }
    });
    
});

function setModelFields()
{
    $("#amount").val('');
    $("#ref_name").val('');  
}

document.getElementById('amount').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Remove any non-numeric characters
});

</script>