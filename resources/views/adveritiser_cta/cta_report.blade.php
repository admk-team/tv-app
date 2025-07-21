@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/add-report-pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/badge-style.css') }}">
@endsection

@section('content')
    @php use Illuminate\Pagination\Paginator; @endphp

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('advertiser.cta') }}" class="btn btn-outline-secondary btn-sm"
                            title="Back to Call To Actions">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <!-- Heading -->
                    <h4 class="heading mb-4 text-center">Call To Actions Report</h4>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">
                        <!-- Total Clicks -->
                        <div class="col">
                            <div class="card custom-card border-0 shadow-sm rounded-lg">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-mouse-pointer theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                            {{ $data['data']['totalClicks'] }}</h5>
                                        <p class="mb-0 fs-10 card-heading">Total Clicks</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unique Clicks -->
                        <div class="col">
                            <div class="card custom-card border-0 shadow-sm rounded-lg">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-fingerprint theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                            {{ $data['data']['totalUniqueClicks'] }}</h5>
                                        <p class="mb-0 fs-10 card-heading">Unique Clicks</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Impressions -->
                        <div class="col">
                            <div class="card custom-card border-0 shadow-sm rounded-lg">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-eye theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                            {{ $data['data']['totalImpressions'] }}</h5>
                                        <p class="mb-0 fs-10 card-heading">Total Impressions</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unique Impressions -->
                        <div class="col">
                            <div class="card custom-card border-0 shadow-sm rounded-lg">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-eye-slash theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                            {{ $data['data']['totalUniqueImpressions'] }}</h5>
                                        <p class="mb-0 fs-10 card-heading">Unique Impressions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Responsive Table -->
                    <div class="table-responsive rounded overflow-auto shadow-sm">
                        <table class="table table-striped table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Event Type</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Media</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['data']['events'] as $sub)
                                    <tr>
                                        <td>{{ $sub['id'] }}</td>
                                        <td class="text-nowrap">{{ $sub['event_type'] ?? 'N/A' }}</td>
                                          <td class="text-nowrap">{{ $sub['user']['name'] ?? 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $sub['stream']['title'] ?? 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $sub['country_name'] ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $sub['plateform'] ?? '-' }}</td>
                                        <td class="text-nowrap">
                                            {{ isset($sub['created_at']) ? \Carbon\Carbon::parse($sub['created_at'])->diffForHumans() : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Custom Pagination -->
                    <div class="custom-pagination mt-4">
                        {{ $data['data']['events']->onEachSide(1)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
