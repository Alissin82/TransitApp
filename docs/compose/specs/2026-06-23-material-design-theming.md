# Material Design Theming Enhancement Spec

> [!NOTE]
> This document describes the design for beautifying TransitApp using Material Design theming.

## [S1] Problem

The current UI uses Material Web components and Bootstrap layout but lacks visual polish. The pages look functional but not beautiful. We need to enhance the visual appearance while:
- Staying within Material Design guidelines
- Not overriding component styles
- Maintaining RTL support
- Using official Material Design theming system

## [S2] Solution Overview

Use Material Design 3 CSS custom properties (tokens) to create a cohesive theme. Add subtle enhancements through:
1. **Color theming** — Set brand colors using `--md-sys-color-*` tokens
2. **Typography** — Configure font families using `--md-ref-typeface-*` tokens
3. **Shape** — Adjust corner radius using `--md-sys-shape-corner-*` tokens
4. **Layout enhancements** — Add subtle shadows, transitions, and spacing

## [S3] Material Design Tokens

### Color Tokens

```css
:root {
  /* Primary palette - Teal/Cyan for transit theme */
  --md-sys-color-primary: #006A6A;
  --md-sys-color-on-primary: #FFFFFF;
  --md-sys-color-primary-container: #6FF7F6;
  --md-sys-color-on-primary-container: #002020;

  /* Secondary palette */
  --md-sys-color-secondary: #4A6565;
  --md-sys-color-on-secondary: #FFFFFF;
  --md-sys-color-secondary-container: #CCE8E8;
  --md-sys-color-on-secondary-container: #051F1F;

  /* Surface colors */
  --md-sys-color-surface: #FAFDFC;
  --md-sys-color-on-surface: #191C1C;
  --md-sys-color-surface-variant: #DAE5E4;
  --md-sys-color-on-surface-variant: #3F4948;

  /* Outline */
  --md-sys-color-outline: #6F7979;
  --md-sys-color-outline-variant: #BEC9C8;
}
```

### Typography Tokens

```css
:root {
  --md-ref-typeface-brand: 'IRANSansFaNum', 'IRANSans', sans-serif;
  --md-ref-typeface-plain: 'IRANSansFaNum', 'IRANSans', system-ui, sans-serif;
}
```

### Shape Tokens

```css
:root {
  --md-sys-shape-corner-small: 8px;
  --md-sys-shape-corner-medium: 12px;
  --md-sys-shape-corner-large: 16px;
  --md-sys-shape-corner-extra-large: 28px;
}
```

## [S4] Layout Enhancements

### Card Enhancements

```css
.card {
  border: 1px solid var(--md-sys-color-outline-variant);
  border-radius: var(--md-sys-shape-corner-medium);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.2s ease;
}

.card:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
}
```

### Table Enhancements

```css
.table {
  border-collapse: separate;
  border-spacing: 0;
}

.table th {
  font-weight: 500;
  color: var(--md-sys-color-on-surface-variant);
  border-bottom: 2px solid var(--md-sys-color-outline-variant);
}

.table tbody tr:hover {
  background-color: var(--md-sys-color-surface-container-low);
}
```

### Button Spacing

```css
.d-flex.gap-2 {
  gap: 8px;
}

md-filled-button,
md-outlined-button,
md-filled-tonal-button {
  min-height: 40px;
}
```

## [S5] RTL Support

Material Web components natively support RTL through the `dir` attribute. The layout already has `dir="rtl"` on the `<html>` element.

Additional RTL considerations:
- Use `me-*` (margin-end) and `pe-*` (padding-end) Bootstrap classes instead of `ms-*`/`ps-*`
- Ensure text alignment uses `text-start`/`text-end` instead of `text-left`/`text-right`
- Material Web components automatically flip icons and layouts in RTL mode

## [S6] Documentation Reference

- **Material Web Theming:** https://material-web.dev/theming/material-theming/
- **Color System:** https://material-web.dev/theming/color/
- **Typography:** https://material-web.dev/theming/typography/
- **Shape:** https://material-web.dev/theming/shape/
- **Material Design 3:** https://m3.material.io/styles/color/overview

## [S7] Files to Modify

| File | Changes |
|------|---------|
| `resources/css/bootstrap.css` | Add Material Design tokens and layout enhancements |
| `resources/css/style.css` | Update font configuration |
| `resources/views/layouts/app.blade.php` | Minor navbar enhancements |

## [S8] Verification

After implementation:
1. Run `npm run build` — should succeed
2. Check all pages render with new theme
3. Verify RTL layout is correct
4. Verify Material Web components are styled properly
5. Verify Bootstrap layout classes still work
