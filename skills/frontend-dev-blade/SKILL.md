---
name: frontend-dev-blade
description: Enforces structured Laravel Blade views, utility-first Tailwind CSS classes, responsive design guidelines, and clean client-side scripts.
---

# Frontend Blade & Tailwind Skill

## Overview
This skill focuses on structuring beautiful, responsive frontends using Laravel Blade, Tailwind CSS, and lightweight JS libraries (Alpine.js or Vanilla JavaScript). It ensures consistency, ease of maintenance, and mobile accessibility.

## Frontend Guidelines

### 1. Layout Structure & Components
- Use a main layout file (e.g., `layouts/app.blade.php`) containing HTML boilerplate, font imports, and Vite assets (`@vite(['resources/css/app.css', 'resources/js/app.js'])`).
- Extract repeated UI segments (cards, badge statuses, inputs, buttons) into reusable **Blade Components** (`resources/views/components/...`) that accept `$attributes->merge([...])`.
- Ensure all forms have appropriate validation error display templates (`@error('fieldname') <span class="text-red-500 text-xs">...</span> @enderror`).

### 2. Styling with Tailwind CSS
- Always design **mobile-first** (default styles apply to mobile, prefix with `md:`, `lg:` for larger viewports).
- Leverage standard grids for layouts (e.g. catalog list, stats dashboard cards).
- Maintain structural visual hierarchy through proper font weight, layout padding, and color tokens.
- Rely on Tailwind configuration custom theme extension if needed, or define color mappings directly in CSS.

### 3. JavaScript Integration
- Use **Alpine.js** or **Vanilla JS** for light DOM manipulations (such as toggling filters, opening/closing the sidebar, or validating email formats on client-side).
- Prevent full-page reloads for AJAX triggers (like checking coupon codes, requesting Midtrans snap tokens, or searching products).

### 4. Interactive Popups & Integration
- Properly load external javascript assets (like the Midtrans Snap JS library: `<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="...">`) when in checkout, to allow trigger-on-click modals.
- Handle checkout modal events (`onSuccess`, `onPending`, `onError`, `onClose`) gracefully and redirect users to correct feedback pages.

## Common Mistakes
- **Neglecting validation states**: Not showing validation errors on input elements or showing them in unreadable positions.
- **Overloading external JS**: Loading heavy external libraries when vanilla browser features or Alpine.js can achieve the same result.
- **Direct inline styles**: Hardcoding inline styling instead of using utility classes or component configurations.
