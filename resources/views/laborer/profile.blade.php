@foreach ($laborers as $laborer)
    hello {{ $laborer->name }}!
@endforeach
<br>
<a href="{{ route('logout') }}" class="nav-link px-0 link-dark"> <span class=" d-sm-inline">Logout</span> </a>
