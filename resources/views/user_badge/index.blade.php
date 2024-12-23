@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/badge-style.css') }}">
@endsection
@section('content')
    <section class="container">
        <div class="container py-5 mb-5">
            <h1 class="heading text-center mb-4">Badges</h1>
            @if (isset($data['data']['badges']) && $data['data']['badges'])
                <div class="row gap-2 mt-2 mb-4 d-flex justify-content-center">
                    <div class="col-xxl-3 col-xl-3">
                        <div class="card custom-card border-0 shadow-sm rounded-lg">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <!-- Badge Icon -->
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-award theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                                {{ $data['data']['total_points'] }}
                                            </h5>
                                        </div>
                                        <p class="mb-0 fs-10 card-heading">Total Points</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3">
                        <div class="card custom-card border-0 shadow-sm rounded-lg">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <!-- Badge Icon -->
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 32%;">
                                            <i class="fa-solid fa-award theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                                {{ $data['data']['current_month_points'] }}
                                            </h5>
                                        </div>
                                        <p class="mb-0 fs-10 card-heading">Current Month Points</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3">
                        <div class="card custom-card border-0 shadow-sm rounded-lg" style="cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#referralModal">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <!-- Badge Icon -->
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2"
                                            style="background-color: var(--bgcolor); border-radius: 50%;">
                                            <i class="fa-solid fa-share-from-square theme-active-color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="fw-semibold mb-1 lh-1 theme-active-color">
                                                Referral Link
                                            </h5>
                                        </div>
                                        <p class="mb-0 fs-10 card-heading">Click to view and copy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="referralModalLabel">Your Referral Link</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p id="referralLink" class="mb-3 text-truncate">{{ $data['data']['referral_link'] }}</p>
                                    <button id="copyButton" class="auth app-secondary-btn rounded">Copy Link</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 d-flex justify-content-center">
                    @foreach ($data['data']['badges'] as $badge)
                        <!-- Badge Card -->
                        <div class="col-10 col-md-6 col-lg-3">
                            <div
                                class="badge-card {{ isset($badge['details']['completed_at']) && $badge['details']['completed_at'] ? 'active' : 'inactive' }}">
                                <div class="card-img-top d-flex justify-content-center align-items-center">
                                    <div class="icon-container py-2">
                                        <img src="{{ asset($badge['icon']) }}" alt="Badge Icon" class="card-img">
                                    </div>
                                </div>
                                <div class="badge-details">
                                    <div class="badge-title">{{ $badge['title'] ?? 'N/A' }}</div>
                                    <div class="row">
                                        <div class="col-md-6 p-0">
                                            <p class="point-title">Points: <span
                                                    class="badge-points">{{ $badge['points'] ?? 0 }}</span></p>
                                        </div>
                                        <div class="col-md-6 p-0">
                                            <p class="point-title">Achieved: <span
                                                    class="badge-points">{{ $badge['details']['achieved_points'] ?? 0 }}</span>
                                            </p>
                                        </div>
                                        @php
                                            $remaining = $badge['details']['achieved_points'] ?? 0;
                                            $remaining = $badge['milestone'] - $remaining;
                                        @endphp
                                        <div class="col-md-6 p-0">
                                            <p class="point-title">Remaining: <span
                                                    class="badge-points">{{ $remaining ?? 0 }}</span></p>
                                        </div>
                                        <div class="col-md-6 p-0">
                                            <p class="point-title">Milestone: <span
                                                    class="badge-points">{{ $badge['milestone'] ?? 0 }}</span></p>
                                        </div>
                                    </div>
                                    @if (isset($badge['details']['completed_at']) && $badge['details']['completed_at'])
                                        <span style="color: var(--themeActiveColor);font-size: 0.9rem;font-weight: bold;">
                                            Completed:
                                            {{ Carbon\Carbon::parse($badge['details']['completed_at'])->format('d-m-Y') }}
                                        </span>
                                        <span class="completed-badge">
                                            Completed
                                        </span>
                                    @else
                                        <span class="incomplete-badge">
                                            Incomplete
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <div class="d-flex justify-content-center mt-4 mb-4">
                    <h4 class="heading text-center">No badges available at the moment. Please check back later.</h4>
                </div>
            @endif
        </div>

    </section>
    <!-- JavaScript to Copy Link -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButton = document.getElementById('copyButton');
            const referralLink = document.getElementById('referralLink').innerText;

            copyButton.addEventListener('click', function() {
                // Create a temporary input element
                const tempInput = document.createElement('input');
                tempInput.value = referralLink;
                document.body.appendChild(tempInput);

                // Select and copy the text
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices
                navigator.clipboard.writeText(tempInput.value)
                    .then(() => {
                        // Change button text to "Copied!"
                        const originalText = copyButton.innerText;
                        copyButton.innerText = 'Copied!';

                        // Revert button text back after 1 second
                        setTimeout(() => {
                            copyButton.innerText = originalText;
                        }, 1000);
                    })
                    .catch((err) => {
                        alert('Failed to copy: ' + err);
                    });

                // Remove the temporary input element
                document.body.removeChild(tempInput);
            });
        });
    </script>
@endsection
