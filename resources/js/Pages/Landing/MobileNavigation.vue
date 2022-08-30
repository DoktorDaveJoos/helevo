<script setup>
import {Popover, PopoverButton, PopoverOverlay, PopoverPanel} from '@headlessui/vue'
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <Popover v-slot="{ open }">
        <PopoverButton
            class="relative z-10 flex h-8 w-8 items-center justify-center [&:not(:focus-visible)]:focus:outline-none"
            aria-label="Toggle Navigation"
        >
            <svg
                aria-hidden="true"
                class="h-3.5 w-3.5 overflow-visible stroke-slate-700"
                fill="none"
                stroke-width="2"
                stroke-linecap="round"
            >
                <path
                    d="M0 1H14M0 7H14M0 13H14"
                    class="origin-center transition"
                    :class='open ? "scale-90 opacity-0" : ""'
                />
                <path
                    d="M2 2L12 12M12 2L2 12"
                    class="origin-center transition"
                    :class='!open ? "scale-90 opacity-0" : ""'
                />
            </svg>

        </PopoverButton>

        <PopoverOverlay class="fixed inset-0 bg-slate-300/50" />

        <PopoverPanel
            as="div"
            class="absolute inset-x-0 top-full mt-4 flex origin-top flex-col rounded-2xl bg-white p-4 text-lg tracking-tight text-slate-900 shadow-xl ring-1 ring-slate-900/5"
        >
            <PopoverButton class="block w-full p-2">
                <Link href="#features">Funktionen</Link>
            </PopoverButton>
            <PopoverButton class="block w-full p-2">
                <Link href="#testimonials">Kundemeinungen</Link>
            </PopoverButton>

            <hr class="m-2 border-slate-300/40" />
            <PopoverButton class="block w-full p-2">
                <Link href="/login">Anmelden</Link>
            </PopoverButton>
        </PopoverPanel>

    </Popover>
</template>
