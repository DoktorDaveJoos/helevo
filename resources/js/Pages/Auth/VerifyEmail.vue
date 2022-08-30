<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';

const props = defineProps({
    status: String,
});

const form = useForm();

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Bevor Sie fortfahren, bestätigen Sie bitte Ihre E-Mail-Adresse, indem Sie auf den Link klicken, den wir Ihnen soeben per E-Mail geschickt haben. Wenn Sie die E-Mail nicht erhalten haben, schicken wir Ihnen gerne eine neue zu.
        </div>

        <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
            Es wurde ein neuer Verifizierungslink an die E-Mail-Adresse gesendet, die Sie in Ihren Profileinstellungen angegeben haben.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    E-Mail erneut senden
                </JetButton>

                <div>
                    <Link
                        :href="route('profile.show')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Profil</Link>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ml-2"
                    >
                        Ausloggen
                    </Link>
                </div>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
