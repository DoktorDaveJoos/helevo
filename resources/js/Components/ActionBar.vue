<script setup>
import { XCircleIcon } from '@heroicons/vue/solid'

import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import {searchRoute, vouchersRoute} from "../Helper/routes";

const keysPressed = {};
const search = ref(null);
const term = ref('');

window.addEventListener("keydown", event => {
    keysPressed[event.key] = true;
})

window.addEventListener("keypress", e => {
    if (keysPressed['Control'] && e.key === 'k') {
        search.value?.focus();
    }

    if (e.key === 'Enter') {
        if (document.activeElement === search.value) {
            const params = new URLSearchParams();
            params.append('search', term.value);
            Inertia.get(searchRoute(params), {}, {
                preserveState: true,
            });
        }
    }
})

window.addEventListener("keyup", e => {
    delete keysPressed[e.key];
})

function clearInput() {
    Inertia.get(vouchersRoute(true));
}

</script>

<template>
    <div class="mt-8 flex">
        <div
            class="min-w-full py-4 bg-gray-50 rounded shadow ring-1 ring-black ring-opacity-5">
            <div class="flex justify-between px-4">
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700">Gutschein-Code</label>
                    <div class="mt-1 relative flex items-center">
                        <input v-model="term" ref="search" type="text" name="search" id="search" placeholder="XY-AB123"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md" />

                        <div v-if="term.length > 0" @click="clearInput()" class="absolute inset-y-0 right-0 pr-16 flex items-center cursor-pointer">
                            <XCircleIcon class="h-5 w-5 text-gray-400 hover:text-gray-600 mr-1 cursor-pointer" aria-hidden="true" />
                        </div>
                        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                            <kbd
                                class="inline-flex items-center border border-gray-200 rounded px-2 text-sm font-sans font-medium text-gray-400">
                                strg K </kbd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


