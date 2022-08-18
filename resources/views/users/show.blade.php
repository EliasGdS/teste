@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">Full Stack Developer</p>
                            <p class="text-muted mb-2">Bay Area, San Francisco, CA</p>
                            <button class="btn btn-danger" onclick="removeUser({{ $user->id }})">Remover</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" id="user-form">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nome</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="name" class="form-control" required
                                            value="{{ $user->name }}">
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" id="email" class="form-control" required
                                            value="{{ $user->email }}">
                                        <span id="email_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Telefone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" id="" class="form-control"
                                            value="{{ $user->phone }}">
                                        <span id="phone_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Celular</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="mobile" id="" class="form-control"
                                            value="{{ $user->mobile }}">
                                        <span id="mobile_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Endereço</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" id="" class="form-control"
                                            value="{{ $user->address }}">
                                        <span id="address_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div style="text-align: right;">
                                        <a class="btn btn-outline-dark" href="{{ route('users.index') }}">Cancelar</a>
                                        <button class="btn btn-success" type="submit">Salvar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function removeUser(id) {
            if (id == "{{ Auth::user()->id }}") {
                Swal.fire({
                    title: 'Atenção!',
                    text: "Você tem certeza que deseja remover seu próprio usuário? Caso confirme o logout será feito.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Remover',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Removido!',
                            'Usuário removido.',
                            'success'
                        );

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        let url = "{{ route('users.destroy', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(res) {},
                            error: function(reject) {}
                        }).done(() => {
                            document.getElementById('logout-form').submit();
                        });
                    }
                })
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: "Você tem certeza que deseja remover este usuário?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Remover',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Removido!',
                            'Usuário removido.',
                            'success'
                        );

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        let url = "{{ route('users.destroy', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(res) {},
                            error: function(reject) {}
                        }).done(() => {
                            table.ajax.reload();
                        });
                    }
                })
            }
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            $("#user-form").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                let form = $(this);
                let actionUrl = form.attr('action');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: actionUrl,
                    data: form.serialize(),
                    success: function(data) {

                    },
                    error: function(reject) {
                        if (reject.status === 422) {
                            let errors = $.parseJSON(reject.responseText);
                            $.each(errors.errors, function(key, val) {
                                console.log(key);
                                console.log(val[0]);
                                $("#" + key + "_error").text(val[0]);
                            });
                        }
                    }
                }).done(() => {
                    Swal.fire(
                        'Salvo!',
                        'Alterações salvas.',
                        'success'
                    )
                });

            });
        });
    </script>
@endsection
