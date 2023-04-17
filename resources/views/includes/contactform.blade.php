{!! Form::open(['id' => 'formContact']) !!}
                <div class="row g-3">
                    <div class="col-md-6">
                        {!! Form::text('name', null, [
                            'class' => 'form-control border-0 bg-light px-4',
                            'placeholder' => 'Nombres Completos',
                            'style' => 'height: 55px;',
                            'id' => 'name',
                            'data-name' => 'Nombres Completos',
                        ]) !!}
                    </div>

                    <div class="col-md-6">
                        {!! Form::text('phone', null, [
                            'class' => 'form-control border-0 bg-light px-4',
                            'placeholder' => 'Telefono de contacto',
                            'style' => 'height: 55px;',
                            'id' => 'phone',
                            'data-name' => 'Telefono de Contacto',
                        ]) !!}
                    </div>

                    <div class="col-md-12">
                        {!! Form::email('email', null, [
                            'class' => 'form-control border-0 bg-light px-4',
                            'placeholder' => 'Correo electronico',
                            'style' => 'height: 55px;',
                            'id' => 'email',
                            'data-name' => 'Correo Electronico',
                        ]) !!}
                    </div>

                    <div class="col-md-6">
                        {!! Form::select(
                            'city',
                            ['Ciudad', $cities->pluck('name', 'name')],
                            [],
                            [
                                'class' => 'form-select border-0 bg-light px-4 mb-3',
                                'style' => 'height: 55px;',
                                'id' => 'city',
                                'data-name' => 'Ciudad',
                            ],
                        ) !!}
                    </div>

                    {{-- <div class="col-md-6">
                        {!! Form::select(
                            'mark',
                            ['Marca Interesada', $marcaspluck],
                            [],
                            [
                                'class' => 'form-select border-0 bg-light px-4 mb-3',
                                'style' => 'height: 55px;',
                                'id' => 'mark',
                                'data-name' => 'Marca',
                            ],
                        ) !!}

                    </div>
                    <div class="col-12">
                        {!! Form::select(
                            'industry',
                            ['Industria Perteneciente', $industrypluck],
                            [],
                            [
                                'class' => 'form-select border-0 bg-light px-4 mb-3',
                                'style' => 'height: 55px;',
                                'id' => 'industry',
                                'data-name' => 'Industria',
                            ],
                        ) !!}

                    </div> --}}
                    <div class="col-12">
                        {!! Form::textarea('message', null, [
                            'class' => 'form-control border-0 bg-light px-4 py-3',
                            'placeholder' => 'Dejanos tu mensaje',
                            'rows' => '4',
                            'id' => 'message',
                            'data-name' => 'Mensaje',
                        ]) !!}
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit" id="btnSender">{{ _('Enviar mensaje') }}</button>
                    </div>
                </div>
                {!! Form::close() !!}