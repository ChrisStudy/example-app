<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel Import Export CSV and Display with Filter - Chris XIONG</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">  
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="container">
	<h1 class="text-center">Laravel CSV Import and Display with Filter - Chris XIONG</h1>
    <section class="import-section w-full max-w-lg">
        <form class="grid grid-flow-row bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4 mt-4 items-center " action="{{ route('import') }}" method="POST" name="importform"
        enctype="multipart/form-data">
            <h2 class="title text-center">Import your csv file below</h2>
            @csrf
            <div class="mb-4 form-group">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file"></label>
                <span class="sr-only">Choose your csv</span>
                <input id="file" type="file" name="file" class="form-control block w-full text-sm text-slate-500
                                                                file:mr-4 file:py-4 file:px-8
                                                                file:rounded-full file:border-0
                                                                file:text-lg file:font-semibold
                                                                file:bg-blue-500 file:text-white
                                                                hover:file:bg-blue-700">
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-full focus:outline-none focus:shadow-outline btn btn-success">Import</button>
        </form>
    </section>

    <section class="display-section bg-white shadow-lg px-8 py-8">
        <h2 class="title text-center">Offices List</h2>
    <div class="card-body">
    <div class="max-w-full flex flex-row content-between">
        <div class="basis-1/4">
            <div class="w-full max-w-md form-group">
                <label><strong>Number of Offices:</strong></label>
                <select id="office" class="form-control">
                    <option value="">All</option>
                    @foreach ($office_array as $office)
                    <option value="{{ $office}}">{{ $office}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="basis-1/4">
            <div class="w-full max-w-md form-group">
                <label><strong>Number of Tables:</strong></label>
                <select id="table" class="form-control">
                    <option value="">All</option>
                    @foreach ($table_array as $table)
                    <option value="{{ $table}}">{{ $table}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="basis-1/4">
            <label><strong>Price Range:</strong></label>
            <div class="w-full max-w-md form-group flex flex-row">
                <select id="price_a" class="form-control">
                    <option value="">All</option>
                    @foreach ($price_array as $price)
                    <option value="{{ $price}}">{{ $price}}</option>
                    @endforeach
                </select>
                <select id="price_b" class="form-control">
                    <option value="">All</option>
                    @foreach ($price_array as $price)
                    <option value="{{ $price}}">{{ $price}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="basis-1/4 ">
        <label><strong>Size Range:</strong></label>
                <div class="w-full max-w-md form-group flex flex-row">
                        <select id="size_a" class="form-control">
                            <option value="">All</option>
                            @foreach ($sqm_array as $sqm)
                            <option value="{{ $sqm}}">{{ $sqm}}</option>
                            @endforeach
                        </select>
                        <select id="size_b" class="form-control">
                            <option value="">All</option>
                            @foreach ($sqm_array as $sqm)
                            <option value="{{ $sqm}}">{{ $sqm}}</option>
                            @endforeach
                        </select>
                </div>
        </div>
            </div>
            </div>
            <table class="border-collapse rounded table table-bordered data-table-offices my-10">
                <thead>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Offices</th>
                    <th>Tables</th>
                    <th>Sqm</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div>    You have total of : {{$offices->count()}} office(s).</div>
    </section>
</div>
</body>
<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    var table = $('.data-table-offices').DataTable({
        processing: true,
        serverSide: true,
        "emptyTable":     "No data available in table",
        "infoEmpty":      "Showing 0 to 0 of 0 offices",
        "zeroRecords":    "No matching offices found",
        "language": {
                    "search": "Office Name:",
                    "lengthMenu": "Display _MENU_ offices"
                    },
        ajax: {
          url: "{{ route('office.filter') }}",
          data: function (d) {
                d.office = $('#office').val(),
                d.table = $('#table').val(),
                d.search = $('input[type="search"]').val(),
                d.price_a = $('#price_a').val(),
                d.price_b = $('#price_b').val(),
                d.size_a = $('#size_a').val(),
                d.size_b = $('#size_b').val()
            }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'offices', name: 'offices'},
            {data: 'tables', name: 'tables'},
            {data: 'sqm', name: 'sqm'},
        ]
    }); 
    $('#office').change(function(){
        table.draw();
    });
    $('#table').change(function(){
    table.draw();
    });
    $('#price_a').change(function(){
        table.draw(); 
    });
    $('#price_b').change(function(){
        table.draw(); 
    })
    $('#size_a').change(function(){
        table.draw(); 
    });
    $('#size_b').change(function(){
        table.draw(); 
    })
  });
</script> 

</html>