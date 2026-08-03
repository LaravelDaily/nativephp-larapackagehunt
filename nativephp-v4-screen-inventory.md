# NativePHP v4 screen inventory

## `/` — Home

- Legacy implementation: `HomeController` and `resources/views/home.blade.php`.
- State: GET `{config('app.api_url')}/packages` with three-second connect and five-second request timeouts; reads the `data` array.
- Content: app mark, “Latest Packages” heading, package title, and short description.
- Action: every package row currently opens `/packages/anysearch`.
- Chrome: Home and Discover bottom navigation; Discover has no working destination in the legacy view.
- Existing coverage: successful HTTP response, API request URL, and rendered package text.
- Native translation: load in `mount()`, render explicit loading/error/empty states, use keyed pressable rows, navigate to the preserved detail URI, and expose refresh.

## `/packages/anysearch` — Package details

- Legacy implementation: `resources/views/packages/show.blade.php`; all data is currently static.
- Content: AnySearch title, tagline, GitHub action, two screenshot placeholders, description, author, release date, and version.
- Actions: back, open GitHub externally, select screenshots, and close the screenshot lightbox.
- Legacy mechanics: Alpine state and keyboard handling for the lightbox.
- Existing coverage: hard-coded details and lightbox controls.
- Native translation: native top-bar/back handling, native external-link action, a native carousel, and a native modal/bottom sheet for screenshot focus.

## Embedded/shared UI

- `components/app-logo.blade.php`: SVG web logo. Native UI will use a platform icon in a themed shape; SVG markup is not carried into EDGE.
- `components/package-list-item.blade.php`: absorbed into the Home screen because the current app has only one consumer.
- `layouts/app.blade.php`: web document, Vite, Livewire assets, safe-area class, and web bottom navigation. Native chrome replaces it.
