<script setup>
import Container from './Container.vue';
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <footer class="bg-slate-50">
        <Container>
            <div class="py-16">
<!--                <Logo class="mx-auto h-10 w-auto" />-->
                <nav class="mt-10 text-sm" aria-label="quick links">
                    <div class="-my-1 flex justify-center gap-x-6">
                        <Link href="#features">Funktionen</Link>
                        <Link href="#testimonials">Kundenstimmen</Link>
                        <Link href="#pricing">Preise</Link>
                        <Link href="/datenschutz">Datenschutz</Link>
                        <Link href="/impressum">Impressum</Link>
                    </div>
                </nav>
            </div>
            <div class="flex flex-col items-center border-t border-slate-400/10 py-10 sm:flex-row-reverse sm:justify-between">
                <div class="flex gap-x-6">

                </div>
                <p class="mt-6 text-sm text-slate-500 sm:mt-0">
                    Copyright &copy; {{ new Date().getFullYear() }} Orgusto. All rights
                    reserved.
                </p>
            </div>
        </Container>
    </footer>
</template>
