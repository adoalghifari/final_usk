@extends('layout')

@section('content')
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
@endsection
