<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Notification from "../Components/Notification.vue";
import JetButton from '@/Jetstream/Button.vue';
import FileUpload from '@/Components/FileUpload.vue';
import {InformationCircleIcon, XCircleIcon, XIcon} from '@heroicons/vue/outline';
import {useForm} from "@inertiajs/inertia-vue3";
import {watch, ref} from "vue";

const props = defineProps({
    name: String,
    text: String,
    prefix: String,
    logo: String
});

const seen = ref(false);

watch(props, (o, n) => {
    form.prefix = n.prefix;
})

const form = useForm({
    prefix: props.prefix,
    name: props.name,
    text: props.text ?? '',
    logo: null
})

function handleFile(files) {
    form.logo = files[0];
}

function submit() {
    form.post('/settings', {
        onSuccess: () => form.logo = null
    });
}

function getFilename(path) {
    return path.split('/')[1];
}

function deleteFile() {
    form.logo = null;
}

function hasSeen() {
    seen.value = true;
}

</script>
<template>
    <AppLayout title="Einstellungen">

        <div v-if="!seen" class="mt-12">
            <div class="max-w-7xl shadow-lg mx-auto sm:px-6 lg:px-8 rounded-md bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <InformationCircleIcon class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">
                            Wir arbeiten unter hochdruck daran, euch bald auch <strong>SVG uploads</strong> und weitere <strong>Gutschein Design
                            Vorlagen</strong> anzubieten.
                        </p>
                        <XIcon class="h-5 w-5 text-blue-500 cursor-pointer" @click="hasSeen()" />
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Einstellungen</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Hier kannst du alle relevanten Daten pflegen, die Du für deine Gutscheine brauchst.
                                </p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent>
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="col-span-6">
                                            <label for="street-address" class="block text-sm font-medium text-gray-700">Firmenname</label>
                                            <input v-model="form.name" type="text" name="street-address"
                                                   id="street-address"
                                                   autocomplete="street-address"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <div v-if="form.errors.name" class="text-sm text-red-500">
                                                {{ form.errors.name }}
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website"
                                                       class="block text-sm font-medium text-gray-700"> Prefix für den
                                                    Gutschein-Code (Beispiel:
                                                    {{ form.prefix.length > 0 ? form.prefix : 'HV' }}-ABC124) </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input v-model="form.prefix" type="text" name="company-website"
                                                           id="company-website"
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                           placeholder="HM" />
                                                </div>
                                                <div v-if="form.errors.prefix"
                                                     class="flex justify-items-start text-red-500 text-sm">{{
                                                        form.errors.prefix
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="comment" class="block text-sm font-medium text-gray-700">Persönlicher Gutschein-Text ( {{ 255 - form.text.length }} Zeichen übrig)</label>
                                            <div class="mt-1">
                                                <textarea v-model="form.text" placeholder="Finde ein paar warme Worte für deine Kunden. Dieser Text wird auf dem Gutschein platziert." rows="4" name="comment" id="comment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                            </div>
                                            <div v-if="form.errors.text" class="text-sm text-red-500">
                                                {{ form.errors.text }}
                                            </div>
                                        </div>
                                        <div>
                                            <div v-if="logo" class="mb-6">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-4">Aktuelles
                                                    Unternehmenslogo:</label>
                                                <img alt="logo" width="120" height="120"
                                                     :src="route('logos.show', getFilename(logo))" />
                                            </div>

                                            <label
                                                class="block text-sm font-medium text-gray-700">{{
                                                    logo ? 'Neues Logo' : 'Unternehmenslogo'
                                                }}</label>
                                            <FileUpload v-if="form.logo === null" @files="handleFile"
                                                        :file-types="['PNG', 'JPG', 'SVG']" max="1MB" />
                                            <span class="text-sm text-gray-500 flex font-semibold my-2" v-else>
                                                <XCircleIcon
                                                    class="w-4 h-4 mr-1 text-red-500 hover:text-red-600 cursor-pointer"
                                                    @click="deleteFile()" />
                                                {{ form.logo?.name }}
                                            </span>
                                            <div v-if="form.errors.logo" class="text-sm text-red-500">
                                                {{ form.errors.logo }}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <JetButton :disabled="!form.isDirty" type="button" @click="submit">
                                            Speichern
                                        </JetButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <Notification v-for="notification in notifications"
                          :title="notification.title"
                          :error="notification.message"
                          :seed="notification.seed">
            </Notification>
        </div>
    </AppLayout>
</template>

