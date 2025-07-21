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
                    <h4 class="heading mb-4 text-center">Banner Ads</h4>

                    <!-- Responsive & rounded Bootstrap table -->
                    <div class="table-responsive rounded shadow-sm">
                        <table class="table table-striped table-bordered table-hover align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Title</th>
                                    <th>Poster</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($record as $sub)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $sub['title'] ?? 'N/A' }}</td>
                                        <td>
                                            <img src="{{ $sub['poster'] ?? '' }}" width="120"
                                                class="img-fluid rounded" />
                                        </td>
                                        <td>
                                            @if ($sub['status'] == 1)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('advertiser.banner_ad.report', $sub['id']) }}"
                                                class="btn btn-outline-warning btn-sm" title="View Report">
                                                <i class="fas fa-file-alt fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-muted">No records found.</td>
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
