@extends('layouts.app')

@section('content')
    <style>
        .heading {
            color: var(--themeActiveColor);
            font-weight: 700;
        }
    </style>
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
                    <h4 class="heading mb-4 text-center">Overlay Ads</h4>

                    <!-- Responsive & rounded Bootstrap table -->
                    <div class="table-responsive rounded  shadow-sm">
                        <table class="table table-striped table-bordered table-hover align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Title</th>
                                    <th>Poster</th>
                                    <th>Target Url</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($record as $sub)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $sub['title'] ?? 'N/A' }}</td>
                                        <td>
                                            <img src="{{ $sub['image'] ?? '' }}" width="120"
                                                class="img-fluid rounded" />
                                        </td>
                                            <td class="text-start">{{ $sub['target_url'] ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('advertiser.overlay_ad.report', $sub['id']) }}"
                                                class="btn btn-outline-warning btn-sm" title="View Report">
                                                <i class="fas fa-file-alt fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted">No records found.</td>
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
