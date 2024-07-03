@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List User</h1>
        </div>
        <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
            <a href="{{ route('dashboard.viewAdd') }}" class="btn btn-primary px-5"> <i
                    class='bx bx-plus-medical pe-2'></i>Tambah</a>
        </div>

        <div class="card mb-5">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Tabel Data User
            </div>
            <div class="card-body table-responsive table-bordered">
                <table class="table table-sm table-striped table-hover" id="student-table">
                    <thead class=" text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($userData as $user)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">
                                    @if ($user->role == 1)
                                        {{ 'Admin' }}
                                    @else
                                        {{ 'Guru' }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->grade_id == null)
                                        {{ 'Admin' }}
                                    @else
                                        {{ $user->grade->grade }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('dashboard.viewEdit', $user->id) }}" class="btn btn-warning"><i
                                                class='bx bxs-message-edit'></i> Edit</a> ||
                                        <form onsubmit="return confirm('Data pengguna akan dihapus ?')"
                                            action=" {{ route('dashboard.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type=" submit" class="btn btn-danger"><i class='bx bxs-trash'></i>
                                                Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
