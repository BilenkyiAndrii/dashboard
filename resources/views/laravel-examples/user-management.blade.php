@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Add, Edit, Delete features are not functional!</strong> This is a
            <strong>PRO</strong> feature! Click <strong>
            <a href="https://www.creative-tim.com/live/soft-ui-dashboard-pro-laravel" target="_blank" class="text-white">here</a></strong>
            to see the PRO product!
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Всі користувачі</h5>
                        </div>
                        <!-- Кнопка для відкриття модального вікна -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Додати користувача
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Фото
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Імя
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Мейл
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Локація
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Дата створення користувача
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Дія
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->id }}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="{{ asset($user->image) }}" class="avatar avatar-sm me-3">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->location }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d/m/y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                            <i class="fas fa-user-edit me-2" aria-hidden="true"></i>
                                        </button>

                                        <form action="{{ route('user-management.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="cursor-pointer fas fa-trash text-secondary" aria-hidden="true"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Код для виведення списку користувачів -->



<!-- Модальне вікно для створення користувача -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Ім'я</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Фото</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <div id="image-preview"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Місцезнаходження</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>

                <div class="mb-3">
                    <label for="about_me" class="form-label">Про мене</label>
                    <textarea class="form-control" id="about_me" name="about_me"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Додати користувача</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Попередній перегляд зображення
    document.getElementById('image').addEventListener('change', function (e) {
        var imagePreview = document.getElementById('image-preview');
        imagePreview.innerHTML = '';

        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (event) {
            var img = document.createElement('img');
            img.setAttribute('src', event.target.result);
            img.setAttribute('class', 'img-thumbnail');
            imagePreview.appendChild(img);
        };

        reader.readAsDataURL(file);
    });
</script>
<!-- Модальне вікно для редагування користувача -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user-management.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="edit_name" class="form-label">Ім'я</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="edit_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="edit_image" class="form-label">Фото</label>
                    <input type="file" class="form-control" id="edit_image" name="image">
                </div>

                <div class="mb-3">
                    <label for="edit_password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="edit_password" name="password">
                </div>

                <div class="mb-3">
                    <label for="edit_phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="edit_phone" name="phone" value="{{ $user->phone }}">
                </div>

                <div class="mb-3">
                    <label for="edit_location" class="form-label">Місцезнаходження</label>
                    <input type="text" class="form-control" id="edit_location" name="location" value="{{ $user->location }}">
                </div>

                <div class="mb-3">
                    <label for="edit_about_me" class="form-label">Про мене</label>
                    <textarea class="form-control" id="edit_about_me" name="about_me">{{ $user->about_me }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Оновити користувача</button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Видалення користувача</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ви впевнені, що хочете видалити користувача?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                <form id="deleteForm" action="#" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Видалити</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
