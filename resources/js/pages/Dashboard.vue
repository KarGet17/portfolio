<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import { Mail, Phone, Trash2 } from '@lucide/vue';

type CleaningRequest = {
    id: number;
    name: string;
    phone: string;
    email: string | null;
    service: string;
    address: string | null;
    message: string | null;
    created_at: string | null;
};

const props = defineProps<{
    requests: CleaningRequest[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Заявки CleanPro',
                href: dashboard(),
            },
        ],
    },
});

const deleteRequest = (request: CleaningRequest) => {
    if (!window.confirm(`Удалить заявку от ${request.name}?`)) {
        return;
    }

    router.delete(`/requests/${request.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Заявки CleanPro" />

    <div class="space-y-6 p-4 md:p-6">
        <div
            class="rounded-lg border bg-white p-5 shadow-sm dark:bg-neutral-950"
        >
            <p
                class="text-sm font-semibold tracking-wide text-emerald-700 uppercase"
            >
                CleanPro admin
            </p>
            <div
                class="mt-2 flex flex-col gap-2 md:flex-row md:items-end md:justify-between"
            >
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        Заявки клиентов
                    </h1>
                    <p class="mt-2 max-w-2xl text-muted-foreground">
                        Простая админка: здесь можно посмотреть новые заявки с
                        формы и удалить обработанные.
                    </p>
                </div>
                <div
                    class="rounded-md bg-emerald-50 px-4 py-3 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-100"
                >
                    <span class="text-2xl font-bold">
                        {{ props.requests.length }}
                    </span>
                    <span class="ml-2 text-sm font-semibold">заявок</span>
                </div>
            </div>
        </div>

        <div
            v-if="props.requests.length === 0"
            class="rounded-lg border border-dashed bg-white p-8 text-center text-muted-foreground dark:bg-neutral-950"
        >
            Заявок пока нет. Когда клиент отправит форму на главной странице,
            она появится здесь.
        </div>

        <div v-else class="grid gap-4">
            <article
                v-for="request in props.requests"
                :key="request.id"
                class="rounded-lg border bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:bg-neutral-950"
            >
                <div
                    class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between"
                >
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-xl font-bold">
                                {{ request.name }}
                            </h2>
                            <span
                                class="rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-100"
                            >
                                {{ request.service }}
                            </span>
                            <span class="text-sm text-muted-foreground">
                                {{ request.created_at }}
                            </span>
                        </div>

                        <div class="mt-4 grid gap-2 text-sm md:grid-cols-2">
                            <a
                                class="inline-flex items-center gap-2 font-semibold text-foreground"
                                :href="`tel:${request.phone}`"
                            >
                                <Phone :size="16" />
                                {{ request.phone }}
                            </a>
                            <a
                                v-if="request.email"
                                class="inline-flex items-center gap-2 font-semibold text-foreground"
                                :href="`mailto:${request.email}`"
                            >
                                <Mail :size="16" />
                                {{ request.email }}
                            </a>
                        </div>

                        <p
                            v-if="request.address"
                            class="mt-3 text-sm text-muted-foreground"
                        >
                            Адрес: {{ request.address }}
                        </p>
                        <p
                            v-if="request.message"
                            class="mt-3 max-w-3xl text-sm leading-6 text-muted-foreground"
                        >
                            {{ request.message }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-red-200 px-3 text-sm font-bold text-red-700 transition hover:bg-red-50 dark:border-red-900 dark:text-red-300 dark:hover:bg-red-950"
                        @click="deleteRequest(request)"
                    >
                        <Trash2 :size="16" />
                        Удалить
                    </button>
                </div>
            </article>
        </div>
    </div>
</template>
