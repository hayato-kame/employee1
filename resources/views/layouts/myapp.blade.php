<!DOCTYPE html>
<html>
<head>
   <title>@yield('title')</title>
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
   <style>
   body {font-size:16pt; color:#999; margin: 5px; }
   h1 { font-size:50pt; text-align:right; color:#f6f6f6;
       margin:-20px 0px -30px 0px; letter-spacing:-4pt; }
   ul { font-size:12pt; }
   hr { margin: 25px 100px; border-top: 1px dashed #ddd; }
   .menutitle {font-size:14pt; font-weight:bold; margin: 0px; }
   .content {margin:10px; }
   .footer { text-align:right; font-size:10pt; margin:10px;
       border-bottom:solid 1px #ccc; color:#ccc; }
    table {
        border-collapse: collapse; border: solid 2px #999;
    }
    th {background-color: #0099ff; color:fff; padding:5px 10px; }
    td {border: solid 1px #aaa; color:#999; padding:5px 10px; }
    a { text-decoration: none; }
    /* 特定のセルだけボーダーなし */
    .noborder {
    border: 0px none; 
    }

   </style>
</head>
<body>
   <h1>@yield('title')</h1>
   @section('menubar')
   <h2 class="menutitle">※メニュー</h2>
   <ul>
       <li>@show</li>
   </ul>
   <hr size="1">
   <div class="content">
   @yield('content')
   </div>
   <div class="footer">
   @yield('footer')
   </div>

   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>

</body>
</html>
