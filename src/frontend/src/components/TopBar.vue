<template>
    <div class="fixed w-full h-4rem top-0 left-0 py-2 px-4 shadow-2 flex align-items-center justify-content-between" style="z-index: 999;">
        <span class="text-lg font-bold cursor-pointer" @click="router.push('/')">My App</span>
        <div class="flex gap-2">
            <Button icon="pi pi-globe" outlined @click="changeLocale()" />
            <Button icon="pi pi-user-plus" outlined @click="router.push('/register')" />
            <Button icon="pi pi-sign-in"   @click="router.push('/login')" />
        </div>
    </div>
</template>

<script setup>
import Button from 'primevue/button';
import { router } from "../router";
import { changeLocale } from "../i18n";
</script>