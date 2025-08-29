@if(app()->getLocale() === 'ar')
<style>
    .fi-body {
        direction: rtl;
    }

    .fi-sidebar {
        direction: ltr; /* Keep sidebar LTR for consistency */
    }

    .fi-topbar {
        direction: rtl;
    }

    .fi-page {
        direction: rtl;
    }

    /* RTL specific adjustments for Filament components */
    .fi-table {
        direction: rtl;
    }

    .fi-form-grid {
        direction: rtl;
    }

    .fi-dropdown-list {
        direction: rtl;
    }

    /* Adjust text alignment for RTL */
    .fi-body.rtl .fi-page-header-title {
        text-align: right;
    }

    .fi-body.rtl .fi-form-field > label {
        text-align: right;
    }

    /* RTL table adjustments */
    .fi-body.rtl .fi-table th,
    .fi-body.rtl .fi-table td {
        text-align: right;
    }

    .fi-body.rtl .fi-table th:first-child,
    .fi-body.rtl .fi-table td:first-child {
        text-align: right;
    }

    /* RTL form adjustments */
    .fi-body.rtl .fi-form-field-grid {
        direction: rtl;
    }

    .fi-body.rtl .fi-btn {
        direction: rtl;
    }
</style>
@endif
