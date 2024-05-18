<script setup>
import { computed, inject } from "vue";
import { t } from "@/i18n";

import { Register } from "@/api";

import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Divider from "primevue/divider";
import Password from "primevue/password";
import { useToast } from "primevue/usetoast";
import { router } from "../router";
import { reactive } from "vue";
import { useAdminStore } from "./Admin/admin.store";

const toast = useToast();
const dialogRef = inject("dialogRef");
const isDialog = computed(() => dialogRef !== undefined);
const { refetchUsers } = useAdminStore();

const formData = reactive({
  username: "",
  email: "",
  password: "",
  repeatPassword: "",
});

const passwordHasLowercase = computed(() => /[a-z]/.test(formData.password));
const passwordHasUppercase = computed(() => /[A-Z]/.test(formData.password));
const passwordHasNumber = computed(() => /[0-9]/.test(formData.password));
const passwordHasMinLength = computed(() => formData.password.length >= 8);

const register = async () => {
  // check username
  if (formData.username.length < 3) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Username must be at least 3 characters",
      life: 3000,
    });
    return;
  }

  // check email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(formData.email)) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Invalid email",
      life: 3000,
    });
    return;
  }

  // check password strength
  const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  if (!passwordRegex.test(formData.password)) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Password is not strong enough",
      life: 3000,
    });
    return;
  }

  // check password match
  if (formData.password !== formData.repeatPassword) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Passwords do not match",
      life: 3000,
    });
    return;
  }

  const response = await Register.post(formData);
  toast.add({
    severity: response.data.success ? "success" : "error",
    summary: response.data.success ? "Success" : "Error",
    detail: response.data.message,
    life: 3000,
  });

  if (response.data.success) {
    if (isDialog) {
      const res = await refetchUsers();
      if (!res.data.success) {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: res.data.message,
          life: 3000,
        });
      }
      dialogRef.value.close();
    } else {
      router.push("/login");
    }
  }
};
</script>

<template>
  <div class="flex justify-content-center flex-wrap">
    <h1 class="p-text-bold p-text-center">
      {{ isDialog ? "New user" : t("Register.title") }}
    </h1>
  </div>
  <div class="flex mb-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="username">Username</label>
      <InputText id="username" v-model="formData.username" class="w-20rem" />
    </div>
  </div>
  <div class="flex mb-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="email">Email</label>
      <InputText id="email" v-model="formData.email" class="w-20rem" />
    </div>
  </div>
  <div class="flex my-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="value">Password</label>
      <Password
        v-model="formData.password"
        autocomplete="off"
        toggleMask
        inputClass="w-20rem"
      >
        <template #footer>
          <Divider />
          <p class="mt-2">Requirements:</p>
          <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
            <li
              :class="{
                'text-green-500': passwordHasLowercase,
                'text-red-500': !passwordHasLowercase,
              }"
            >
              At least one lowercase
            </li>
            <li
              :class="{
                'text-green-500': passwordHasUppercase,
                'text-red-500': !passwordHasUppercase,
              }"
            >
              At least one uppercase
            </li>
            <li
              :class="{
                'text-green-500': passwordHasNumber,
                'text-red-500': !passwordHasNumber,
              }"
            >
              At least one numeric
            </li>
            <li
              :class="{
                'text-green-500': passwordHasMinLength,
                'text-red-500': !passwordHasMinLength,
              }"
            >
              Minimum 8 characters
            </li>
          </ul>
        </template>
      </Password>
    </div>
  </div>
  <div class="flex my-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="value">Repeat Password</label>
      <Password
        v-model="formData.repeatPassword"
        :feedback="false"
        autocomplete="off"
        toggleMask
        inputClass="w-20rem"
      />
    </div>
  </div>

  <div class="flex justify-content-center">
    <Button label="Submit" @click="register" />
  </div>

  <div class="flex mt-4 justify-content-center" v-if="!isDialog">
    <div class="flex align-items-center">
      <span>Already have an account?</span>
    </div>
    <div class="ml-2">
      <Button label="Login" outlined @click="router.push('/login')" />
    </div>
  </div>
</template>
