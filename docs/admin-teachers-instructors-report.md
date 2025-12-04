# admin.teachers / admin.instructors Occurrence Report

Generated: 2025-12-04

Purpose: inventory of places referencing `admin.teachers` and `admin.instructors`. No code changes performed — report only.

Summary:
- Both `admin.instructors.*` and `admin.teachers.*` route groups are registered in `routes/web.php` (legacy compatibility present).
- Views and sidebar components use `admin.instructors.*` route names with defensive `request()->routeIs('admin.teachers.*')` checks to preserve active states for legacy names.
- Several Blade files remain under `resources/views/admin/teachers/*` but link to `admin.instructors.*` route names (these are view-folder-level legacy names only).

Findings (file -> snippet):

- `routes/web.php` (line ~81)
  - `return redirect()->route('admin.instructors.index');` — a redirect exists for legacy `/admin/teachers`.

- `resources/views/admin/dashboard.blade.php` (line ~224)
  - Links to `route('admin.instructors.index')`.

- `resources/views/admin/dashboard/index.blade.php` (line ~88)
  - `route('admin.instructors.create')` used for "New Instructor" button.

- `resources/views/components/admin-sidebar.blade.php` (line ~210)
  - Menu item: `route('admin.instructors.index')` and active check: `request()->routeIs('admin.instructors.*') || request()->routeIs('admin.teachers.*')`.

- `resources/views/components/sidebar/admin.blade.php` (line ~24)
  - Similar link + active check for instructors/teachers.

- `resources/views/components/superadmin-sidebar.blade.php` (line ~218)
  - Similar link + active check for instructors/teachers.

- `resources/views/components/shared/sidebar.blade.php` (line ~13)
  - Sidebar configuration contains `['label' => 'Instructors', 'route' => 'admin.instructors.index', 'icon' => 'teachers', 'match' => 'admin.instructors.*']`.

- `resources/views/admin/teachers/index.blade.php` (lines ~74-76)
  - Action links use `route('admin.instructors.show', $teacher->id)`, `route('admin.instructors.edit', $teacher->id)`, `route('admin.instructors.destroy', $teacher->id)`.

- `resources/views/admin/teachers/show.blade.php` (lines ~44, 171)
  - `route('admin.instructors.edit', $teacher)` and `route('admin.instructors.index')` used.

- `resources/views/admin/teachers/edit.blade.php` (lines ~9,121)
  - Form action: `route('admin.instructors.update', $teacher)` and back link to `route('admin.instructors.index')`.

- Compiled/cached view matches in `storage/framework/views/*` referencing `admin.instructors.*` (these are compiled views, not sources).

Notes & Recommendations (no actions taken):

- Safe state: project currently preserves backward compatibility. The presence of both resource route registrations plus defensive checks in views ensures existing links still work.
- If you want to fully remove `admin.teachers.*` route names and perform a repo-wide rename of view folders (e.g., `admin/teachers` -> `admin/instructors`), proceed in the following safe order:
  1. Run full test suite and/or smoke test critical flows in the app (admin listing, create/edit instructor, admin dashboard).  
 2. Replace any `request()->routeIs('admin.teachers.*')` checks or other references in JS/Livewire.  
  3. Remove the `Route::resource('teachers', ...)` registration from `routes/web.php` **only** after confirming no external consumers use `admin.teachers.*`.  
  4. Optionally move view folder `resources/views/admin/teachers` -> `resources/views/admin/instructors` and update any direct view() calls if necessary.

- If you'd like, I can produce a patch that (A) removes the legacy `teachers` resource registration and (B) renames view folders, but I will run the test suite and produce a pre-change snapshot so this can be reverted if anything breaks.

---

If you want me to proceed with cleanup (non-functional changes like removing legacy route registration and renaming views), tell me whether to (1) do it now and run tests, or (2) prepare a patch and wait for your approval. Otherwise I will leave the code unchanged.
