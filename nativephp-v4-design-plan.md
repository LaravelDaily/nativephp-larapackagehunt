# NativePHP v4 design plan

## Visual system

- Preserve the existing Instrument Sans typography using bundled Regular, Medium, SemiBold, and Bold faces with semantic aliases in `config/native-ui.php`.
- Preserve the existing blue brand and slate neutrals through light/dark theme roles. Views reference roles only; literal colors remain centralized in config.
- Use white/light background and surface roles, slate foreground roles, blue primary/accent roles, and automatic dark companions.
- Use platform icons from the generated `App\Icons` enums; do not use emoji or inline SVG.

## Navigation

- Home is the root stack destination. A bottom navigation bar is deferred until Discover has a real destination.
- Package details is pushed on a native stack and uses a real native top bar with back behavior.
- The legacy Discover placeholder is omitted until it has a real route; native chrome must not contain a dead destination.

## Screen composition

- Home: large native title, refreshable scroll content, package rows as pressable surface cards, plus loading/error/empty states.
- Details: inline native title, scrollable article content, primary GitHub action, native screenshot carousel, and metadata rows.
- Both screens use theme tokens, native font aliases, supported parser utilities, and stable domain keys.
