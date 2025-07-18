@extends('layouts.app')

@section('content')
    <style>
        .heading {
            color: var(--themeActiveColor);
            font-weight: 700;
        }
    </style>
     @include('advertiser_banner_ads.nav-bar')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Home arrow icon button -->
                    <div class="mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm" title="Back to Home">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <!-- Title -->
                    <h4 class="heading mb-4 text-center">Video Ads</h4>

                    <!-- Responsive & rounded Bootstrap table -->
                    <div class="table-responsive rounded shadow-sm">
                        <table class="table table-striped table-bordered table-hover align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Created</th>
                                    <th>Url</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($record as $sub)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $sub['name'] ?? 'N/A' }}</td>
                                        <td>{{ $sub['vast_type'] ?? 'N/A' }}</td>
                                        <td class="text-nowrap">
                                            {{ isset($sub['created_at']) ? \Carbon\Carbon::parse($sub['created_at'])->diffForHumans() : '-' }}
                                        </td>
                                        <td class="text-start">
                                            <input type="text" class="form-control text-black"
                                                value="{{ $sub['vast_type'] === 'internal' ? 'http://onlinechannel.io/vast-tags/' . $sub['id'] . '/xml' : $sub['vast_url'] ?? 'N/A' }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('advertiser.video_ad.report', $sub['id']) }}"
                                                class="btn btn-outline-warning btn-sm" title="View Report">
                                                <i class="fas fa-file-alt fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
