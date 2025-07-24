@extends('layouts.app')

@section('content')
<div class="container py-5" style="color: var(--themePrimaryTxtColor);">
    @if ($email)
        <h4 class="text-center">The relevant information has been sent to your email!</h4>
    @else
        <form action="" method="GET">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Enter your email address</label>
                <input type="email" class="form-control text-black" name="email" placeholder="name@example.com" required>
            </div>
            <Button type="submit" class="app-primary-btn rounded">Submit</Button>
        </form>
    @endif
</div>
@endsection