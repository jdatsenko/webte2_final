<script setup>
import { ref } from "vue";
import { t } from "@/i18n";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import { router } from "../router";
import { useToast } from "primevue/usetoast";
import { Login } from "@/api";
import { reactive } from "vue";
import { useUserStore } from "../stores/user.store";

const formData = reactive({
  email: "",
  password: "",
});

const toast = useToast();

const { getUserInfo } = useUserStore();

const login = async () => {
  if (!formData.email || !formData.password) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Email and password are required",
    });
    return;
  }

  const response = await Login.post({
    email: formData.email,
    password: formData.password,
  });

  if (response.data.success) {
    toast.add({
      severity: "success",
      summary: "Success",
      detail: response.data.message,
    });

    await getUserInfo();
    router.push("/");
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: response.data.message,
    });
  }
};
</script>

<template>
  <div class="flex justify-content-center flex-wrap">
    <h1 class="p-text-bold p-text-center">{{ t("Login.title") }}</h1>
  </div>
  <div class="card flex mb-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="email">Email</label>
      <InputText id="email" v-model="formData.email" class="w-20rem" />
    </div>
  </div>
  <div class="card flex my-3 justify-content-center">
    <div class="flex flex-column gap-2">
      <label for="password">Password</label>
      <Password
        v-model="formData.password"
        :feedback="false"
        toggleMask
        inputClass="w-20rem"
      />
    </div>
  </div>

  <div class="card flex justify-content-center">
    <Button label="Submit" @click="login" />
  </div>
  <div class="flex mt-4 justify-content-center">
    <div class="flex align-items-center">
      <span>Haven't registered yet?</span>
    </div>
    <div class="ml-2">
      <Button label="Register" outlined @click="router.push('/register')" />
    </div>
  </div>
</template>
