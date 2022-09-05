<script setup>

const features = [
    {
        title: 'Gutscheine anlegen',
        package: 'free',
        description: 'Legen Sie Gutscheine einfach und bequem an - und das von überall wo Sie gerade sind. Sie brauchen lediglich Internet.'
    },
    {
        title: 'Gutscheine drucken',
        package: 'free',
        description: 'Sie können angelegte Gutscheine jederzeit ausdrucken. Den Gutschein können Sie mit eigenem Logo und Text versehen.'
    },
    {
        title: 'Gutscheine einlösen',
        package: 'free',
        description: 'Sie können Gutscheine ganz oder zum Teil einlösen und haben so stets den Überblick.'
    },
    {
        title: 'Steuerreport',
        package: 'free',
        description: 'Erzeugen Sie detaillierte Reports für Ihren Steuerberater oder die Buchhaltung.'
    },
    {
        title: 'Excel Import',
        package: 'free',
        description: 'Sie haben bereits ein Excel Liste für Ihre Gutscheine? Importieren Sie sie einfach!'
    },
    {
        title: 'Excel Export',
        package: 'free',
        description: 'Es sind Ihre Gutscheine! Deswegen können Sie jederzeit die gesamte Liste Ihrer Gutscheine exportieren.'
    },
    // {
    //     title: 'Gutscheine verkaufen (Website)',
    //     package: 'premium',
    //     description: 'Umsatz steigern leicht gemacht: Kopieren Sie unseren HTML Tag auf ihre Website und los gehts.'
    // },
    // {
    //     title: 'Gutscheine verkaufen (Helevo)',
    //     package: 'premium',
    //     description: 'Keine eigene Website? Kein Problem! Teilen Sie den Helevo Link Ihres Unternehmens und verkaufen Sie Gutscheine bequem über Uns!'
    // },
]


</script>


<template>
    <div class="mx-auto max-w-7xl pb-16 px-4 sm:px-6 lg:pb-16 lg:px-8">
        <dl class="space-y-10 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-4 lg:gap-x-8">
            <div v-for="feature in features" class="relative">
                <dt>
                    <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <p class="flex ml-9 text-lg font-medium leading-6 text-gray-900">{{ feature.title }}
                        <span
                            class="ml-2 inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"
                            :class="feature.package === 'free' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800'"
                        >
                            {{ feature.package }}
                        </span>
                    </p>
                </dt>
                <dd class="mt-2 ml-9 text-base text-gray-500">{{ feature.description }}</dd>
            </div>
        </dl>
    </div>
</template>
