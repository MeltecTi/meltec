<footer class="footer">
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-12 col-md-6">
                    <div class="row gx-5">
                        <div class="col-lg-4 col-md-12 pt-5 mb-5">
                            <div class="mb-3">
                                <h3>Hola mundo</h3>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <p class="mb-0">123 Street, New York, USA</p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-envelope-open text-primary me-2"></i>
                                <p class="mb-0">info@example.com</p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-telephone text-primary me-2"></i>
                                <p class="mb-0">+012 345 67890</p>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary btn-square me-2" href="{!! $twitterUrl !!}"><i
                                        class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="{!! $facebookUrl !!}"><i
                                        class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="{!! $linkedinUrl !!}"><i
                                        class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-primary btn-square" href="{!! $instagramUrl !!}"><i
                                        class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="mb-3">
                                <h3 class="text-light mb-0">{{ _('Mapa del Sitio') }}</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                @foreach ($menus as $key => $item)
                                    <a class="text-light mb-2" href="{{ $item['slug'] }}"><i
                                            class="bi bi-arrow-right text-primary me-2"></i> {{ $item['name'] }} </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="d-flex flex-column justify-content-CENTER">
                                <p class="mt-3 mb-4 text-center">
                                    {{ _('MELTEC COMUNICACIONES S.A no es un I.S.P (Proveedor de Servicios de Internet), y en consecuencia no nos asiste las obligaciones establecidas en la Ley 679 de 2001 y sus decretos reglamentarios. Sin embargo, atendiendo la obligación Constitucional y de responsabilidad social empresarial, implementamos de manera idónea en nuestra página web lo establecido en la Ley 679 de 2001 y sus decretos reglamentarios.') }}
                                </p>
                                <p class="mt-3 mb-4 text-center">
                                    {{ _('Copyright © 2023 Meltec. Todos los derechos reservados.') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-white theme-footer" style="background: #061429;">
        <div class="row">
            <div class="col-lg-4">
                {{-- <a href="{{ url('/') }}" class="navbar-brand p-0 d-block">
                    <img src="{{ asset('img/logos/Meltec.png') }}" alt="Logo Meltec" class="img-fluid w-25">
                </a> --}}
            </div>
            <div class="col-lg-8 col-md-6 justify-content-end">
                <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                    <p class="mb-0">&copy; <a class="text-white"
                            href="{{ $url }}">{{ config('app.name', 'Meltec Comunicaciones S.A') }}</a>{{ _(' Todos los derechos reservados') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Footer End -->

</footer>
