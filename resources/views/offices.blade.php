<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel Import Export CSV and Display with Filter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">  
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div class="container">	<h1>Laravel Import Export CSV and Display with Filter - Chris XIONG</h1>
    <section class="w-full max-w-md">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('import') }}" method="POST" name="importform"
        enctype="multipart/form-data">
            @csrf
            <div class="mb-4 form-group">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">File:</label>
                <input id="file" type="file" name="file" class="form-control">
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline btn btn-success">Import File</button>
        </form>
    </section>
<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="w-full max-w-md form-group">
                <label><strong>Number of Offices :</strong></label>
                <select id="office" class="form-control">
                    <option value="">All</option>
                    @foreach ($office_array as $office)
                    <option value="{{ $office}}">{{ $office}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="w-full max-w-md form-group">
                <label><strong>Number of Tables :</strong></label>
                <select id="table" class="form-control">
                    <option value="">All</option>
                    @foreach ($table_array as $table)
                    <option value="{{ $table}}">{{ $table}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    </div>
<table class="table table-bordered data-table">
    <thead>
            <th>Name</th>
            <th>Offices</th>
            <th>Tables</th>
            <th>Prices</th>
            <th>Sqm</th>
    </thead>
    <tbody>
    </tbody>
</table>
<p>
    Displaying {{$offices->count()}} product(s).
</p>
</div>
</body>
<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('office.filter') }}",
          data: function (d) {
                d.color = $('#color').val(),
                d.category = $('#category').val(),
                d.search = $('input[type="search"]').val()
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
  });
</script> 
</html>