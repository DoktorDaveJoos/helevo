<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import Button from './Button.vue';
import Container from '@/Components/Container.vue';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import MobileNavigation from './MobileNavigation.vue';</script>

<template>
    <header class="py-10">
        <Container>
            <nav class="relative z-50 flex justify-between">
                <a href="/" class="flex items-center md:gap-x-1">
                    <JetApplicationMark class="block h-9 w-auto" />
                    <div class="hidden md:flex md:gap-x-6">
                        <img src="../../../images/logo-name.png" alt="Helevo Name" height="100" width="100" />
                    </div>
                    <div class="hidden ml-12 md:flex md:gap-x-6">
                        <Link href="#features">Funktionen</Link>
                        <Link href="#testimonials">Kundenstimmen</Link>
                        <Link href="#pricing">Preise</Link>
                    </div>
                </a>
                <div class="flex items-center gap-x-5 md:gap-x-8">
                    <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                        Gutscheinmanager
                    </Link>
                    <template v-else>
                        <div class="hidden md:block">
                            <Link href="/login">Anmelden</Link>
                        </div>
                        <Button href="/register" color="helevo">
                      <span>
                        Jetzt kostenlos starten
                      </span>
                        </Button>
                        <div class="-mr-1 md:hidden">
                            <MobileNavigation />
                        </div>
                    </template>
                </div>
            </nav>
        </Container>
    </header>
</template>
