@extends('layouts.auth')

@section('content')
@endsection

@push('after-scripts')
    <script>
        window.location.href = '{{ url('') }}';
    </script>
@endpush