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
        <!-- Main Dashboard Container -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 1.5rem;">
            <!-- Header Section -->
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.8rem; font-weight: 600; color: #1a1f36; margin-bottom: 0.5rem;">Bank Dashboard</h1>
                <p style="color: #6b7280; margin: 0;">Welcome back, Bank Officer!</p>
            </div>

            <!-- Quick Actions -->
            <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                <button class="btn" data-bs-toggle="modal" data-bs-target="#formTopUp"
                    style="background: linear-gradient(135deg, #7F3DFF 0%, #6B2EDB 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-plus-circle-fill"></i>
                    Top Up
                </button>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#formWithdraw"
                    style="background: linear-gradient(135deg, #FF3B3B 0%, #D92B2B 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-box-arrow-up"></i>
                    Withdraw
                </button>
            </div>

            <!-- Stats Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Transaction Stats -->
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="background: rgba(127, 61, 255, 0.1); padding: 0.8rem; border-radius: 12px;">
                            <i class="bi bi-arrow-down-circle-fill" style="color: #7F3DFF; font-size: 1.5rem;"></i>
                        </div>
                        <span style="font-size: 0.875rem; background: rgba(127, 61, 255, 0.1); padding: 0.3rem 0.8rem; border-radius: 20px; color: #7F3DFF;">Active</span>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 600; margin: 0; color: #1a1f36;">{{ $allmutasi }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Total Transactions</p>
                </div>

                <!-- Customer Stats -->
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="background: rgba(0, 186, 136, 0.1); padding: 0.8rem; border-radius: 12px;">
                            <i class="bi bi-people-fill" style="color: #00BA88; font-size: 1.5rem;"></i>
                        </div>
                        <span style="font-size: 0.875rem; background: rgba(0, 186, 136, 0.1); padding: 0.3rem 0.8rem; border-radius: 20px; color: #00BA88;">Active</span>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 600; margin: 0; color: #1a1f36;">{{ $nasabah }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #6b7280;">Total Customers</p>
                </div>
            </div>

            <!-- Request Transactions Section -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid #f3f4f6;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: #1a1f36; margin: 0;">Transaction Requests</h2>
                    <p style="color: #6b7280; margin: 0.25rem 0 0 0; font-size: 0.875rem;">Pending customer requests</p>
                </div>
                <div style="padding: 1rem;">
                    @foreach ($request_payment as $request)
                        <form action="{{ route('acceptRequest') }}" method="POST">
                            @csrf
                            <input type="hidden" name="wallet_id" value="{{ $request->id }}">
                            <div style="padding: 1rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: #1a1f36;">{{ $request->user->name }}</h3>
                                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">
                                        @if ($request->credit)
                                            <span style="color: #00BA88;">Top Up: Rp {{ number_format($request->credit, 0, ',', '.') }}</span>
                                        @elseif ($request->debit)
                                            <span style="color: #FF3B3B;">Withdraw: Rp {{ number_format($request->debit, 0, ',', '.') }}</span>
                                        @endif
                                    </p>
                                    <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.75rem;">{{ $request->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <button type="submit" style="background: #7F3DFF; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="bi bi-check-lg"></i>
                                    Accept
                                </button>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>

            <!-- User List Section -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1a1f36; margin: 0;">Customer List</h2>
                        <p style="color: #6b7280; margin: 0.25rem 0 0 0; font-size: 0.875rem;">Manage your customers</p>
                    </div>
                    <a href="{{ route('bank.create') }}" style="background: #7F3DFF; color: white; padding: 0.5rem 1rem; border-radius: 12px; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-plus-lg"></i>
                        Add Customer
                    </a>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9fafb;">
                                <th style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">#</th>
                                <th style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">Name</th>
                                <th style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">Role</th>
                                <th style="padding: 1rem; text-align: left; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">Email</th>
                                <th style="padding: 1rem; text-align: center; color: #6b7280; font-weight: 500; border-bottom: 1px solid #f3f4f6;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @forelse ($userAll->where('role', 'siswa') as $user)
                                <tr style="transition: background-color 0.2s;">
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $i }}</td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person" style="color: #6b7280;"></i>
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; background: #F1F5F9; color: #64748B;">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $user->email }}</td>
                                    <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <a href="{{ route('user.edit', $user) }}" style="padding: 0.5rem; border-radius: 8px; background: #F1F5F9; color: #7F3DFF; text-decoration: none;">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Delete {{ $user->name }}?')" style="padding: 0.5rem; border: none; border-radius: 8px; background: #FFE5E5; color: #FF3B3B; cursor: pointer;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">
                                        No customers available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- Top Up Modal -->
        <div class="modal fade" id="formTopUp" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('TopUpToUser') }}" method="POST" class="modal-content" style="border-radius: 16px; border: none;">
                    @csrf
                    <div class="modal-header" style="background: #7F3DFF; color: white; border: none;">
                        <h5 class="modal-title">Top Up Balance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Select Customer</label>
                            <select name="user_id" class="form-select" required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                                <option value="" disabled selected>-- Select Customer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Amount</label>
                            <input type="number" name="credit" class="form-control" placeholder="Top Up Amount" min="1000" value="10000" required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem;">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal" style="text-decoration: none; color: #6b7280;">Cancel</button>
                        <button type="submit" class="btn" style="background: #7F3DFF; color: white; border-radius: 12px; padding: 0.75rem 1.5rem;">Top Up Now</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Withdraw Modal -->
        <div class="modal fade" id="formWithdraw" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('WithdrawFromUser') }}" method="POST" class="modal-content" style="border-radius: 16px; border: none;">
                    @csrf
                    <div class="modal-header" style="background: #FF3B3B; color: white; border: none;">
                        <h5 class="modal-title">Withdraw Balance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Select Customer</label>
                            <select name="user_id" class="form-select" required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                                <option value="" disabled selected>-- Select Customer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #6b7280;">Amount</label>
                            <input type="number" name="debit" class="form-control" placeholder="Withdraw Amount" min="1000" value="10000" required style="padding: 0.75rem; border-radius: 12px; border: 1px solid #e5e7eb;">
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem;">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal" style="text-decoration: none; color: #6b7280;">Cancel</button>
                        <button type="submit" class="btn" style="background: #FF3B3B; color: white; border-radius: 12px; padding: 0.75rem 1.5rem;">Withdraw Now</button>
                    </div>
                </form>
            </div>
        </div>

        <style>
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

    @if (Auth::user()->role == 'admin')
        <!-- Main Dashboard Container -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Header Section -->
            <div style="margin-bottom: 2rem;">                                
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
                        data-target="">{{ $user }}</h3>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.8;">Total Users</p>
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
