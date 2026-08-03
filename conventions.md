# Native UI migration conventions

- Screen classes live in `app/NativeComponents`; views live in `resources/views/native`.
- Routes retain their existing URI and name and use `Route::native()`.
- Screen views use only `native:*` EDGE elements. Do not add web views, Livewire directives, Flux tags, Alpine state, inline CSS, inline JavaScript, or SVG icons.
- Use `bg-theme-*`, `text-theme-*`, and `border-theme-*`. Literal app palette colors belong only in `config/native-ui.php`.
- Use font aliases (`default`, `medium`, `semibold`, `bold`) and matching weight classes.
- Use generated `App\Icons\Ios`, `Android`, and `AndroidOutlined` cases for icons.
- Use native chrome elements or layouts. Do not hand-build navigation bars, tab bars, or safe-area padding.
- Give repeated interactive children stable keys derived from package identity and a `ref` for tests.
- Empty fills are `native:rect`; absolute fills specify width and height; image aspect ratios belong on their sizing stack.
- Interactive controls require visible labels or `a11y-label`. Native screen tests must include `assertAccessible()`.
- Data access stays in PHP component actions. HTTP tests use `Http::preventStrayRequests()` and `Http::fake()`.
- Device build commands are user-run only after the PHP migration suite, formatter, static analysis, and `native:validate` pass.
