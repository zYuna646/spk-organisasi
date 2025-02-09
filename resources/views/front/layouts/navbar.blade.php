<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
        <a  href="{{ url('/') }}">
            <img src="{{ asset('assets/front/img/logo.png') }}" style="width: 100" height="100" alt="Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            @if (Route::is('home'))
            <ul class="nav">
                <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                <li class="scroll-to-section"><a href="#services">Catalog</a></li>
                <li class="scroll-to-section"><a href="#contact-section">Keranjang</a></li>
                <li class="scroll-to-section"><a href="#contact-section">History</a></li>
                <li class="scroll-to-section"><a href="#testimonials">Testimonials</a></li>
                <li class="scroll-to-section"><a href="#contact-section">Contact Us</a></li>
                @auth
                    @if (auth()->user()->role == 'admin')
                        <li class="scroll-to-section"> <a href="{{ route('admin.dashboard') }}">
                                Back to Dashboard &nbsp;
                                <i class="fa-solid fa-arrow-right"></i>
                            </a></li>
                    @else
                        <li class="scroll-to-section">
                            <form action="{{ route('logout') }}" method="post" class="d-inline">
                                @csrf
                                @method('post')

                                <button type="submit"
                                    style="color: #fff; background-color: transparent; border-radius: 10px;"
                                    onclick="return confirm('Are you sure you want to logout?')">
                                    <span class="sr-only">Logout</span>
                                    <span class="btn-text">Logout</span>
                                    <i class="fa-solid fa-user"></i>
                                </button>

                            </form>
                        </li>
                    @endif
                @endauth


                @guest
                    <a href="{{ route('login') }}" class="btn btn-nav-link"
                        style="color: #fff; background-color: transparent; border-radius: 10px;">
                        <i class="fas fa-user"></i>&nbsp;
                        Login
                    </a>
                @endguest
            </ul>


                <div>
                    <a class="btn btn-nav-link" href="{{ route('catalog') }}">
                        <i class="fa-solid fa-table-list"></i>&nbsp;
                        Catalog
                    </a>
                    <a class="btn btn-nav-link" href="{{ route('cart') }}">
                        <i class="fas fa-shopping-cart"></i>&nbsp;
                        Keranjang
                    </a>
                    @auth
                        @if (auth()->user()->role == 'admin')
                            <a class="btn btn-nav-link2" href="{{ route('admin.dashboard') }}">
                                Back to Dashboard &nbsp;
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @else
                            <form action="{{ route('logout') }}" method="post" class="d-inline">
                                @csrf
                                @method('post')

                                <button type="submit" class="btn btn-sm btn-black"
                                    onclick="return confirm('Are you sure you want to logout?')">
                                    <span class="sr-only">Logout</span>
                                    <span class="btn-text">Logout</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </form>
                        @endif
                    @endauth

                    @guest
                        <a class="btn btn-nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user"></i>&nbsp;
                            Login
                        </a>
                    @endguest
                </div>
            @else
                <div class="ms-auto">
                    <a class="btn btn-nav-link" href="{{ url('/') }}">
                        <i class="fa-solid fa-home"></i>&nbsp;
                        Home
                    </a>
                    @if (Route::is('product.detail'))
                        <a class="btn btn-nav-link" href="{{ url('/catalog') }}">
                            <i class="fa-solid fa-table-list"></i>&nbsp;
                            Catalog
                        </a>
                    @endif

                    @auth
                        @if (auth()->user()->role == 'admin')
                            <a class="btn btn-nav-link2" href="{{ route('admin.dashboard') }}">
                                Back to Dashboard &nbsp;
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @else
                            <form action="{{ route('logout') }}" method="post" class="d-inline">
                                @csrf
                                @method('post')

                                <button type="submit" class="btn btn-sm btn-black"
                                    onclick="return confirm('Are you sure you want to logout?')">
                                    <span class="sr-only">Logout</span>
                                    <span class="btn-text">Logout</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </form>
                        @endif
                    @endauth

                    @guest
                        <a class="btn btn-nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user"></i>&nbsp;
                            Login
                        </a>
                    @endguest
                </div>
            @endif
        </div>
    </div>
</nav>
