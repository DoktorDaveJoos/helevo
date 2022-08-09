<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" :open="true">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                                     enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                     leave-from="opacity-100 translate-y-0 sm:scale-100"
                                     leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6">
                            <div>
                                <div
                                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Neuer
                                        Gutschein
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <div>
                                            <label for="price"
                                                   class="block text-sm font-medium text-gray-700">Betrag</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm"> € </span>
                                                </div>
                                                <input v-model="amount" type="text" name="price" id="price"
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                                       placeholder="0.00" />
                                                <div class="absolute inset-y-0 right-0 flex items-center">
                                                    <label for="currency" class="sr-only">Währung</label>
                                                    <select id="currency" name="currency"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                                                        <option>EUR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div v-if="$page.props.errors?.amount"
                                                 class="flex justfiy-start text-red-500 text-sm">{{
                                                    $page.props.errors?.amount
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative flex items-start py-4">
                                    <div class="min-w-0 flex-1 text-sm">
                                        <label for="paid" class="font-medium text-gray-700 select-none">Bar
                                            bezahlt</label>
                                    </div>
                                    <div class="ml-3 flex items-center h-5">
                                        <input v-model="paid" id="paid" name="paid" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                    </div>
                                </div>

                            </div>
                            <div class="mt-5 sm:mt-6 space-y-2">
                                <button @click="createVoucher" type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                                    Absenden
                                </button>
                                <button type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm"
                                        @click="$emit('modal-close')">Abbrechen
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {CheckIcon} from '@heroicons/vue/outline'
import {Inertia} from "@inertiajs/inertia";
import {vouchersRoute} from "../Helper/routes";

const props = defineProps({
    open: Boolean,
    errors: Object
});

const amount = ref('');
const paid = ref(true);

const emit = defineEmits(['modal-close']);

function createVoucher() {
    Inertia.post(vouchersRoute(), {amount: amount.value, paid: paid.value},
        {
            onSuccess: () => {
                emit('modal-close');

            }
        }
    );
}
</script>
