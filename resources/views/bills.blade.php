@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="h4">All Bills</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover w-100" id="table-firms">
                            <thead>
                                <th>Bill No.</th>
                                <th>Name</th>
                                <th>Bill Date</th>
                                <th>Amount</th>
                                <th>Action</th>    
                            </thead>  
                            <tbody>
                            </tbody>  
                        </table>    
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
    <script>
        let table;
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#table-firms').DataTable( {
                ajax: {
                    url: '{{ route("bills") }}',
                },
                serverSide: true,
                processing: true,
                columns: [
                    { data: 'bill_no', width:"10%"},
                    { data: 'name' },
                    { data: 'bill_date' },
                    { data: 'final_amount' },
                    { data: 'action', searchable:false, orderable:false,  width:"7%"}
                ]
            });
        })

    </script>
@endsection