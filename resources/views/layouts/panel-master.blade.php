<!doctype html>

<body class=" sidebar_main_open sidebar_main_swipe">
  @include('partials.panel-header')
  <div class="wrapper">
  @include('partials.navbar')
  @include('partials.sidebar')
 
  <div id="app" >
  @yield('content')
  </div>
  </div> 
 

  @include('partials.footer')
 
   </body>
    @include('partials.panel-scripts')
    @stack('scripts')
</html>