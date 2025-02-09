@extends('front.layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .copy-link-button {
            display: inline-block;
            width: fit-content;
            padding: 6px 10px;
            font-size: 14px;
            background-color: var(--light-color);
            color: var(--dark-color);
            outline: none;
            border: none;
        }

        .toast-success {
            background-color: #000 !important;
            /* Set your custom background color here */
        }
    </style>
@endpush

@section('content')
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <section class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="header-text">
                        <h2>Selamat Datang Di Web SIJAGO!</h2>
                        <h6>Sistem Informasi Penjadwalan Kegiatan Organisasi Kepemudaan
                            Platform yang dirancang untuk mempermudah pengelolaan jadwal kegiatan organisasi kepemudaan
                            secara efisien dan transparan.
                            Silahkan melakukan pendaftaran untuk mendapatkan informasi lebih lengkap</h6>

                        <div class="main-button-gradient">
                            <div class="scroll-to-section"><a href={{ route('register') }}>Daftar!</a></div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-image">
                        <img src="assets/images/banner-right-image.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->
    <section class="gallery" id="berita">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-title" data-aos="fade-down">
                        <div class="text-center">
                            <div class="section-heading">
                                <h4>Berita SIJAGO</h4>
                            </div>
                        </div>
                    </div>
                    <div class="content-body" data-aos="fade-up">
                        {{-- <div class="categories-links">
                            <span class="category-link category-active" data-name="All">All</span>
                            @foreach (App\Models\Berita::all() as $category)
                                <span class="category-link" data-name="{{ $category->slug }}">{{ $category->name }}</span>
                            @endforeach

                        </div> --}}

                        <div class="galleries">
                            @foreach (App\Models\Berita::all() as $berita)
                                <div class="gallery-img" data-name="{{ $berita->title }}">
                                    <img src="{{ asset('storage/' . $berita->cover) }}" alt="gallery-img">
                                    <div class="gallery-overlay">
                                        <h4 class="mb-0">{{ $berita->title }}</h4>
                                        {{-- <span>Category</span> <!-- You can replace 'Category' if needed --> --}}
                                        <div class="gallery-button mt-2">
                                            {{-- <a href="{{ route('berita.detail', $berita->id) }}"> --}}
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            </a>
                                            {{-- <button type="button" class="copy-link-button" data-link="{{ route('berita.detail', $berita->id) }}">
                                                <i class="fa-solid fa-link"></i>
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="simple-cta" id="tentang">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 offset-lg-1">
                    <div class="left-image">
                        <img src="{{asset('assets/front/img/logo.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <h4>Apa Itu Si Jago?</h4>
                    <p>SIJAGO (Sistem Informasi Penjadwalan Kegiatan Organisasi Kepemudaan) adalah platform berbasis web
                        yang dirancang untuk mempermudah pengelolaan jadwal kegiatan organisasi kepemudaan di bawah naungan
                        Dinas Pemuda dan Olahraga Provinsi Gorontalo. SIJAGO membantu dalam pengajuan proposal kegiatan
                        secara online, monitoring status pengajuan secara real-time, penentuan prioritas kegiatan, hingga
                        pelaporan kegiatan kepemudaan. Sistem ini hadir untuk meningkatkan efisiensi, transparansi, dan
                        kolaborasi antara Dispora dan organisasi kepemudaan.</p>
                    {{-- <div class="white-button">
                        <a href="contact-us.html">View Courses</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        {{-- <h6>Testimonials</h6> --}}
                        <h4>Fitur-Fitur SIJAGO</h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="owl-testimonials owl-carousel" style="position: relative; z-index: 5;">
                        <div class="item">
                            <h4>Pengelolaan Jadwal Kegiatan</h4>
                            {{-- <span>CEO &amp; Founder</span> --}}
                            <img src="assets/images/quote.png" alt="">
                            <p>Membantu mengatur dan menjadwalkan kegiatan organisasi kepemudaan dengan lebih terstruktur
                                dan efisien.</p>

                        </div>
                        <div class="item">
                            <h4>Pengajuan Proposal Kegiatan</h4>
                            {{-- <span>CEO &amp; Founder</span> --}}
                            <img src="assets/images/quote.png" alt="">
                            <p>Memantau status pengajuan proposal secara real-time untuk mengetahui apakah sudah diproses
                                atau masih dalam tahap evaluasi.</p>

                        </div>
                        <div class="item">
                            <h4>Monitoring Status Pengajuan</h4>
                            {{-- <span>CEO &amp; Founder</span> --}}
                            <img src="assets/images/quote.png" alt="">
                            <p>Memungkinkan organisasi kepemudaan mengajukan proposal kegiatan secara online langsung ke
                                Dispora.</p>

                        </div>
                        <div class="item">
                            <h4>Penentuan Prioritas Kegiatan</h4>
                            {{-- <span>CEO &amp; Founder</span> --}}
                            <img src="assets/images/quote.png" alt="">
                            <p>Menentukan kegiatan yang akan dilaksanakan terlebih dahulu berdasarkan kriteria waktu, skala,
                                dan relevansi.</p>

                        </div>
                        <div class="item">
                            <h4>Laporan Kegiatan;
                            </h4>
                            {{-- <span>CEO &amp; Founder</span> --}}
                            <img src="assets/images/quote.png" alt="">
                            <p>Memudahkan organisasi untuk membuat dan mengunggah laporan kegiatan setelah kegiatan selesai
                                dilaksanakan..</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-us" id="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div id="map">

                        <!-- You just need to go to Google Maps for your own map point, and copy the embed code from Share -> Embed a map section -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7151.84524236698!2d-122.19494600413192!3d47.56605883252286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5490695e625f8965%3A0xf99b055e76477def!2sNewcastle%20Beach%20Park%20Playground%2C%20Bellevue%2C%20WA%2098006%2C%20USA!5e0!3m2!1sen!2sth!4v1644335269264!5m2!1sen!2sth"
                            width="100%" height="420px" frameborder="0"
                            style="border:0; border-radius: 15px; position: relative; z-index: 2;"
                            allowfullscreen=""></iframe>
                        <div class="row">
                            <div class="col-lg-4 offset-lg-1">
                                <div class="contact-info">
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <h4>Phone</h4>
                                    <span>010-020-0340</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="contact-info">
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <h4>Mobile</h4>
                                    <span>090-080-0760</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="contact" action="" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>Contact us</h6>
                                    <h4>Say <em>Hello</em></h4>
                                    <p>IF you need a working contact form by PHP script, please visit TemplateMo's
                                        contact page for more info.</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="name" name="name" id="name" placeholder="Full Name"
                                        autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                        placeholder="Your Email" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" id="message" placeholder="Your Message"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-gradient-button">Send
                                        Message</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <p class="copyright">Copyright © 2022 EduWell Co., Ltd. All Rights Reserved.

                        <br>Design: <a rel="sponsored" href="https://templatemo.com" target="_blank">TemplateMo</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <!-- Include Clipboard.js and SweetAlert libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Clipboard.js
            new ClipboardJS('.copy-link-button', {
                text: function(trigger) {
                    return $(trigger).attr('data-link');
                }
            });

            // Add a success event listener to show a Toastr toast notification
            $('.copy-link-button').on('click', function(e) {
                showCopySuccessNotification();
            });

            function showCopySuccessNotification() {
                // Show a Toastr toast notification
                toastr.success('Link Copied!', null, {
                    timeOut: 1500,
                    positionClass: 'toast-bottom-left',
                    progressBar: true,
                });
            }
        });
    </script>
@endpush
