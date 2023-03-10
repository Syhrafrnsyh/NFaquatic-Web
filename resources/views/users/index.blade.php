@extends('layouts.master')

@section('title')
<title>Manajemen User</title>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manajemen User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Tambah Baru</a>
                        </div>

                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Nama</td>
                                        <td>Email</td>
                                        <td>Phone</td>
                                        <td>Role</td>
                                        <td>Status</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($users as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>
                                            @foreach ($row->getRoleNames() as $role)
                                            <label for="" class="badge badge-info">{{ $role }}</label>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($row->status)
                                            <label class="badge badge-success">Aktif</label>
                                            @else
                                            <label for="" class="badge badge-default">Suspend</label>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('users.roles', $row->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-user-secret">
                                                        Role
                                                    </i>
                                                </a>
                                                <a href="{{ route('users.status', $row->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-user-circle">
                                                        Status
                                                    </i>
                                                </a>
                                                <a href="{{ route('users.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection