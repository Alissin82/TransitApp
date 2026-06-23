# MDB to @material/web Migration Plan

> [!NOTE]
> This document may not reflect the current implementation.
> See the final report for up-to-date state:
> [Final Report](../reports/mdb-to-material-web.md)

> **For agentic workers:** REQUIRED SUB-SKILL: Use compose:subagent (recommended) or compose:execute to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove mdb-ui-kit and complete migration to @material/web (Google's official Material Design library)

**Architecture:** Replace MDB Bootstrap-based Material Design with @material/web custom elements. Keep Bootstrap for layout classes, use Material Web Components for form inputs, buttons, and icons.

**Tech Stack:** Laravel 13, Livewire 4.1, @material/web v2.4.1, Tailwind CSS v4, Alpine.js

---

## Task 1: Remove mdb-ui-kit Package

**Files:**
- Modify: `package.json`

- [ ] **Step 1: Remove mdb-ui-kit from dependencies**

```json
{
  "dependencies": {
    "@fortawesome/fontawesome-free": "^7.2.0",
    "@material/web": "^2.4.1",
    "material-symbols": "^0.43.0",
    "toastr": "^2.1.4"
  }
}
```

- [ ] **Step 2: Run npm install to update lockfile**

Run: `npm install`
Expected: package-lock.json updated, mdb-ui-kit removed from node_modules

- [ ] **Step 3: Commit**

```bash
git add package.json package-lock.json
git commit -m "chore: remove mdb-ui-kit dependency"
```

---

## Task 2: Update CSS Imports

**Files:**
- Modify: `resources/css/bootstrap.css`

- [ ] **Step 1: Remove MDB CSS import**

Remove this line:
```css
@import 'mdb-ui-kit/css/mdb.rtl.min.css';
```

Keep all other imports intact:
```css
@import 'tailwindcss/theme.css' layer(theme) prefix(tw);
@import 'tailwindcss/utilities.css' layer(utilities) prefix(tw);
@import "@fortawesome/fontawesome-free/css/all.min.css";
@import '@material/web/typography/md-typescale-styles.css';
@import 'material-symbols/index.css';
@import "toastr/build/toastr.min.css";
```

- [ ] **Step 2: Verify CSS builds**

Run: `npm run build`
Expected: No CSS import errors

- [ ] **Step 3: Commit**

```bash
git add resources/css/bootstrap.css
git commit -m "chore: remove mdb-ui-kit css import"
```

---

## Task 3: Update JavaScript Imports

**Files:**
- Modify: `resources/js/bootstrap.js`

- [ ] **Step 1: Remove MDB JS imports**

Replace content of `resources/js/bootstrap.js`:
```javascript
import axios from 'axios';
import '@material/web/all.js';
import {styles as typescaleStyles} from '@material/web/typography/md-typescale-styles.js';

import toastr from 'toastr';

window.axios = axios;
window.toastr = toastr;

document.adoptedStyleSheets.push(typescaleStyles.styleSheet);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

- [ ] **Step 2: Verify JS builds**

Run: `npm run build`
Expected: No JavaScript import errors

- [ ] **Step 3: Commit**

```bash
git add resources/js/bootstrap.js
git commit -m "chore: remove mdb-ui-kit js imports"
```

---

## Task 4: Delete MDB Blade Components

**Files:**
- Delete: `resources/views/components/mdb/input.blade.php`
- Delete: `resources/views/components/mdb/table.blade.php`
- Delete: `resources/views/components/mdb/btn-group.blade.php`
- Delete: `resources/views/components/mdb/collapse.blade.php`

- [ ] **Step 1: Delete MDB component files**

```bash
rm resources/views/components/mdb/input.blade.php
rm resources/views/components/mdb/table.blade.php
rm resources/views/components/mdb/btn-group.blade.php
rm resources/views/components/mdb/collapse.blade.php
```

- [ ] **Step 2: Delete empty mdb directory if exists**

```bash
rmdir resources/views/components/mdb 2>/dev/null || true
```

- [ ] **Step 3: Commit**

```bash
git rm resources/views/components/mdb/*.blade.php
git commit -m "chore: remove mdb blade components"
```

---

## Task 5: Update Layout - Remove MDB Navbar

**Files:**
- Modify: `resources/views/layouts/app.blade.php`

- [ ] **Step 1: Update navbar to remove MDB data attributes**

Replace the navbar section in `app.blade.php`:
```html
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <md-icon-button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <md-icon>menu</md-icon>
            </md-icon-button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0 d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" width="30" height="30">
                    {{ config('app.name') }}
                </a>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
            </div>
        </div>
    </nav>
</header>
```

Note: Changed `data-mdb-collapse-init` to `data-bs-toggle="collapse"` for standard Bootstrap collapse (no MDB needed).

- [ ] **Step 2: Commit**

```bash
git add resources/views/layouts/app.blade.php
git commit -m "fix: update navbar to remove mdb data attributes"
```

---

## Task 6: Migrate Terminals Index Page

**Files:**
- Modify: `resources/views/pages/terminals/⚡index/index.blade.php`

- [ ] **Step 1: Replace MDB components with Material Web**

The page currently uses:
- `md-outlined-text-field` (already migrated)
- `md-filled-button` (already migrated)
- `md-filled-tonal-button` (already migrated)
- `md-icon` (already migrated)
- Bootstrap table classes (keep)

Replace the table section with this structure:
```blade
<div class="table-responsive">
    <table class="table table-striped table-hover table-group-divider align-middle">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>{{ __('Terminal.Attributes.Name') }}</th>
            <th>{{ __('Region.Province') }}</th>
            <th>{{ __('Region.County') }}</th>
            <th>{{ __('Region.District') }}</th>
            <th>{{ __('Region.Settlement') }}</th>
            <th>{{ __('Region.Village') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @if($terminals->count() == 0)
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        {{ __('Terminal.No Records Found') }}
                    </td>
                </tr>
            @else
                @foreach ($terminals as $terminal)
                    <tr>
                        <td>{{ $terminal->id }}</td>
                        <td>{{ $terminal->name }}</td>
                        <td>{{ $terminal->province->name }}</td>
                        <td>{{ $terminal->county->name }}</td>
                        <td>{{ $terminal->district->name }}</td>
                        <td>{{ $terminal->settlement->name }}</td>
                        <td>{{ $terminal->village->name ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <md-filled-tonal-button
                                    href="{{ route('terminals.edit', $terminal) }}"
                                    wire:navigate
                                >
                                    <md-icon slot="icon">edit</md-icon>
                                </md-filled-tonal-button>
                                <md-filled-button
                                    wire:click="delete({{ $terminal->id }})"
                                    wire:confirm="{{ __('Terminal.Record Delete Confirmation') }}"
                                >
                                    <md-icon slot="icon">delete</md-icon>
                                </md-filled-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
```

- [ ] **Step 2: Verify page renders correctly**

Check that:
- Search input works with `wire:model`
- Table displays data
- Action buttons render
- Delete confirmation shows

- [ ] **Step 3: Commit**

```bash
git add "resources/views/pages/terminals/⚡index/index.blade.php"
git commit -m "feat: migrate terminals index to material web"
```

---

## Task 7: Migrate Terminals Form Page

**Files:**
- Modify: `resources/views/pages/terminals/⚡form/form.blade.php`

- [ ] **Step 1: Update Blade component usage**

Replace `<x-mdc.text-field.outlined>` and `<x-mdc.select.outlined>` with inline Material Web components:

```blade
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <md-icon class="me-2">directions_bus</md-icon>
                {{ $terminal ? __('Terminal.Edit Record') : __('Terminal.New Record') }}
            </a>
        </h2>
        <md-outlined-button href="{{ route('terminals.index') }}" wire:navigate>
            <md-icon slot="icon">arrow_back</md-icon>
            {{ __('Back') }}
        </md-outlined-button>
    </div>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save" id="terminal-form">
                <div class="row mb-4">
                    <div class="col-12">
                        <md-outlined-text-field
                                name="name"
                                label="{{ __('Terminal.Attributes.Name') }}"
                                wire:model="name"
                                form="terminal-form"
                                class="w-100"
                        ></md-outlined-text-field>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="province_id"
                            label="{{ __('Region.Province') }}"
                            wire:model.live="province_id"
                            form="terminal-form"
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('Region.Select Province') }}</div>
                            </md-select-option>
                            @foreach($provinces as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                    <div class="col-md-6">
                        <md-outlined-select
                            name="county_id"
                            label="{{ __('Region.County') }}"
                            wire:model.live="county_id"
                            form="terminal-form"
                            @disabled(!$province_id)
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('Region.Select County') }}</div>
                            </md-select-option>
                            @foreach($counties as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="district_id"
                            label="{{ __('Region.District') }}"
                            wire:model.live="district_id"
                            form="terminal-form"
                            @disabled(!$county_id)
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('Region.Select District') }}</div>
                            </md-select-option>
                            @foreach($districts as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                    <div class="col-md-6">
                        <md-outlined-select
                            name="settlement_id"
                            label="{{ __('Region.Settlement') }}"
                            wire:model.live="settlement_id"
                            form="terminal-form"
                            @disabled(!$county_id)
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('Region.Select Settlement') }}</div>
                            </md-select-option>
                            @foreach($settlements as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="village_id"
                            label="{{ __('Region.Village') }} ({{ __('Optional') }})"
                            wire:model="village_id"
                            form="terminal-form"
                            @disabled(!$settlement_id)
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('Region.Select Village') }}</div>
                            </md-select-option>
                            @foreach($villages as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <md-filled-button type="submit">
                        <md-icon slot="icon">save</md-icon>
                        {{ $terminal ? __('Save Changes') : __('Save') }}
                    </md-filled-button>
                </div>
            </form>
        </div>
    </div>
</div>
```

- [ ] **Step 2: Verify form works**

Check that:
- All select dropdowns populate
- Livewire binding works (`wire:model.live`)
- Form submission works
- Validation errors display

- [ ] **Step 3: Commit**

```bash
git add "resources/views/pages/terminals/⚡form/form.blade.php"
git commit -m "feat: migrate terminals form to material web"
```

---

## Task 8: Migrate Transit Lines Index Page

**Files:**
- Modify: `resources/views/pages/transit-lines/index/index.blade.php`

- [ ] **Step 1: Replace collapse component with Alpine.js**

The page uses `x-mdb.collapse` which needs to be replaced with pure Alpine.js:

```blade
<div class="card mb-4">
    <div x-data="{ open: false }" class="card">
        <div
            class="card-header d-flex justify-content-between align-items-center"
            role="button"
            @click="open = !open"
        >
            <h5 class="mb-0">
                <md-icon class="me-2">filter_list</md-icon>
                {{ __('Filters') }}
            </h5>
            <md-icon x-show="!open">expand_more</md-icon>
            <md-icon x-show="open">expand_less</md-icon>
        </div>
        <div x-show="open" x-collapse class="card-body">
            <!-- Filter content here -->
        </div>
    </div>
</div>
```

- [ ] **Step 2: Verify all Material Web components work**

Check that:
- All `md-outlined-text-field` inputs work
- All `md-outlined-select` dropdowns work
- Filter buttons work
- Table displays correctly

- [ ] **Step 3: Commit**

```bash
git add resources/views/pages/transit-lines/index/index.blade.php
git commit -m "feat: migrate transit lines index to material web"
```

---

## Task 9: Migrate Transit Lines Form Page

**Files:**
- Modify: `resources/views/pages/transit-lines/form/form.blade.php`

- [ ] **Step 1: Update all form components**

Replace all MDB components with Material Web equivalents (similar pattern to Task 7).

- [ ] **Step 2: Verify form works**

Check that:
- Region filters work
- Terminal selects populate
- Form submission works

- [ ] **Step 3: Commit**

```bash
git add resources/views/pages/transit-lines/form/form.blade.php
git commit -m "feat: migrate transit lines form to material web"
```

---

## Task 10: Verify Build and Test

**Files:**
- None (verification only)

- [ ] **Step 1: Run npm build**

Run: `npm run build`
Expected: Successful build with no errors

- [ ] **Step 2: Run artisan serve**

Run: `php artisan serve`
Expected: Server starts without errors

- [ ] **Step 3: Test in browser**

Check all pages:
- Home page renders
- Terminals index loads
- Terminals form loads
- Transit Lines index loads
- Transit Lines form loads
- Forms submit correctly
- Livewire interactions work

- [ ] **Step 4: Final commit**

```bash
git add -A
git commit -m "chore: complete mdb to material web migration"
```

---

## Summary

| Task | Description | Files Changed |
|------|-------------|---------------|
| 1 | Remove mdb-ui-kit package | package.json |
| 2 | Update CSS imports | bootstrap.css |
| 3 | Update JS imports | bootstrap.js |
| 4 | Delete MDB Blade components | 4 files deleted |
| 5 | Update layout navbar | app.blade.php |
| 6 | Migrate Terminals Index | index.blade.php |
| 7 | Migrate Terminals Form | form.blade.php |
| 8 | Migrate Transit Lines Index | index.blade.php |
| 9 | Migrate Transit Lines Form | form.blade.php |
| 10 | Verify build and test | - |

---

## Known Limitations

| Feature | Status | Workaround |
|---------|--------|------------|
| Expansion Panel | Not in @material/web | Use Alpine.js `x-collapse` |
| Data Table | Not in @material/web | Use HTML table with MD styling |
| Card Component | Limited | Use Bootstrap cards |
| RTL Support | Supported | Already configured |

---

**Plan Created:** 2026-06-23  
**Status:** Ready for Execution
