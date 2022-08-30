<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import {watch} from "vue";
import FileUpload from "../Components/FileUpload.vue";

const props = defineProps({
    prefix: String
});

watch(props, (o, n) => {
    form.prefix = n.prefix;
})

const form = useForm({
    prefix: props.prefix
})

function submit() {
    form.put('/settings');
}

</script>
<template>
    <AppLayout title="Einstellungen">

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Deine Verkaufsseite</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Wir brauchen diese Daten um Dir deinen Onlinegutscheinverkauf zu generieren!
                                Bitte trage wenn möglich deine Daten ein und drücke anschließend auf Speichern.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="company-website" class="block text-sm font-medium text-gray-700"> Deine Website </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <span
                                                    class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"> http:// </span>
                                                <input type="text" name="company-website" id="company-website"
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                                       placeholder="www.example.com" />
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="about" class="block text-sm font-medium text-gray-700">
                                            Begrüßungstext </label>
                                        <div class="mt-1">
                                            <textarea id="about" name="about" rows="3"
                                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                      placeholder="Willkommen, [...]" />
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Dieser Text wird auf deiner Gutschein Verkaufsseite angezeigt.
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700"> Firmenlogo </label>
                                        <FileUpload :file-types="['JPEG', 'PNG']"></FileUpload>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

