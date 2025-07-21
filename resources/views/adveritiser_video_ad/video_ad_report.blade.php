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
                        <a href="{{ route('advertiser.video_ad') }}" class="btn btn-outline-secondary btn-sm"
                            title="Back to All Video Ads">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <!-- Heading -->
                    <h4 class="heading mb-4 text-center">Video Ad Report</h4>
                    <!-- Responsive Table -->
                    <div class="table-responsive rounded overflow-auto shadow-sm">
                        <table class="table table-striped table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ad</th>
                                    <th scope="col">Views</th>
                                    <th scope="col">Skips</th>
                                    <th scope="col">Clicks</th>
                                    <th scope="col">Completed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['data']['events'] as $sub)
                                    <tr>
                                        <td>{{ $sub['id'] }}</td>
                                        <td class="text-start">{{ $sub['name'] ?? 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $sub['views'] ?? 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $sub['skips'] ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $sub['clicks'] ?? '-' }}</td>
                                      <td class="text-nowrap">{{ $sub['completed'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted">No records found.</td>
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
