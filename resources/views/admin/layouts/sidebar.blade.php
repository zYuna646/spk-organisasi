<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="text-nowrap">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/front/img/logo.jpg') }}" width="50">
                    <h4 class="mb-0 px-2 fw-bolder">Dashboard</h4>
                </div>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar border-top overflow-hidden" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'dashboard') active @endif"
                        href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role->slug === 'admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Master Data</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link @if ($active == 'berita') active @endif"
                            href="{{ route('admin.berita.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category-2"></i>
                            </span>
                            <span class="hide-menu">Berita</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link @if ($active == 'organisasi') active @endif"
                            href="{{ route('admin.organisasi.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category-2"></i>
                            </span>
                            <span class="hide-menu">Organisasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link @if ($active == 'dispora') active @endif"
                            href="{{ route('admin.dispora.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category-2"></i>
                            </span>
                            <span class="hide-menu">Kabid</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role->slug == 'organisasi')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengajuan</span>
                    </li>
                @else
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Verifikasi</span>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'proposal') active @endif"
                        href="{{ route('admin.proposal.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">Proposal</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'kegiatan') active @endif"
                        href="{{ route('admin.kegiatan.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">Kegiatan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'laporan') active @endif"
                        href="{{ route('admin.laporan.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>
                @if (Auth::user()->role->slug != 'organisasi')
                    <li class="sidebar-item">
                        <a class="sidebar-link @if ($active == 'rangking') active @endif"
                            href="{{ route('admin.rangking.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category-2"></i>
                            </span>
                            <span class="hide-menu">Ranking</span>
                        </a>
                    </li>
                @endif

                {{-- <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'catalog') active @endif" href="{{ route('admin.catalog') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-brand-appgallery"></i>
                        </span>
                        <span class="hide-menu">Catalog</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'gallery') active @endif" href="{{ route('admin.gallery') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-cards"></i>
                        </span>
                        <span class="hide-menu">Gallery</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'video') active @endif" href="{{ route('admin.video') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-brand-youtube"></i>
                        </span>
                        <span class="hide-menu">Video</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'information') active @endif" href="{{ route('admin.information') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-news"></i>
                        </span>
                        <span class="hide-menu">Information</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Settings</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'about-us') active @endif" href="{{ route('admin.about-us') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-info-hexagon"></i>
                        </span>
                        <span class="hide-menu">About Us</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'main-slider') active @endif" href="{{ route('admin.main-slider') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-slideshow"></i>
                        </span>
                        <span class="hide-menu">Main Slider</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'review-slider') active @endif" href="{{ route('admin.review-slider') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-slideshow"></i>
                        </span>
                        <span class="hide-menu">Review Slider</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if ($active == 'account-setting') active @endif" href="{{ route('admin.account-setting') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-cog"></i>
                        </span>
                        <span class="hide-menu">Account Setting</span>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
