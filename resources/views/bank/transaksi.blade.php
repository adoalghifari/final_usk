@extends('layout')

@section('content')

        @php
            $mutasiGroupByDate = $mutasi->groupBy(fn($item)=>$item->created_at->toDateString());
            $mutasiGroupByName = $mutasi->groupBy('user.id');
        @endphp

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

            <div class="row d-flex justify-content-center">               
                <!-- History Transaction -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            History Transaction
                        </div>
                        <div class="card-body">
                            <a href="{{ route('export.pdf.date') }}" class="btn btn-sm btn-danger mt-2" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                            @foreach ($mutasiGroupByDate as $userId => $transactions) 
                                                           
                            <ul class="list-group">

                                @foreach ($transactions as $data)
                                   <li class="list-group-item">
                                    <div>
                                        @if ($data->credit)
                                            <span class="text-success fw-bold">Credit:</span> {{ $data->credit }}
                                        @else
                                            <span class="text-danger fw-bold">Debit:</span> {{ $data->debit }}
                                        @endif
                                    </div>
                                    <div>Name: {{ $data->user->name }}</div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>{{ $data->description }} | {{ $data->created_at }}</small>
                                        
                                        @if($data->status == 'Selesai')
                                            <span class="btn btn-success p-2 m-0">
                                                {{ strtoupper($data->status) }}
                                            </span>                                    
                                        @else
                                            <span class="btn btn-warning p-2 m-0">
                                                {{ strtoupper($data->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </li>

                                   
                                @endforeach

                            </ul>

                             {{-- <a href="{{ route('export.pdf.user', $data->user->id) }}" class="btn btn-sm btn-danger mt-2" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                            </a> --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>    
@endsection