<script setup>
import {
    DialogPanel,
    DialogTitle,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions
} from '@headlessui/vue'
import {ref} from "vue";
import {UploadIcon} from '@heroicons/vue/outline'
import ModalWrapper from "./ModalWrapper.vue";
import {CheckIcon, SelectorIcon} from '@heroicons/vue/solid'
import {useForm} from "@inertiajs/inertia-vue3";
import JetButton from '../Jetstream/Button.vue';

defineProps({
    show: false
})

const months = [
    'Januar',
    'Februar',
    'März',
    'April',
    'Mai',
    'Juni',
    'Juli',
    'August',
    'September',
    'Oktober',
    'November',
    'Dezember'
];

const selectedMonth = ref(months[0]);
const selectedYear = ref(new Date().getFullYear());

function submit() {
    console.log('lol');
}

</script>

<template>
    <ModalWrapper :show="show">
        <DialogPanel
            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6">
            <div>
                <div
                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <UploadIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <DialogTitle as="h3"
                                 class="text-lg leading-6 font-medium text-gray-900">
                        Gutscheine importieren
                    </DialogTitle>
                    <div class="mt-2">
                        <form @submit.prevent="submit">

                            <Listbox as="div" v-model="selectedMonth">
                                <ListboxLabel class="block text-sm font-medium text-gray-700"> Monat
                                </ListboxLabel>
                                <div class="mt-1 relative">
                                    <ListboxButton
                                        class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <span class="block truncate">{{ selectedMonth }}</span>
                                        <span
                                            class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                          <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                        </span>
                                    </ListboxButton>

                                    <transition leave-active-class="transition ease-in duration-100"
                                                leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <ListboxOptions
                                            class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                            <ListboxOption as="template" v-for="month in months" :key="month"
                                                           :value="month" v-slot="{ active, selectedMonth }">
                                                <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-8 pr-4']">
                                                      <span :class="[selectedMonth ? 'font-semibold' : 'font-normal', 'block truncate']">
                                                        {{ month }}
                                                      </span>
                                                    <span v-if="selectedMonth"
                                                          :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                  </span>
                                                </li>
                                            </ListboxOption>
                                        </ListboxOptions>
                                    </transition>
                                </div>
                            </Listbox>

                            <div class="mt-2">
                                <label for="year" class="block text-sm font-medium text-gray-700">Jahr</label>
                                <div class="mt-1">
                                    <input type="text" name="year" id="year" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" v-model="selectedYear" />
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2 mt-6">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-helevo-red-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-helevo-red active:bg-helevo-red focus:outline-none focus:border-helevo-red focus:ring focus:ring-helevo-red-light disabled:opacity-25 transition">
                                    Hochladen
                                </button>

                                <JetButton type="button" @click="cancel">Abbrechen</JetButton>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </DialogPanel>
    </ModalWrapper>
</template>
