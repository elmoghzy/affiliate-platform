@extends('layouts.app')

@section('title', 'شكراً لك')

@section('content')
<div class="container mx-auto text-center py-12">
    <h1 class="text-3xl font-bold text-green-500 mb-4">تم استلام طلبك بنجاح!</h1>
    <p class="text-lg mb-6">شكراً لك. سيقوم أحد ممثلينا بالتواصل معك قريباً لتأكيد الطلب.</p>
    <a href="/" class="text-blue-500 hover:underline">العودة إلى الصفحة الرئيسية</a>
</div>

@if(config('services.tiktok.pixel_id'))
    <script>
        if(typeof ttq !== 'undefined') {
            ttq.track('SubmitForm');
        }
    </script>
@endif
@endsection
