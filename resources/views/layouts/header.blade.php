 <nav class="main-header navbar navbar-expand-md navbar-light bg-white shadow-sm">

     <!-- ロゴ -->


     <!-- トップメニュー -->

         <!-- Left Side Of Navbar -->
         <ul class="navbar-nav mr-auto">
             <li>
                 <a href="#"  class="nav-link" data-widget="pushmenu" role="button">
                     <i class="fas fa-bars"></i>
                 </a>
             </li>
         </ul>

         <!-- Right Side Of Navbar -->
         <ul class="navbar-nav ml-auto">
             <!-- Authentication Links -->
             @guest
             <li class="nav-item">
                 <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
             </li>
             @else
             <li class="nav-item">
                 <div id="navbarDropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                         {{ __('ログアウト') }}
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </li>
             @endguest
         </ul>
 </nav>