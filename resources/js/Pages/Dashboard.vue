<script setup>
import {computed, defineProps, ref} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {CashIcon, GiftIcon, PencilAltIcon, CubeTransparentIcon} from "@heroicons/vue/outline";

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "../Components/Pagination.vue";
import Notification from "../Components/Notification.vue";
import JetButton from "@/Jetstream/Button.vue";
import ActionBar from "../Components/ActionBar.vue";
import VoucherUpdateCreate from "../Components/VoucherUpdateCreate.vue";
import ExcelImport from "../Components/ExcelImport.vue";

const props = defineProps({
    vouchers: Object,
});

defineEmits(['close-dialog']);

const modal = ref(false);

const selected = ref(null);
const isCash = ref(false);
const initialImport = ref(false);

function showModal(voucher = null, cash = false) {
    isCash.value = cash;
    selected.value = voucher;
    modal.value = !modal.value;
}

const notifications = computed(() => {
    const keys = Object.keys(usePage().props.value.errorBags.notification ?? {});

    return keys.map(key => {
        return {
            title: key,
            message: usePage().props.value.errors.notification[key],
            seed: Math.random()
        }
    })
})

</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="vouchers?.data?.length > 0" class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Gutscheinliste</h1>
                            <p class="mt-2 text-sm text-gray-700">Erstellen und entwerten Sie Gutscheine oder
                                exportieren Sie die Liste.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <JetButton @click="showModal()">
                                Neuer Gutschein
                            </JetButton>
                        </div>
                    </div>

                    <ActionBar></ActionBar>

                    <div class="mt-8 flex flex-col">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Gutschein Code
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Betrag
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Restbetrag
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Bezahlt am
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Zuletzt benutzt
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-1 pr-4 sm:pr-6">
                                                <span class="sr-only">Aktion</span>
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-1 pr-4 sm:pr-6">
                                                <span class="sr-only">Aktion</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                        <tr v-for="(voucher, voucherIdx) in vouchers.data" :key="voucher.email"
                                            :class="voucherIdx % 2 === 0 ? undefined : 'bg-gray-50'">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text font-semibold text-gray-800 sm:pl-6">
                                                {{ voucher.code }}
                                            </td>
                                            <td class="whitespace-nowrap font-light px-3 py-4 text-sm text-gray-500 italic"
                                                :class="{ 'line-through': voucher.amount_history.length > 1 }"
                                            >
                                                {{ voucher.initial_amount }} €
                                            </td>
                                            <td class="whitespace-nowrap font-semibold text-sm px-3 py-4 text-gray-500">
                                                {{ voucher.actual_amount }} €
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <template v-if="!voucher.paid_on">
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"> Geblockt </span>
                                                </template>
                                                <template v-else-if="voucher.cashed_on">
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"> Eingelöst </span>
                                                </template>
                                                <template v-else-if="voucher.amount_history.length > 1">
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800"> Teilweise eingelöst </span>
                                                </template>
                                                <template v-else>
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"> Offen </span>
                                                </template>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-xs text-gray-500">
                                                {{ voucher.paid_on ?? 'Nicht bezahlt' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-xs text-gray-500">{{
                                                    voucher.last_cashed
                                                }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-1 pr-1 text-right text-sm font-medium sm:pr-6">
                                                <button v-if="!voucher.cashed_on"
                                                        @click="showModal(voucher, true)"
                                                        class="flex"
                                                        :class="{'text-red-400 hover:text-red-500': voucher.cashed_on, 'text-indigo-400 hover:text-indigo-500': !voucher.cashed_on}"
                                                >Einlösen
                                                    <CashIcon class="ml-2 h-4 w-4" />
                                                    <span class="sr-only">, {{ voucher.code }}</span>
                                                </button>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-1 pr-1 text-right text-sm font-medium sm:pr-6">
                                                <button
                                                    @click="showModal(voucher)"
                                                    :disabled="!voucher.amount_history.length > 1"
                                                    class="flex text-gray-400 hover:text-gray-500"
                                                    :class="{ 'text-gray-200 hover:text-gray-200 cursor-not-allowed' : voucher.amount_history.length > 1 }"
                                                >
                                                    <PencilAltIcon class="w-4 h-4" />
                                                    <span class="sr-only">, {{ voucher.code }}</span>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Pagination
                                        :current="vouchers.current_page"
                                        :from="vouchers.from"
                                        :last-page="vouchers.last_page"
                                        :path="vouchers.path">
                                    </Pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center">
                    <div class="text-center mb-3">
                        <div class="flex justify-center">
                            <CubeTransparentIcon class="h-20 w-20 text-gray-200" />
                        </div>
                        <h3 class="mt-2 font-medium text-gray-900">Keine Gutscheine bisher</h3>
                        <p class="mt-2 text-sm text-gray-500">Fang an und erstelle deinen ersten Gutschein.</p>
                        <div class="mt-6">
                            <button @click="showModal" type="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" >
                                <GiftIcon class="-ml-1 mr-2 h-4 w-4" aria-hidden="true" />
                                Erster Gutschein!
                            </button>
                        </div>
                    </div>
                    <p class="mb-3 text-sm text-gray-500">ODER</p>
                    <JetButton type="button" @click="initialImport=true">Gutschein Excelimport</JetButton>
                    <ExcelImport :show="initialImport" @close-dialog="initialImport = false"></ExcelImport>
                </div>

            </div>
            <VoucherUpdateCreate :show="modal" :voucher="selected" :is-cash="isCash"
                                 @close-dialog="modal = false; selected = null; isCash = false"></VoucherUpdateCreate>

            <Notification v-for="notification in notifications"
                          :title="notification.title"
                          :error="notification.message"
                          :seed="notification.seed">
            </Notification>
        </div>
    </AppLayout>
</template>

