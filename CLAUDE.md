# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 rental reservation system for snow sports equipment (snowboards, skis, wear, gloves, goggles) at ski resorts. It features:

- **Dual reservation system**: Admin panel (staff) and public client portal (customers)
- **Master data management**: Resorts, business patterns/calendars, rental menus, gear items
- **Multi-step session-based forms**: Progressive disclosure with validation at each step
- **PDF generation**: Rental slips and booking confirmations with Japanese font support
- **Role-based access control**: Admin/manager vs regular users

## Development Commands

```bash
# Setup (first time)
composer setup

# Development (runs server + queue + logs + vite concurrently)
composer dev

# Run tests
composer test

# Code formatting (Laravel Pint)
./vendor/bin/pint

# Database migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear all caches
php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

## Architecture Overview

### Dual Reservation System

**AdminReservation** (`ReservationController`):
- Requires authentication + role-based access
- Tracks `created_by`, `updated_by` user IDs
- Full CRUD with edit capability
- Multi-step flow: Header → Details → Confirm → Store

**ClientReservation** (`ClientReservationController`):
- Public-facing (no auth required)
- Starts with terms agreement step
- Same validation but different field names (`reserve_date` vs `visit_date`, `tel` vs `phone`)
- No tracking of creator (stores NULL)
- Multi-step flow: Agree → Header → Detail → Confirm → Store → Success/Error

### Session-Based Multi-Step Forms

Both reservation flows use session storage to persist data across steps:

```php
// Admin uses:
session('reservation.header')
session('reservation.details')

// Client uses:
session('client_reservation.agreed')
session('client_reservation.header')
session('client_reservation.details')
```

**Important patterns**:
- Controllers validate → normalize → store in session at each step
- Forms repopulate from `old()` on validation errors
- Booleans normalized using `!empty()` pattern
- Session cleared only after successful DB save
- Detail page allows "add user" action to add multiple guests before confirmation

### Model Relationships

```
Reservation (代表者情報)
├── hasMany: ReservationDetail (利用者明細)
├── belongsTo: Resort
└── belongsTo: User (created_by, updated_by, printed_by)

ReservationDetail (利用者情報)
├── belongsTo: Reservation
├── belongsTo: RentalMenu (gear_plan_id) - メインギア
├── belongsTo: RentalMenu (wear_plan_id) - ウェア
├── belongsTo: RentalMenu (glove_plan_id) - グローブ
└── belongsTo: RentalMenu (goggles_plan_id) - ゴーグル

RentalMenu
├── belongsTo: RentalMenuCategory
├── hasMany: RentalMenuComponent
└── belongsToMany: GearItem (through RentalMenuComponent)

BusinessCalendar (営業カレンダー)
└── belongsTo: BusinessPattern
```

**Critical fields**:
- `Reservation.token`: UUID auto-generated on creation
- `Reservation.build_number`: Sequence per day for unique identification
- `RentalMenu.is_junior`: 0=adult, 1=child (key for menu switching)
- `RentalMenu.menu_type`: 'base'=main items, 'option'=add-ons
- `ReservationDetail.group_sequence`: Order within reservation (1, 2, 3...)
- `BusinessCalendar.date`: Unique per day, links to BusinessPattern for hours

### Business Calendar Validation

All reservations validate against the business calendar:

1. Check if date exists in `BusinessCalendar` table
2. Verify linked `BusinessPattern` has `is_open=true`
3. Validate `reserve_time` is within `open_time` to `close_time`
4. Prevent duplicates: same phone + same date (uses `whereDate` + `exists()`)

**Important**: The duplicate check auto-excludes soft-deleted records but won't catch previously deleted reservations for the same phone+date.

### Role-Based Access Control

```php
User.role values:
- 0 or 1 = Admin/Manager (master access)
- 2 or 'user' = Regular user (view only)
```

**Middleware**: `MasterRoleMiddleware` checks `in_array((int)$user->role, [0, 1], true)`

**Route protection**:
```php
// Public routes (no auth)
/reservation/agree, /reservation/header, etc.

// Auth required (view-only)
Route::middleware(['auth'])->group()
  → /reservations, /resorts

// Admin only (role 0,1)
Route::middleware(['auth', 'master.role'])->group()
  → Resort CRUD, BusinessPattern CRUD, RentalMenu CRUD, etc.
```

### Dynamic Menu System (Adult/Child Switching)

Forms load separate adult and child menu collections:

```php
// Main gear, wear, gloves, goggles all have adult/child versions
$gear_plans_adult = RentalMenu::where('is_active', true)
    ->where('menu_type', 'base')
    ->where('is_junior', 0)  // Adult
    ->orderBy('name')->get();

$gear_plans_child = RentalMenu::where('is_active', true)
    ->where('menu_type', 'base')
    ->where('is_junior', 1)  // Child
    ->orderBy('name')->get();
```

**In views**: JavaScript toggles visibility based on "Jr" checkbox (中学生以下)
- When checked: hide adult options, show child options
- When unchecked: show adult options, hide child options
- Step On checkbox shows only when snowboard category is selected

**Category matching**: Uses hardcoded category names in controllers:
```php
$categoryMap = RentalMenuCategory::whereIn('name', [
    'スノーボード', 'スキー', 'ウェア', 'グローブ', 'ゴーグル'
])->pluck('id', 'name');
```
⚠️ **Warning**: Changing category names in DB will break menu loading.

### PDF Generation

Uses `barryvdh/laravel-dompdf` with Japanese font support.

**Single reservation PDF**:
```php
Route::get('/reservations/{reservation}/pdf', [ReservationController::class, 'downloadPdf']);
```

**Batch printing**:
```php
Route::get('/reservation-prints', [ReservationController::class, 'printForm']);
Route::post('/reservation-prints', [ReservationController::class, 'printExecute']);
```

**Implementation**:
- Tracks `printed_at` and `printed_user_id` on generation
- Batch printing queries unprinted reservations (`whereNull('printed_at')`)
- Loads Japanese font from `storage/fonts/ipaexg.ttf`
- PDF views in `resources/views/reservations/pdf.blade.php`

## Important Patterns and Conventions

### Validation Error Display

Use `ValidationException::withMessages()` instead of `back()->withErrors()` for proper error display:

```php
// ✓ Correct
throw ValidationException::withMessages([
    'reserve_date' => '指定した日付は既にご予約いただいています。',
]);

// ✗ Incorrect (won't display in view)
return back()->withErrors([
    'reserve_date' => '指定した日付は既にご予約いただいています。',
]);
```

### Action-Based Form Routing

Detail forms use hidden action parameter to distinguish button clicks:

```php
// In controller
if ($request->input('action') === 'add_guest') {
    return redirect()->route('client.reservation.detail')
        ->with('status', '利用者情報を保存しました。続けて利用者を追加してください。');
}
return redirect()->route('client.reservation.confirm');

// In view (JavaScript)
function submitWithAction(actionType) {
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = actionType;
    form.appendChild(actionInput);
    form.submit();
}
```

### Boolean Field Normalization

Always use `!empty()` pattern for boolean conversion from form input:

```php
$normalizedDetails[] = [
    'jr'              => !empty($guest['jr']),
    'helmet'          => !empty($guest['helmet']),
    'is_step_on'      => !empty($guest['is_step_on']),
];
```

### Database Transactions

Always wrap multi-table inserts in transactions:

```php
DB::beginTransaction();
try {
    $reservation = Reservation::create([...]);

    foreach ($details as $detail) {
        ReservationDetail::create([
            'reservation_id' => $reservation->id,
            ...
        ]);
    }

    DB::commit();
    session()->forget('client_reservation.header');
    session()->forget('client_reservation.details');

    return redirect()->route('client.reservation.success');
} catch (\Exception $e) {
    DB::rollBack();
    return redirect()->route('client.reservation.error');
}
```

### Responsive Design Requirements

All client-facing views must be responsive:
- Mobile-first CSS approach
- Use media queries for desktop enhancements
- Hide/show elements based on screen size (`.hide-on-mobile`, `.hide-on-desktop`)
- Test on mobile devices (viewports 320px-768px)

## Known Gotchas

1. **Field Name Inconsistencies**:
   - Admin uses: `phone`, `visit_date`, `visit_time`
   - Client uses: `tel`, `reserve_date`, `reserve_time`
   - These map to same DB columns, be careful with session keys

2. **Category Name Dependency**:
   - Controllers match category names via `whereIn('name', [...])`
   - Changing category names breaks menu loading
   - Consider using category codes instead

3. **Soft Deletes**:
   - Most models use soft deletes
   - Duplicate checks with `exists()` auto-exclude soft-deleted
   - But won't prevent re-booking of previously deleted reservation

4. **Session Timeout**:
   - No explicit handling of session expiration mid-form
   - Users redirected to start but lose all input
   - Consider adding session age check

5. **Menu Type Filtering**:
   - Only `menu_type='base'` items load in detail forms
   - Options (`menu_type='option'`) are separate add-ons
   - Don't create base menus marked as option type

6. **Stance Field**:
   - Stored as string in DB ('レギュラー', 'グーフィー')
   - Form uses numeric IDs (1, 2)
   - Views use hardcoded array mapping

## File Structure Highlights

```
app/Http/Controllers/
├── ReservationController.php          # Admin reservation CRUD
├── ClientReservationController.php    # Public reservation flow
├── BusinessCalendarController.php     # Calendar management
├── RentalMenuController.php           # Menu CRUD
└── ...other master controllers

app/Models/
├── Reservation.php
├── ReservationDetail.php
├── RentalMenu.php
├── RentalMenuComponent.php
├── GearItem.php
├── BusinessCalendar.php
└── BusinessPattern.php

resources/views/
├── reservations/                      # Admin views
│   ├── create_header.blade.php
│   ├── create_details.blade.php
│   ├── confirm.blade.php
│   └── pdf.blade.php
└── client/reservations/               # Client views
    ├── agree.blade.php
    ├── header.blade.php
    ├── detail.blade.php
    ├── confirm.blade.php
    ├── success.blade.php
    └── error.blade.php

routes/web.php                         # All route definitions
```

## Testing Checklist

When making changes, verify:

1. ✓ Session data persists across redirects
2. ✓ Validation errors display in correct fields
3. ✓ Business calendar validation blocks closed days
4. ✓ Duplicate phone+date prevention works
5. ✓ Adult/child menu switching functions
6. ✓ "Add user" button stays on detail page
7. ✓ "Confirm" button proceeds to confirmation
8. ✓ PDF generation includes Japanese characters
9. ✓ Soft-deleted records excluded from queries
10. ✓ Role middleware prevents unauthorized access
11. ✓ Responsive design works on mobile (320px-768px)
12. ✓ Step On checkbox shows only for snowboard selections
