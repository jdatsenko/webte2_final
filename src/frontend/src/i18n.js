import { createI18n } from 'vue-i18n'
import sk from './locales/sk.json'
import en from './locales/en.json'

export const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
        en,
        sk
    }
})

export const { t } = i18n.global

export const changeLocale = () => {
    i18n.global.locale = i18n.global.locale === 'en' ? 'sk' : 'en'
}

export default i18n;