@extends('layouts.app')

@section('title', $product->name)

@push('head')
    @php
        $description = \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160, '…');
        $url = route('product.show', $product->slug);
        $imagePath = $product->image_path ?: 'products/default.jpg';
        $imageUrl = asset($imagePath);
    @endphp
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $url }}">

    <!-- Open Graph -->
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
@endpush

@section('content')
<div class="container mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-8">
        <div>
            @php
                $basePath = $product->image_path ?: 'products/default.jpg';
                $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $basePath);
            @endphp
            <picture>
                <source type="image/webp" srcset="{{ asset($webpPath) }}">
                <img src="{{ asset($basePath) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-md" loading="lazy">
            </picture>
        </div>
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <div class="text-2xl font-semibold text-green-500 mb-4">{{ number_format($product->price, 2) }} EGP</div>
            <div class="prose dark:prose-invert mb-6">
                {!! $product->description !!}
            </div>

            <form method="POST" action="{{ route('orders.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" id="utm_source" name="utm_source">
                <input type="hidden" id="utm_campaign" name="utm_campaign">
                <input type="hidden" id="utm_adset" name="utm_adset">
                <input type="hidden" id="utm_ad" name="utm_ad">

                {{-- Honeypot Field --}}
                <div class="hidden">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website" autocomplete="off">
                </div>

                <div>
                    <label for="customer_name" class="block mb-1">الاسم الكامل</label>
                    <input type="text" id="customer_name" name="customer_name" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="phone" class="block mb-1">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label for="address" class="block mb-1">العنوان</label>
                    <textarea id="address" name="address" rows="3" class="w-full p-2 border rounded" required></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-3 px-4 rounded hover:bg-blue-700">اطلب الآن</button>

                @if ($errors->any())
                    <div class="text-red-500 text-sm mt-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    document.getElementById('utm_source').value = params.get('utm_source') || '';
    document.getElementById('utm_campaign').value = params.get('utm_campaign') || '';
    document.getElementById('utm_adset').value = params.get('utm_adset') || '';
    document.getElementById('utm_ad').value = params.get('utm_ad') || '';
});
</script>
@endsection
