<?php

namespace App\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\OrderResource;
use Filament\Support\Facades\FilamentView;
use Outerweb\FilamentTranslatableFields\Filament\Plugins\FilamentTranslatableFieldsPlugin;

class FilamentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login() // Enable Filament login (works with Breeze)
            ->colors([
                'primary' => Color::hex('#00f6ff'), // Neon blue for futuristic look
                'gray' => Color::Gray,
            ])
            ->brandName('FutureDrop Admin') // Custom name
            ->favicon(asset('favicon.ico')) // Optional favicon
            ->viteTheme([
                'resources/css/filament.css', // Custom CSS for neon styling
            ])
            ->plugins([
                FilamentTranslatableFieldsPlugin::make()
                    ->supportedLocales(['ar', 'en']) // Support Arabic & English
            ])
            ->resources([
                ProductResource::class, // Products CRUD
                OrderResource::class,   // Orders CRUD with export
            ])
            ->middleware([
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            ])
            ->renderHook('panels::body.start', fn () => view('filament.hooks.rtl')); // RTL support
    }
}