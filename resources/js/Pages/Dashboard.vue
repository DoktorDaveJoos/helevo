<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AmountModal from "@/Components/AmountModal.vue";
import EditModal from "@/Components/EditModal.vue";
import Pagination from "../Components/Pagination.vue";
import Notification from "../Components/Notification.vue";
import {computed, defineProps, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import ActionBar from "../Components/ActionBar.vue";
import {voucherCashRoute} from "../Helper/routes";
import {usePage} from "@inertiajs/inertia-vue3";

const props = defineProps({
    vouchers: Object,
});

const modal = ref(false);
const editModal = ref(false);
const selected = ref(null);

function showModal() {
    modal.value = !modal.value;
}

function showEditModal(voucher) {
    selected.value = voucher;
    editModal.value = !editModal.value;
}

function cash(voucher) {
    Inertia.put(voucherCashRoute(voucher.id), {cashed: voucher.cashed_on === null}, {
        preserveScroll: true
    });
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
            <AmountModal :open="modal" @modalClose="modal = false"></AmountModal>
            <EditModal :open="editModal"
                       @modalClose="editModal = false; selected.value = null"
                       :voucher="selected">
            </EditModal>
            <Notification v-for="notification in notifications"
                          :title="notification.title"
                          :error="notification.message"
                          :seed="notification.seed">
            </Notification>
        </div>
    </AppLayout>
</template>

