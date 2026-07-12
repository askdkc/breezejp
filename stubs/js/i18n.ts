import { page } from '@inertiajs/svelte';

/**
 * Translate the given key using the translations shared via Inertia props.
 * Behaves like Laravel's __() helper, including :placeholder replacement.
 *
 * Added by Breezejp (https://github.com/askdkc/breezejp)
 */
export function t(key: string, replacements: Record<string, string> = {}): string {
    const translations = (page.props.translations ?? {}) as Record<string, string>;

    let translated = translations[key] ?? key;

    for (const [name, value] of Object.entries(replacements)) {
        translated = translated.replaceAll(`:${name}`, value);
    }

    return translated;
}
