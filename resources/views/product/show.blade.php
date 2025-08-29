@extends('layouts.app')
@section('title', $product->name)

@push('head')
@php
  $description = \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160, '…');
  $url        = route('product.show', $product->slug);
  $imagePath  = $product->image_path ?: 'products/default.jpg';
  $imageUrl   = asset($imagePath); // تأكد من ضبط APP_URL في .env لتوليد URL مطلق
@endphp
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">

<!-- Open Graph -->
<meta property="og:type" content="product">
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $product->name }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $imageUrl }}">

<!-- JSON-LD: Product -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "image": ["{{ $imageUrl }}"],
  "description": "{{ trim(preg_replace('/\s+/', ' ', $product->description ?? '')) }}",
  "sku": "{{ $product->id }}",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "EGP",
    "price": "{{ number_format($product->price, 2, '.', '') }}",
    "availability": "https://schema.org/InStock",
    "url": "{{ $url }}"
  }
}
</script>
@endpush

@section('content')
<section class="max-w-5xl mx-auto p-6">
  <div class="grid md:grid-cols-2 gap-6 items-start">

    {{-- P14: WebP + Lazy Load --}}
    @php
      $basePath = $product->image_path ?: 'products/default.jpg';
      $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $basePath);
    @endphp
    <picture class="block">
      {{-- محاولة تقديم WebP أولاً (لو الملف موجود هيُستخدم، وإلا المتصفح هيقع على <img>) --}}
      <source type="image/webp" srcset="{{ asset($webpPath) }}">
      <img
        src="{{ asset($basePath) }}"
        alt="{{ $product->name }}"
        class="rounded-2xl w-full h-auto"
        loading="lazy"
        decoding="async"
        width="800" height="800" />
    </picture>

    <div>
      <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>
      <p class="opacity-80 mb-4">{{ $product->description }}</p>
      <div class="text-2xl font-semibold mb-6">{{ number_format($product->price, 2) }} EGP</div>

      <form method="POST" action="{{ route('orders.store') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" id="utm_source" name="utm_source">
        <input type="hidden" id="utm_campaign" name="utm_campaign">
        <input type="hidden" id="utm_adset" name="utm_adset">
        <input type="hidden" id="utm_ad" name="utm_ad">

        <input name="customer_name" placeholder="الاسم الكامل" class="w-full p-3 rounded bg-neutral-900" required>
        <input name="phone" placeholder="رقم الموبايل" class="w-full p-3 rounded bg-neutral-900" required>
        <textarea name="address" placeholder="العنوان بالتفصيل" class="w-full p-3 rounded bg-neutral-900" required></textarea>

        <button class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 font-semibold">اطلب الآن</button>
        <div style="display:none"><input name="website" autocomplete="off"></div> <!-- Honeypot -->
        @if ($errors->any())
          <div class="text-red-400 text-sm">{{ implode(' - ', $errors->all()) }}</div>
        @endif
      </form>
    </div>
  </div>
</section>

<script>
// التقاط UTM من الـ URL
const qs = new URLSearchParams(location.search);
['utm_source','utm_campaign','utm_adset','utm_ad'].forEach(k=>{
  const el=document.getElementById(k); if(el) el.value=qs.get(k)||'';
});
</script>
@endsection
@extends('layouts.app')
