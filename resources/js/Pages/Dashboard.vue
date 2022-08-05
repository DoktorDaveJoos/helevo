<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AmountModal from "@/Components/AmountModal.vue";
import EditModal from "@/Components/EditModal.vue";
import Pagination from "../Components/Pagination.vue";
import {ExclamationCircleIcon} from '@heroicons/vue/outline'
import {XIcon} from '@heroicons/vue/solid'
import {defineProps, ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import ActionBar from "../Components/ActionBar.vue";
import { voucherRoute } from "../Helper/routes";

const props = defineProps({
    vouchers: Object,
    notification: Object
});

const modal = ref(false);
const editModal = ref(false);
const selected = ref(null);
const showWarning = ref(props.notification?.topic !== undefined);

function showModal() {
    modal.value = !modal.value;
}

watch(props, (_, props) => {
    showWarning.value = props.notification?.topic !== undefined;
})

function showEditModal(voucher) {
    selected.value = voucher;
    editModal.value = !editModal.value;
}

function cash(voucher) {
    Inertia.put(voucherRoute(voucher.id),
        {cashed: voucher.cashed_on === null},
        {preserveState: true});
}

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
                            <button @click="showModal"
                                    type="button"
                                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                Neuer Gutschein
                            </button>
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
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Bezahlt am
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Eingelöst am
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
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ voucher.amount }} €
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <template v-if="!voucher.paid_on">
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800"> Geblockt </span>
                                                </template>
                                                <template v-else-if="voucher.cashed_on">
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800"> Eingelöst </span>
                                                </template>
                                                <template v-else>
                                                    <span
                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800"> Offen </span>
                                                </template>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ voucher.paid_on ?? 'Nicht bezahlt' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                                    voucher.cashed_on ?? 'Nicht eingelöst'
                                                }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-1 pr-1 text-right text-sm font-medium sm:pr-6">
                                                <a @click="cash(voucher)" href="#"
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                >{{ voucher.cashed_on === null ? 'Einlösen' : 'Aktivieren' }}<span
                                                    class="sr-only">, {{ voucher.code }}</span></a>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-1 pr-1 text-right text-sm font-medium sm:pr-6">
                                                <a @click="showEditModal(voucher)" href="#"
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                >Bearbeiten<span class="sr-only">, {{ voucher.code }}</span></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Pagination
                                        :from="vouchers.from"
                                        :last-page="vouchers.last_page"
                                        :path="vouchers.path">
                                    </Pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Wir freuen Uns, dass Du da bist!</h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>Du hast noch keine Gutscheine! Bevor du loslegst, sieh doch einmal unter "Konfiguration"
                                nach.</p>
                        </div>
                        <div class="mt-3 text-sm">
                            <a @click="showModal" type="button" href="#"
                               class="font-medium text-indigo-600 hover:text-indigo-500"> Ersten Gutschein
                                jetzt erstellen <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>

            </div>
            <AmountModal :open="modal" @close="modal = false"></AmountModal>
            <EditModal :open="editModal" @close="editModal = false; selected.value = null"
                       :voucher="selected"></EditModal>


            <div aria-live="assertive"
                 class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
                <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                    <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
                    <transition enter-active-class="transform ease-out duration-300 transition"
                                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                                leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                                leave-to-class="opacity-0">
                        <div v-if="showWarning"
                             class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <ExclamationCircleIcon class="h-6 w-6 text-red-400" aria-hidden="true" />
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="text-sm font-medium text-gray-900">{{ notification.topic }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ notification.message }}</p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex">
                                        <button type="button" @click="showWarning = false"
                                                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <span class="sr-only">Close</span>
                                            <XIcon class="h-5 w-5" aria-hidden="true" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

