/**
 * VIP House Shifting — Language Switcher (EN ↔ AR)
 * Uses Google Translate cookie method for reliable full-page translation.
 */

// Initialize Google Translate Element
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'ar,en',
        autoDisplay: false,
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}

/**
 * Set the translation language via the Google Translate dropdown
 */
function triggerGoogleTranslate(lang) {
    // Method 1: Use the combo box
    var combo = document.querySelector('.goog-te-combo');
    if (combo) {
        combo.value = lang;
        combo.dispatchEvent(new Event('change'));
        return true;
    }
    return false;
}

/**
 * Set googtrans cookie and reload for reliable translation
 */
function setTranslateCookie(lang) {
    if (lang === 'ar') {
        document.cookie = 'googtrans=/en/ar; path=/';
        document.cookie = 'googtrans=/en/ar; path=/; domain=' + window.location.hostname;
    } else {
        document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        document.cookie = 'googtrans=; path=/; domain=' + window.location.hostname + '; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    }
}

/**
 * Toggle between English and Arabic
 */
function toggleLanguage() {
    var current = localStorage.getItem('vip_lang') || 'en';
    var newLang = current === 'en' ? 'ar' : 'en';

    localStorage.setItem('vip_lang', newLang);

    // Set RTL
    if (newLang === 'ar') {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.setAttribute('lang', 'ar');
        document.body.classList.add('rtl-mode');
    } else {
        document.documentElement.removeAttribute('dir');
        document.documentElement.setAttribute('lang', 'en');
        document.body.classList.remove('rtl-mode');
    }

    updateToggleBtn(newLang);

    // Try the combo box first
    if (!triggerGoogleTranslate(newLang === 'en' ? 'en' : 'ar')) {
        // If combo not ready, set cookie and reload
        setTranslateCookie(newLang);
        window.location.reload();
    }
}

/**
 * Update toggle button appearance
 */
function updateToggleBtn(lang) {
    var flagImg = document.getElementById('langFlagImg');
    var textLabel = document.getElementById('langTextLabel');
    if (!flagImg || !textLabel) return;
    if (lang === 'ar') {
        // Currently Arabic → show English option
        flagImg.src = 'https://flagcdn.com/w40/gb.png';
        flagImg.alt = 'EN';
        textLabel.textContent = 'English';
    } else {
        // Currently English → show Arabic option
        flagImg.src = 'https://flagcdn.com/w40/sa.png';
        flagImg.alt = 'SA';
        textLabel.textContent = 'عربي';
    }
}

/**
 * On page load: restore saved language
 */
document.addEventListener('DOMContentLoaded', function () {
    var saved = localStorage.getItem('vip_lang') || 'en';
    updateToggleBtn(saved);

    if (saved === 'ar') {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.setAttribute('lang', 'ar');
        document.body.classList.add('rtl-mode');

        // Set cookie in case it was cleared
        setTranslateCookie('ar');

        // Wait for Google Translate widget to appear, then trigger
        var attempts = 0;
        var interval = setInterval(function () {
            attempts++;
            if (triggerGoogleTranslate('ar') || attempts > 30) {
                clearInterval(interval);
            }
        }, 300);
    }
});
