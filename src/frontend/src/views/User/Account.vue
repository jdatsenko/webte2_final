<script setup>
import { t } from "@/i18n";
import { useUserStore } from "@/stores/user.store";
import { router } from "@/router";
import Button from "primevue/button";

const { state } = useUserStore();
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <h1 class="p-text-bold p-text-center">{{ t("Account.title") }}</h1>
    <span>Hello, {{ state.user?.username }}s</span>
    <Button
      label="Change Password"
      @click="router.push('/user/change-password')"
    />
  </div>
</template>
