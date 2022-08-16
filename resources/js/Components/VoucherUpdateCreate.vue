<script setup>
import {DialogPanel, DialogTitle} from '@headlessui/vue'
import {computed, reactive, watch} from 'vue'
import {GiftIcon} from '@heroicons/vue/outline'
import JetButton from "../Jetstream/Button.vue";

import {Inertia} from "@inertiajs/inertia";
import {voucherCashRoute, voucherRoute, vouchersRoute} from "../Helper/routes";
import ModalWrapper from "./ModalWrapper.vue";

const props = defineProps({
    voucher: Object,
    show: Boolean,
    isCash: {
        default: false
    }
})

const emit = defineEmits(['close-dialog']);

watch(props, (o, props) => {

    if (props.voucher?.id) {
        const {amount_history, paid_on} = props.voucher;
        if (!props.isCash) {
            form.amount = amount_history[0].amount ?? '';
        }
        form.paid = paid_on !== null;
        return;
    }

    form.amount = '';
    form.paid = true;
})

const form = reactive({
    amount: '',
    paid: true
});

const newVoucher = computed(() => {
    return !props.voucher?.code;
})

function submit() {
    if (props.voucher?.id) {
        if (props.isCash) {
            cash();
            return;
        }
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

function cash() {
    const cashAmount = form.amount.length === 0 ? props.voucher.actual_amount : form.amount;

    Inertia.put(voucherCashRoute(props.voucher.id), {amount: cashAmount}, {
        preserveScroll: true,
        onSuccess: () => emit('close-dialog')
    });
}

</script>

<template>
    <ModalWrapper :show="show">
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
                <div v-if="!isCash" class="relative flex items-start pt-4">
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
                <button v-if="isCash" @click="submit()" type="button"
                        class="inline-flex items-center px-4 py-2 bg-helevo-red-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-helevo-red active:bg-helevo-red focus:outline-none focus:border-helevo-red focus:ring focus:ring-helevo-red-light disabled:opacity-25 transition">
                    {{ form.amount ? 'Teilbetrag einlösen' : 'Komplett einlösen' }}
                </button>
                <button v-else @click="submit" type="button"
                        class="inline-flex items-center px-4 py-2 bg-helevo-red-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-helevo-red active:bg-helevo-red focus:outline-none focus:border-helevo-red focus:ring focus:ring-helevo-red-light disabled:opacity-25 transition">
                    {{ newVoucher ? 'Anlegen' : 'Speichern' }}
                </button>
                <JetButton @click="$emit('close-dialog')">Abbrechen</JetButton>
            </div>
        </DialogPanel>
    </ModalWrapper>
</template>
