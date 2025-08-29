@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow p-6 text-center">
    <h2 class="text-2xl font-bold mb-4">تم استلام طلبك بنجاح</h2>
    <p class="text-gray-300 mb-4">شكرًا لك! سنقوم بالتواصل قريبًا لتأكيد الطلب.</p>
    <a href="/" class="text-blue-400">العودة إلى الصفحة الرئيسية</a>
    @if(config('services.tiktok.pixel_id'))
        <script>
            if(window.ttq && typeof ttq.track === 'function'){
                ttq.track('SubmitForm');
            }
        </script>
    @endif
</div>

@endsection
