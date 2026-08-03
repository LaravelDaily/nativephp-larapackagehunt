# NativePHP v4 API reference

Source of truth: `vendor/nativephp/mobile` 4.0.1 and `vendor/nativephp/mobile-ui` 0.3.0.

## Routing and components

- `Route::native($uri, $component)` registers both the Laravel GET route and the `NativeRouter` entry. The returned route supports `->name()` and `->layout()`.
- `Route::nativeGroup($layout, $routes)` assigns a shared `NativeLayout` to the native routes registered by the closure.
- `NativeComponent` infers `resources/views/native/{kebab-class}.blade.php`, exposes public properties to the view, and supports `mount()`, `onResume()`, `onBackPressed()`, and `unmount()`.
- Route parameters are read with `$this->param()`. Navigation payloads are read with `$this->data()`.
- Navigation uses `navigate()`, `replace()`, `back()`, and `exitToWeb()`.
- State attributes available in core include `#[Computed]`, `#[Lazy]`, `#[On]`, and `#[Poll]`.

## Elements

Core layout/content primitives: `column`, `row`, `stack`, `scroll-view`, `spacer`, `text`, `image`, `icon`, `pressable`, `refreshable`, `lazy-grid`, `divider`, `rect`, `circle`, `line`, and `canvas`.

Native chrome: `top-bar`, `top-bar-action`, `top-bar-title`, `bottom-nav`, `bottom-nav-item`, `bottom-bar`, `side-nav`, `fab`, and native root stack/tab hosts.

The registered mobile-ui plugin adds native lists, virtual lists, buttons, inputs, toggles, checkboxes, sliders, selects, date pickers, radio groups, badges, chips, tab rows, modals, bottom sheets, carousels, drawers, and floating overlays. `webview` exists only as an escape hatch and is not used by this migration.

## Styling and themes

- EDGE accepts the subset implemented by `Native\Mobile\Edge\TailwindParser`; unsupported utilities are ignored.
- Supported groups include spacing, sizing, flex layout, position, opacity, text size/weight/alignment, uniform radius, borders, shadows, palette/theme colors, platform/dark variants, and gradients.
- Theme roles resolve from `config/native-ui.php`; native views use `bg-theme-*`, `text-theme-*`, and `border-theme-*` rather than literal palette values.
- Absolute fills require explicit `top-0 left-0 w-full h-full`. Empty visual fills use `native:rect` rather than an empty column.
- Local images use absolute paths from `public_path()`.

## Layouts and testing

- A `NativeLayout` may return `NavBar` and `TabBar` builders. Inline chrome in a screen overrides the corresponding layout bar.
- `Native::test()` mounts a component directly; `Native::visit()` resolves the registered route and layout.
- Tests can interact with refs using `tap()`, inspect state with `assertSet()`, inspect the tree with `assertElement()`/`tree()`, follow navigation with `follow()`, and verify accessibility with `assertAccessible()`.
- Device bridges are replaced by `FakeBridge`; no simulator or device is required for the PHP test suite.
