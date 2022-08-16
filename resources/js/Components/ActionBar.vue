<script setup>
import JetButton from '../Jetstream/Button.vue';
import { Link } from '@inertiajs/inertia-vue3'
import { XCircleIcon, SearchIcon } from '@heroicons/vue/solid'

import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import {searchRoute, vouchersRoute} from "../Helper/routes";
import ExcelImport from "./ExcelImport.vue";
import Report from "./Report.vue";

const keysPressed = {};
const search = ref(null);
const term = ref('');
const excelImport = ref(false);
const report = ref(false);

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
                errorBag: 'notification'
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

function showExcelImport() {
    excelImport.value = true;
}

function showReport() {
    report.value = true;
}

</script>

<template>
    <div class="mt-8 flex">
        <div class="min-w-full py-4 bg-gray-50 md:rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <div class="flex justify-between px-4">
                <div>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <SearchIcon class="w-4 h-4 text-gray-400"></SearchIcon>
                        </div>
                        <input v-model="term" ref="search" type="text" name="search" id="search" placeholder="XY-AB123"
                               class="shadow-sm pl-8 focus:ring-helevo-red focus:border-helevo-red block w-full pr-12 sm:text-sm border-gray-300 rounded-md" />

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
                <div class="flex items-center justify-center space-x-2">
                    <button @click="showReport" class="inline-flex items-center px-4 py-2 bg-white border border-gray-800 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" href="/dashboard/export">Report</button>
                    <button @click="showExcelImport" class="inline-flex items-center px-4 py-2 bg-white border border-gray-800 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Import excel</button>
                    <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-800 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" href="/dashboard/export">Download excel</a>
                </div>
            </div>

            <ExcelImport :show="excelImport" @close-dialog="excelImport = false"></ExcelImport>
            <Report :show="report" @close-dialog="Report = false"></Report>
        </div>
    </div>
</template>


