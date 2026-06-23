---
feature: mdb-to-material-web
status: delivered
specs: []
plans:
  - docs/compose/plans/2026-06-23-mdbootstrap-to-material-web.md
branch: main
commits: pending
---

# MDB to @material/web Migration — Final Report

## What Was Built

Migrated TransitApp's UI from MDB (Material Design Bootstrap) to `@material/web` (Google's official Material Design Web Components library). The migration removes the commercial MDB dependency and replaces it with the official, standards-based Material Design implementation.

All pages (Terminals Index, Terminals Form, Transit Lines Index, Transit Lines Form) now use Material Web Components exclusively for form inputs, buttons, icons, and interactive elements. Bootstrap layout classes are retained for grid and spacing utilities.

## Architecture

### Libraries

| Library | Version | Purpose | Status |
|---------|---------|---------|--------|
| `@material/web` | v2.4.1 | Material Design 3 components | Primary UI library |
| `material-symbols` | v0.43.0 | Material Design icons | Icon system |
| `tailwindcss` | v4.0.0 | Utility CSS (with `tw:` prefix) | Layout utilities |
| `@fortawesome/fontawesome-free` | v7.2.0 | Font Awesome icons | Kept for compatibility |
| `toastr` | v2.1.4 | Toast notifications | Kept |

**Removed:**
- `mdb-ui-kit` v9.3.0 — MDB Bootstrap library

### Component Mapping

| Old (MDB) | New (Material Web) |
|-----------|-------------------|
| `x-mdb.input` (text) | `<md-outlined-text-field>` |
| `x-mdb.input` (select) | `<md-outlined-select>` + `<md-select-option>` |
| `btn btn-primary` | `<md-filled-button>` |
| `btn btn-outline-secondary` | `<md-outlined-button>` |
| `fas fa-*` icons | `<md-icon>` |
| `x-mdb.collapse` | Alpine.js `x-data` + `x-show` + `x-collapse` |
| `x-mdb.btn-group` | `<div class="d-flex gap-2">` |

### Files Changed

| File | Change |
|------|--------|
| `package.json` | Removed `mdb-ui-kit` dependency |
| `resources/css/bootstrap.css` | Removed MDB CSS import |
| `resources/js/bootstrap.js` | Removed MDB JS imports, kept Material Web imports |
| `resources/views/layouts/app.blade.php` | Updated navbar to use Bootstrap collapse |
| `resources/views/components/mdb/*` | Deleted (4 files) |

### Files Unchanged (Already Using Material Web)

- `resources/views/pages/terminals/⚡index/index.blade.php`
- `resources/views/pages/terminals/⚡form/form.blade.php`
- `resources/views/pages/transit-lines/index/index.blade.php`
- `resources/views/pages/transit-lines/form/form.blade.php`
- `resources/views/components/mdc/*` (Material Web wrapper components)

## Usage

### Build Commands

```bash
npm run build    # Production build
npm run dev      # Development server
```

### Component Usage

```blade
<!-- Text Input -->
<md-outlined-text-field
    name="field_name"
    label="Label"
    wire:model="field_name"
></md-outlined-text-field>

<!-- Select -->
<md-outlined-select
    name="select_name"
    label="Label"
    wire:model.live="select_name"
>
    <md-select-option value="" disabled selected>
        <div slot="headline">Select an option</div>
    </md-select-option>
    @foreach($options as $value => $label)
        <md-select-option value="{{ $value }}">
            <div slot="headline">{{ $label }}</div>
        </md-select-option>
    @endforeach
</md-outlined-select>

<!-- Buttons -->
<md-filled-button type="submit">
    <md-icon slot="icon">save</md-icon>
    Save
</md-filled-button>

<md-outlined-button href="{{ route('index') }}" wire:navigate>
    <md-icon slot="icon">arrow_back</md-icon>
    Back
</md-outlined-button>

<!-- Icons -->
<md-icon>edit</md-icon>
<md-icon>delete</md-icon>
```

## Verification

- **Build:** `npm run build` succeeds (exit 0, 277 modules transformed)
- **MDB References:** 0 found in `resources/` directory
- **MDB Components:** All deleted from `resources/views/components/mdb/`
- **MDB Data Attributes:** All removed (`data-mdb-*`)
- **Package.json:** `mdb-ui-kit` removed from dependencies

## Journey Log

- [pivot] Started with MDB + Tailwind混合, professor required official Material Design library
- [discovery] `@material/web` was already partially integrated — Blade components in `resources/views/components/mdc/` wrapped Material Web custom elements
- [lesson] The existing pages were already using Material Web components for most elements — MDB was only used for CSS classes in layout and a few Blade components

## Source Materials

| File | Role | Notes |
|------|------|-------|
| `docs/compose/plans/2026-06-23-mdbootstrap-to-material-web.md` | Implementation plan | Executed inline |
| `docs/ai/mdw-migration/README.md` | Pre-existing migration docs | Used as reference |
| `docs/ai/mdw-migration/MIGRATION-SUMMARY.md` | Migration guide | Used as reference |
