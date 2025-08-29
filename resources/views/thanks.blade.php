@extends('layouts.app')
@section('title', 'تم الطلب بنجاح')

@section('content')
<section class="max-w-xl mx-auto p-8 text-center">
  <div class="bg-green-900 border border-green-700 rounded-lg p-6 mb-6">
    <div class="text-6xl mb-4">✅</div>
    <h2 class="text-3xl font-bold mb-2 text-green-100">تمام! استلمنا طلبك 👌</h2>
    <p class="opacity-80 text-green-200">هنكلمك قريب جدًا لتأكيد الطلب وربما ترسل لك كود تتبع.</p>
  </div>

  <div class="space-y-4">
    <a href="/" class="inline-block bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
      العودة للرئيسية
    </a>
    <p class="text-sm opacity-60">
      شكرًا لك على ثقتك فينا! 🎉
    </p>
  </div>
</section>

@if (config('services.tiktok.pixel_id'))
<script>
ttq.track('SubmitForm', {
  content_name: 'Order Submitted',
  content_category: 'Purchase'
});
</script>
@endif
@endsection
