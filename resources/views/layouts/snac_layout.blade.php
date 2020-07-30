<!DOCTYPE html>
<html>
<head>
    <title>SNAC Vocabulary: @yield('title')</title>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

<!-- Helper Scripts -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Select Upgrades -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/js/select2.min.js"></script>
<link rel="stylesheet" href="{{env('SNAC_URL')}}/css/select2-bootstrap.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- SNAC Styles -->
<link rel="stylesheet" href="{{env('SNAC_URL')}}/css/snac.css">

 <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>

<!-- SNAC Javascript -->
<script src="{{env('SNAC_URL')}}/javascript/vocab_admin.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/save_actions.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/select_loaders.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/scripts.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/relation_search.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/html2canvas.js"></script>
<script src="{{env('SNAC_URL')}}/javascript/feedback.js"></script>


<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>



<script>
    $(document).ready( function() {
        $('#concept-table').DataTable();
    })
</script>



</head>
<body role="document">
@include('layouts.navigation')


<div class="container snac" role="main">
@yield('hello')
@yield('content')
</div>
@include('layouts.generic_footer')
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
