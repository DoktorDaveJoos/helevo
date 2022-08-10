<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {computed, reactive, watch} from 'vue'
import {GiftIcon} from '@heroicons/vue/outline'
import JetButton from "../Jetstream/Button.vue";

import {Inertia} from "@inertiajs/inertia";
import {voucherRoute, vouchersRoute} from "../Helper/routes";

const props = defineProps({
    voucher: Object,
    show: Boolean
})

const emit = defineEmits(['close-dialog']);

watch(props, (o, props) => {

    if (props.voucher) {
        const {amount, paid_on} = props.voucher;
        form.amount = amount ?? '';
        form.paid = paid_on !== null;
        return;
    }

    form.amount = null;
    form.paid = true;
})

const form = reactive({
    amount: null,
    paid: true
});

const newVoucher = computed(() => {
    return !props.voucher?.code;
})

function submit() {
    if (props.voucher?.id) {
        updateVoucher();
    } else {
        createVoucher();
    }
}

function createVoucher() {
    Inertia.post(vouchersRoute(), form,
        {
            onSuccess: () => emit('close-dialog')
        }
    );
}

function updateVoucher() {
    Inertia.put(voucherRoute(props.voucher.id), form, {
            onSuccess: () => emit('close-dialog')
        }
    );
}

</script>

<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10">
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
                                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                    <GiftIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3"
                                                 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ newVoucher ? 'Neuer Gutschein' : voucher.code }}
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
                                                <input v-model="form.amount" type="text" name="price"
                                                       id="price"
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                                       placeholder="0.00" />
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center">
                                                    <label for="currency"
                                                           class="sr-only">Währung</label>
                                                    <select id="currency" name="currency"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                                                        <option>EUR</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div v-if="$page.props.errors?.amount"
                                                     class="flex justify-items-start text-red-500 text-sm">{{
                                                        $page.props.errors?.amount
                                                    }}
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative flex items-start pt-4">
                                    <div class="min-w-0 flex-1 text-sm">
                                        <label for="paid" class="font-medium text-gray-700 select-none">Bar
                                            bezahlt</label>
                                    </div>
                                    <div class="ml-3 flex items-center h-5">
                                        <input v-model="form.paid" id="paid" name="paid" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                    </div>
                                </div>

                            </div>
                            <div class="flex flex-col sm:mt-6 space-y-2">
                                <button @click="submit" type="button"
                                        class="inline-flex items-center px-4 py-2 bg-helevo-red-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-helevo-red active:bg-helevo-red focus:outline-none focus:border-helevo-red focus:ring focus:ring-helevo-red-light disabled:opacity-25 transition">
                                    {{ newVoucher ? 'Anlegen' : 'Speichern' }}
                                </button>
                                <JetButton @click="$emit('close-dialog')">Abbrechen</JetButton>
                            </div>
                        </DialogPanel>

                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
