<script setup>
import Hero from "./Landing/Hero.vue";
import Header from "./Landing/Header.vue";
import Footer from "@/Components/Footer.vue";
import PrimaryFeatures from "./Landing/PrimaryFeatures.vue";
import Testimonials from "./Landing/Testimonials.vue";
import Pricing from "./Landing/Pricing.vue";
import LightFeatures from "./Landing/LightFeatures.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head>
        <title>Dein kostenloser Gutscheinmanager</title>
        <meta name="description"
              content="Der Helevo Gutscheinmanager bietet alles was Sie zur Verwaltung und Erstellung Ihrer Gutscheine brauchen. Zudem können Sie Gutscheine mittels Helevo ganz einfach auf Ihrer Website oder auf Helevo.com direkt verkaufen. Die Gutscheinverwaltung ist und bleibt kostenlos - probieren Sie es aus."
        >
    </Head>
    <Header />
    <main>
        <Hero />
        <LightFeatures />
        <PrimaryFeatures />
        <Testimonials />
        <Pricing />
    </main>
    <Footer />
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>
