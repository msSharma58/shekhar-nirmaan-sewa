<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Shekhar Nirman Sewa – Building Your Vision</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<script src="https://id-preview--9f4815ea-f792-44ff-aaf6-af607ef7b35f.lovable.app/widget.js" data-agent-id="bfc4f310-0dfc-46dc-8516-53bf5e6c462f" async></script>
@include('partials.navbar')
@include('partials.mobile-menu')

@yield('content')

@include('partials.footer')

<div id="btt" title="Back to top"><i class="fas fa-arrow-up"></i></div>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
