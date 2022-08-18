@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Lista de Usuários</span>
                            <button class="btn btn-sm btn-success"
                                onclick="$('#createUserModal').modal('show');">Adicionar</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive px-1">
                            <table id="table_id" class="table table-striped mb-2">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th style="text-align: right;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST" id="user-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModalLabel">Criar Novo Usuário</h5>
                            <button type="button" class="btn-close" onclick="$('#createUserModal').modal('hide');">

                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="edit-name">Nome</label>
                                <input type="name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <span id="name_error" class="text-danger"></span>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="edit-email">Email</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                <span id="email_error" class="text-danger"></span>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="edit-email">Senha</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}" required autocomplete="password">
                                <span id="password_error" class="text-danger"></span>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="edit-email">Confirme a Senha</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation"
                                    value="{{ old('password_confirmation') }}" required
                                    autocomplete="password_confirmation">
                                <span id="password_confirmation_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" type="button"
                                onclick="$('#createUserModal').modal('hide');">Fechar</button>
                            <button type="button" class="btn btn-success" type="submit"
                                onclick="$('#user-form').submit();">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var table;

        function loadTable() {
            table = $('#table_id').DataTable({
                responsive: true,
                ajax: {
                    url: "{{ route('users.get-users') }}",
                    type: "GET",
                },
                searching: true,
                columns: [{
                        data: 'name',
                        name: 'Nome',
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'Email',
                        searchable: true
                    },
                    {
                        data: 'actions',
                        name: 'Ações',
                        ordenable: false
                    }
                ],
                pagingType: "full_numbers",
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json",
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: 'ft<"pagination-bottom"lp>',
                "initComplete": function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }

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
            loadTable();

            $("#user-form").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                e.stopPropagation();

                let form = $(this);
                let actionUrl = form.attr('action');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    'data': form.serialize(),
                    success: function(res) {
                        console.log(res);
                        $('#createUserModal').modal('hide');
                        $('#user-form')[0].reset();
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
                    table.ajax.reload();

                    Swal.fire(
                        'Adicionado!',
                        'Usuário adicionado.',
                        'success'
                    )
                });
            });
        });
    </script>
@endsection
