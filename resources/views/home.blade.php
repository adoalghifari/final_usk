@extends('layout')

@section('content')
    @if (Auth::user()->role == 'siswa')
        <!-- Main Dashboard Container -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 1.5rem;">
            <!-- Balance Card -->
            <div
                style="background: linear-gradient(135deg, #7F3DFF 0%, #6B2EDB 100%); border-radius: 24px; padding: 2rem; color: white; margin-bottom: 2rem; box-shadow: 0 10px 20px rgba(127, 61, 255, 0.2);">
                <p style="margin: 0 0 0.5rem 0; font-size: 1rem; opacity: 0.9;">Available Balance</p>
                <h1 style="font-size: 2.5rem; font-weight: 600; margin: 0 0 1.5rem 0;">Rp
                    {{ number_format($saldo, 0, ',', '.') }}</h1>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button
                        style="
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    color: white;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    cursor: pointer;
                    transition: all 0.2s;"
                        data-bs-toggle="modal" data-bs-target="#formTopUp">
                        <i class="bi bi-plus-circle-fill"></i>
                        Top Up
                    </button>

                    <button
                        style="
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    color: white;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    cursor: pointer;
                    transition: all 0.2s;"
                        data-bs-toggle="modal" data-bs-target="#formTransfer">
                        <i class="bi bi-arrow-left-right"></i>
                        Transfer
                    </button>

                    <button
                        style="
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    color: white;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    cursor: pointer;
                    transition: all 0.2s;"
                        data-bs-toggle="modal" data-bs-target="#formwithdraw">
                        <i class="bi bi-box-arrow-up"></i>
                        Withdraw
                    </button>

                    <a href="{{ route('export.pdf.user', Auth::id()) }}"
                        style="
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    color: white;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    text-decoration: none;
                    cursor: pointer;
                    transition: all 0.2s;">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Export PDF
                    </a>
                </div>
            </div>

            <!-- Transaction History -->
            <div
                style="background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="padding: 1.5rem; border-bottom: 1px solid #f3f4f6;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: #1a1f36; margin: 0;">Transaction History</h2>
                </div>

                <div style="max-height: 500px; overflow-y: auto;">
                    @foreach ($mutasi as $data)
                        <div
                            style="padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; gap: 1rem; align-items: center;">
                                <div
                                    style="background: {{ $data->credit ? '#E7F9F0' : '#FFE5E5' }}; padding: 0.8rem; border-radius: 12px;">
                                    <i class="bi {{ $data->credit ? 'bi-arrow-down-circle-fill' : 'bi-arrow-up-circle-fill' }}"
                                        style="color: {{ $data->credit ? '#00BA88' : '#FF3B3B' }}; font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 500; color: #1a1f36;">
                                        {{ $data->description }}
                                    </p>
                                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                                        {{ $data->created_at->format('d M Y, H:i') }}
                                    </p>
                                    @if ($data->status == 'Proses')
                                        <span
                                            style="display: inline-block; padding: 0.25rem 0.5rem; background: #FFF4DE; color: #FFB020; border-radius: 20px; font-size: 0.75rem; margin-top: 0.25rem;">
                                            PROCESSING
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-weight: 600; margin: 0; color: {{ $data->credit ? '#00BA88' : '#FF3B3B' }};">
                                    {{ $data->credit ? '+Rp ' . number_format($data->credit, 0, ',', '.') : '-Rp ' . number_format($data->debit, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modals -->
            <!-- Top Up Modal -->
            <div class="modal fade" id="formTopUp" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('TopUp') }}" method="POST" class="modal-content"
                        style="border-radius: 16px; border: none;">
                        @csrf
                        <div class="modal-header" style="background: #7F3DFF; color: white; border: none;">
                            <h5 class="modal-title">Top Up Balance</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 2rem;">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Amount</label>
                                <input type="number" name="credit" class="form-control" min="10000" value="10000"
                                    required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem;">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; color: #6b7280;">Cancel</button>
                            <button type="submit" class="btn"
                                style="background: #7F3DFF; color: white; border-radius: 12px; padding: 0.75rem 1.5rem;">Top
                                Up Now</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Withdraw Modal -->
            <div class="modal fade" id="formwithdraw" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('withdraw') }}" method="POST" class="modal-content"
                        style="border-radius: 16px; border: none;">
                        @csrf
                        <div class="modal-header" style="background: #7F3DFF; color: white; border: none;">
                            <h5 class="modal-title">Withdraw Balance</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 2rem;">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Amount</label>
                                <input type="number" name="debit" class="form-control" min="10000" value="10000"
                                    required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem;">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; color: #6b7280;">Cancel</button>
                            <button type="submit" class="btn"
                                style="background: #7F3DFF; color: white; border-radius: 12px; padding: 0.75rem 1.5rem;">Withdraw
                                Now</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transfer Modal -->
            <div class="modal fade" id="formTransfer" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('transfer') }}" method="POST" class="modal-content"
                        style="border-radius: 16px; border: none;">
                        @csrf
                        <div class="modal-header" style="background: #7F3DFF; color: white; border: none;">
                            <h5 class="modal-title">Transfer Balance</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 2rem;">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Select
                                    Recipient</label>
                                <select name="recipient_id" class="form-select" required
                                    style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Amount</label>
                                <input type="number" name="amount" class="form-control" min="10000" required
                                    style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem;">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; color: #6b7280;">Cancel</button>
                            <button type="submit" class="btn"
                                style="background: #7F3DFF; color: white; border-radius: 12px; padding: 0.75rem 1.5rem;">Transfer
                                Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            /* Hover effects for buttons */
            button:hover,
            a:hover {
                opacity: 0.9;
                transform: translateY(-2px);
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb {
                background: #7F3DFF;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #6B2EDB;
            }

            /* Modal animations */
            .modal.fade .modal-dialog {
                transition: transform 0.3s ease-out;
            }

            .modal.fade .modal-dialog {
                transform: scale(0.95);
            }

            .modal.show .modal-dialog {
                transform: scale(1);
            }
        </style>
    @endif

    @if (Auth::user()->role == 'bank')
        <div class="container my-4">
            <div class="row mb-4">
                <div class="col-md-6">

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
                    <div class="p-3 border rounded shadow-sm bg-gradient-ovo">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-arrow-down-circle-fill text-white me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="text-white">{{ $allmutasi }}</h5>
                                <p class="mb-0 text-white-50">Mutasi Transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded shadow-sm bg-gradient-ovo">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle text-white me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="text-white">{{ $nasabah }}</h5>
                                <p class="mb-0 text-white-50">Customers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Export --}}
            <div class="row mb-4">
                <div class="col-md-12 text-end">

                </div>
            </div>

            <div class="row d-flex justify-content-center">
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
                                        @php
                                            $i = 1;

                                        @endphp
                                        @forelse ($userAll->where('role', 'siswa') as $user)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Hapus {{ $user->name }}?')"
                                                            title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
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
        <!-- Main Dashboard Container -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Header Section -->
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.8rem; font-weight: 600; color: #1a1f36; margin-bottom: 0.5rem;">Dashboard Overview
                </h1>
                <p style="color: #6b7280; margin: 0;">Welcome back, Admin!</p>
            </div>

            <!-- Stats Cards Section -->
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Total Users Card -->
                <div
                    style="background: linear-gradient(135deg, #7F3DFF 0%, #6B2EDB 100%); border-radius: 20px; padding: 1.5rem; color: white; box-shadow: 0 10px 20px rgba(127, 61, 255, 0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="background: rgba(255, 255, 255, 0.2); padding: 0.8rem; border-radius: 12px;">
                            <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i>
                        </div>
                        <span
                            style="font-size: 0.875rem; background: rgba(255, 255, 255, 0.2); padding: 0.3rem 0.8rem; border-radius: 20px;">Active</span>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 600; margin: 0;" class="count-up"
                        data-target="{{ $user }}">0</h3>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.8;">Total Users</p>
                </div>
            </div>

            <!-- Transaction History Section -->
            <div
                style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; overflow: hidden;">
                <div
                    style="padding: 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1a1f36; margin: 0;">Transaction History
                        </h2>
                        <p style="color: #6b7280; margin: 0.25rem 0 0 0; font-size: 0.875rem;">Recent activities</p>
                    </div>
                    <a href="{{ route('export.pdf.date') }}"
                        style="background: #b40000; color: white; padding: 0.5rem 1rem; border-radius: 12px; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </a>
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                    <div style="padding: 1rem;">
                        @forelse ($mutasi as $data)
                            <div
                                style="padding: 1rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <div
                                        style="background: {{ $data->credit ? '#E7F9F0' : '#FFE5E5' }}; padding: 0.8rem; border-radius: 12px;">
                                        <i class="bi {{ $data->credit ? 'bi-arrow-down-circle-fill' : 'bi-arrow-up-circle-fill' }}"
                                            style="color: {{ $data->credit ? '#00BA88' : '#FF3B3B' }}; font-size: 1.25rem;"></i>
                                    </div>
                                    <div>
                                        <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: #1a1f36;">
                                            {{ $data->user->name }}</h3>
                                        <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                                            {{ $data->description }}</p>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <p
                                        style="font-weight: 600; margin: 0; color: {{ $data->credit ? '#00BA88' : '#FF3B3B' }};">
                                        {{ $data->credit ? '+' . $data->credit : '-' . $data->debit }}
                                    </p>
                                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.75rem;">
                                        {{ $data->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 2rem;">
                                <p style="color: #6b7280; margin: 0;">No transactions yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Users Table Section -->
            <div
                style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <div
                    style="padding: 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1a1f36; margin: 0;">User Management</h2>
                        <p style="color: #6b7280; margin: 0.25rem 0 0 0; font-size: 0.875rem;">Manage your users</p>
                    </div>
                    <a href="{{ route('user.create') }}"
                        style="background: #7F3DFF; color: white; padding: 0.5rem 1rem; border-radius: 12px; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-plus-lg"></i>
                        Add User
                    </a>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9fafb;">
                                <th
                                    style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">
                                    #</th>
                                <th
                                    style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">
                                    Name</th>
                                <th
                                    style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">
                                    Role</th>
                                <th
                                    style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">
                                    Email</th>
                                <th
                                    style="padding: 1rem; text-align: center; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userAll as $key => $user)
                                <tr style="transition: background-color 0.2s;">
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $key + 1 }}</td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div
                                                style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person" style="color: #6b7280;"></i>
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">
                                        <span
                                            style="
                                        padding: 0.25rem 0.75rem;
                                        border-radius: 20px;
                                        font-size: 0.875rem;
                                        background: {{ $user->role === 'admin' ? '#FFE5E5' : ($user->role === 'bank' ? '#E7F9F0' : '#F1F5F9') }};
                                        color: {{ $user->role === 'admin' ? '#FF3B3B' : ($user->role === 'bank' ? '#00BA88' : '#64748B') }};">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $user->email }}</td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <a href="{{ route('user.edit', $user) }}"
                                                style="
                                            padding: 0.5rem;
                                            border-radius: 8px;
                                            background: #F1F5F9;
                                            color: #7F3DFF;
                                            text-decoration: none;
                                            transition: all 0.2s;">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    onclick="return confirm('Delete {{ $user->name }}?')"
                                                    style="
                                                    padding: 0.5rem;
                                                    border: none;
                                                    border-radius: 8px;
                                                    background: #FFE5E5;
                                                    color: #FF3B3B;
                                                    cursor: pointer;
                                                    transition: all 0.2s;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">
                                        <img src="https://img.icons8.com/clouds/100/000000/empty-box.png"
                                            style="width: 80px; margin-bottom: 1rem; display: block; margin-left: auto; margin-right: auto;">
                                        No users available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            body {
                background: #F8F9FD;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb {
                background: #7F3DFF;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #6B2EDB;
            }

            /* Hover Effects */
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(127, 61, 255, 0.2);
            }

            tr:hover {
                background-color: #F8F9FD;
            }
        </style>
    @endif

@endsection
