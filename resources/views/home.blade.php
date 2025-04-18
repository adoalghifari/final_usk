@extends('layout')

@section('content')

    @if (Auth::user()->role == 'siswa')
        <div class="card shadow-sm border-0 p-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p class="mb-0">Your Balance:</p>
                        <div class="balance-box">Rp {{ $saldo }}</div>
                    </div>
                </div>
                <div class="col text-end">
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#formTopUp">Top Up</button>
                    <button class="btn btn-info me-2" data-bs-toggle="modal"
                        data-bs-target="#formTransfer">Transfer</button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formwithdraw">Withdraw</button>
                    <a href="{{ route('report.pdf') }}" class="btn btn-outline-danger me-2">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>

                    <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="formTopUpLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('TopUp') }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="formTopUpLabel">Enter The Top Up Nominal</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="number" name="credit" class="form-control" min="10000" value="10000"
                                        required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                                    <button type="submit" class="btn btn-success">Top Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="formwithdraw" tabindex="-1" aria-labelledby="formWithdrawLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('withdraw') }}" method="POST" class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formWithdrawLabel">Withdraw</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <input type="number" name="debit" class="form-control" min="10000" value="10000"
                                    required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Transfer -->
                <div class="modal fade" id="formTransfer" tabindex="-1" aria-labelledby="formTransferLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('transfer') }}" method="POST" class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="formTransferLabel">Transfer Saldo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient_id" class="form-label">Pilih Penerima</label>
                                    <select name="recipient_id" id="recipient_id" class="form-control" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="amount" class="form-label">Jumlah Transfer</label>
                                    <input type="number" name="amount" id="amount" class="form-control"
                                        min="10000" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info">Transfer</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card bg-white shadow-sm border-0">
                    <div class="card-header border-0">
                        Mutasi Transaction
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($mutasi as $data)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if ($data->credit)
                                                <span class="text-success fw-bold">Credit : </span> Rp
                                                {{ $data->credit }}
                                            @else
                                                <span class="text-danger fw-bold">Debit : </span> Rp
                                                {{ $data->debit }}
                                            @endif
                                        </div>
                                        <div>
                                            <span>{{ $data->status == 'Proses' ? 'PROSES' : '' }}</span>
                                            @if ($data->status == 'Proses')
                                            @endif
                                        </div>
                                    </div>
                                    {{ $data->description }}
                                    <p class="text-grey">Date: {{ $data->created_at }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif

    @if (Auth::user()->role == 'bank')
        <div class="container my-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1 fw-semibold text-muted">Balance:</p>
                    <h3 class="card-text">{{ $saldo }}</h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#formTopUp">Top
                        Up</button>
                    <button class="btn btn-warning me-2" data-bs-toggle="modal"
                        data-bs-target="#formWithdraw">Withdraw</button>
                </div>
            </div>

            <!-- Modal Top Up -->
            <form action="{{ route('TopUpToUser') }}" method="POST">
                @csrf
                <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="formTopUpLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formTopUpLabel">Top Up ke User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="user_id">Pilih User</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Nasabah --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" name="credit" class="form-control" placeholder="Jumlah Top Up"
                                    min="1000" value="10000">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Top Up Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('WithdrawFromUser') }}" method="POST">
                @csrf
                <div class="modal fade" id="formWithdraw" tabindex="-1" aria-labelledby="formWithdrawLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formWithdrawLabel">Withdraw dari User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="user_id">Pilih User</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Nasabah --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" name="debit" class="form-control" placeholder="Jumlah Withdraw"
                                    min="1000" value="10000">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Withdraw Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- <!-- Modal Transfer --> --}}
            <form action="{{ route('transfer') }}" method="POST">
                @csrf
                <div class="modal fade" id="formTransfer" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Withdraw</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Pilih Penerima -->
                                <div class="mb-3">
                                    <label for="recipient_id" class="form-label">Pilih Penerima</label>
                                    <select name="recipient_id" id="recipient_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Nasabah --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jumlah Transfer -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah Withdraw</label>
                                    <input type="number" name="amount" id="amount" class="form-control"
                                        min="1000" required>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Withdraw Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded shadow-sm bg-light">
                        <h5 class="text-success">{{ $allmutasi }}</h5>
                        <p class="mb-0 text-muted">Mutasi Transaksi</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded shadow-sm bg-light">
                        <h5 class="text-success">{{ $nasabah }}</h5>
                        <p class="mb-0 text-muted">Customers</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Export --}}
            <div class="row mb-4">
                <div class="col-md-12 text-end">
                     
                </div>
            </div>

            <div class="row">
                <!-- Request Transaction -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            Request Transaction Customer
                        </div>
                        <div class="card-body">
                            @foreach ($request_payment as $request)
                                <form action="{{ route('acceptRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="wallet_id" value="{{ $request->id }}">
                                    <div class="card mb-3">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $request->user->name }}</strong><br>
                                                @if ($request->credit)
                                                    <span class="text-success">Top Up:</span> {{ $request->credit }}
                                                @elseif ($request->debit)
                                                    <span class="text-danger">Withdraw:</span> {{ $request->debit }}
                                                @endif
                                                <br>
                                                <small class="text-muted">{{ $request->created_at }}</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- History Transaction -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            History Transaction
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($mutasi as $data)
                                    <li class="list-group-item">
                                        <div>
                                            @if ($data->credit)
                                                <span class="text-success fw-bold">Credit:</span> {{ $data->credit }}
                                            @else
                                                <span class="text-danger fw-bold">Debit:</span> {{ $data->debit }}
                                            @endif
                                        </div>
                                        <div>Name: {{ $data->user->name }}</div>
                                        <div><small>{{ $data->description }} | {{ $data->created_at }}</small></div>
                                    </li>
                                    <a href="{{ route('export.pdf.user', $data->user->id) }}" class="btn btn-sm btn-danger mt-2" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a> 
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 card-hover">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0">User List</h6>
                            <a href="{{ route('bank.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg"></i> Add User
                            </a>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="userTable" class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($userAll->where('role', 'siswa') as $key => $user)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('bank.edit', $user) }}"
                                                        class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('bank.destroy', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Hapus {{ $user->name }}?')"
                                                            title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada user.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role == 'admin')
        <div class="row g-3 position-relative fade-in">

            {{-- Statistik Users --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 card-hover">
                    <div class="card-body d-flex align-items-center gap-4">
                        <div class="bg-primary rounded-circle text-white rounded-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-primary count-up" data-target="{{ $user }}">0</h4>
                            <small class="text-muted">Total Users</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History Transaksi --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 h-100 card-hover">
                    <div class="card-header py-2">
                        <h6 class="mb-0">History Transaction</h6>
                    </div>
                    <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                        <a href="{{ route('export.pdf') }}" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                        

                        <ul class="list-group list-group-flush small">
                            @forelse ($mutasi as $data)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <strong class="{{ $data->credit ? 'text-success' : 'text-danger' }}">
                                            {{ $data->credit ? 'Credit: ' . $data->credit : 'Debit: ' . $data->debit }}
                                        </strong>
                                        <small>{{ $data->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div>
                                        <strong>{{ $data->user->name }}</strong>
                                        <p class="mb-0 text-muted">{{ $data->description }}</p>
                                    </div>
                                </li>
                                <a href="{{ route('export.pdf.user', $data->user->id) }}" class="btn btn-sm btn-danger mt-2" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>                                
                            @empty
                                <li class="list-group-item text-center text-muted">Belum ada transaksi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Tabel Users --}}
            <div class="col-12">
                <div class="card shadow-sm border-0 card-hover">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                        <h6 class="mb-0">User List</h6>
                        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                            ADD USER <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table id="userTable" class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($userAll as $key => $user)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.edit', $user) }}"
                                                    class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus {{ $user->name }}?')"
                                                        title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada user.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif

@endsection
