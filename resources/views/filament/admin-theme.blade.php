{{-- Admin panel skin — mirrors the public site's dark navy + gold palette.
     Injected via PanelsRenderHook::HEAD_END, so this <style> lands after
     Filament's generated colour block and wins the cascade. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">

<style>
    /* Exact homepage navy for the surfaces Filament paints from the gray ramp */
    :root {
        --gray-950: #070c1f;   /* navy-900 — page background            */
        --gray-900: #0a0f2c;   /* navy-800 — sidebar / topbar           */
        --gray-800: #0d142e;   /* surface-solid — cards, inputs, modals */
        --gray-700: #12275a;   /* navy-600 — borders / hovers           */
    }

    /* Serif display headings, like the site */
    .fi-header-heading,
    .fi-section-header-heading,
    .fi-modal-heading,
    .fi-simple-header-heading {
        font-family: "Cormorant Garamond", Georgia, serif;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .fi-header-heading {
        font-size: 2rem;
        line-height: 1.15;
    }

    /* Gold hairline under the top bar */
    .fi-topbar nav {
        border-bottom: 1px solid rgba(212, 175, 55, 0.22);
    }

    /* Gold accent on the active sidebar item + group labels */
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn {
        box-shadow: inset 3px 0 0 0 #d4af37;
        background-color: rgba(212, 175, 55, 0.10);
    }

    .fi-sidebar-group-label {
        color: #e7c766;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: .68rem;
    }

    /* Primary buttons: warm gold gradient with dark ink, like the site's btn--gold */
    .fi-btn.fi-color-primary {
        background-image: linear-gradient(135deg, #f2dfa0 0%, #d4af37 45%, #a87f16 100%);
        color: #0a0f2c;
        font-weight: 700;
    }

    .fi-btn.fi-color-primary:hover {
        background-image: linear-gradient(135deg, #f6e6b6 0%, #e0bd4a 45%, #b98c1e 100%);
    }

    /* Soften card corners toward the site's rounded look */
    .fi-section,
    .fi-fieldset,
    .fi-wi > *,
    .fi-modal-window {
        border-radius: 16px;
    }

    /* Login card: navy with a faint gold edge */
    .fi-simple-main {
        border: 1px solid rgba(212, 175, 55, 0.22);
        border-radius: 20px;
    }
</style>
