<script setup>
    import { computed } from "vue";
    import { t } from "@/i18n";
    import { reactive } from "vue";
    import { useToast } from "primevue/usetoast";
    import Password from "primevue/password";
    import Button from "primevue/button";
    import Divider from "primevue/divider";
    import { ChangePassword } from "@/api";

    const formData = reactive({
        oldPassword: "",
        newPassword: "",
        repeatPassword: "",
    });

    const toast = useToast();
    const passwordHasLowercase = computed(() => /[a-z]/.test(formData.newPassword));
    const passwordHasUppercase = computed(() => /[A-Z]/.test(formData.newPassword));
    const passwordHasNumber = computed(() => /[0-9]/.test(formData.newPassword));
    const passwordHasMinLength = computed(() => formData.newPassword.length >= 8);

    const changePassword = async () => {

        // check password strength
        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        if (!passwordRegex.test(formData.newPassword)) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "Password is not strong enough",
            });
            return;
        }

        // check password match
        if (formData.newPassword !== formData.repeatPassword) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "Passwords do not match",
            });
            return;
        }

        if (!formData.newPassword || !formData.oldPassword) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "new Password and old Password are required",
            });
            return;
        }

        const response = await ChangePassword.post({
            oldPassword: formData.oldPassword,
            newPassword: formData.newPassword
        });

        if (response.data.success) {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: response.data.message,
            });

            router.push("/");
        } else {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: response.data.message,
            }); 
        }
    }
</script>

<template>
    <div class="flex justify-content-center">
        <h1 class="p-text-bold p-text-center">{{ t("Account.title") }}</h1>
    </div>

    <div class="card flex mb-3 justify-content-center">
        <div class="flex flex-column gap-2">
        <label for="password">{{ t("Account.oldPassword") }}</label>
        <Password
            v-model="formData.oldPassword"
            :feedback="false"
            autocomplete="off"
            toggleMask
            inputClass="w-20rem"
        />
        </div>
    </div>

    <div class="card flex mb-3 justify-content-center">
        <div class="flex flex-column gap-2">
        <label for="password">{{ t("Account.newPassword") }}</label>
        <Password
            v-model="formData.newPassword"
            :feedback="false"
            autocomplete="off"
            toggleMask
            inputClass="w-20rem"
        />
        <template>
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
        </div>
    </div>

    <div class="card flex mb-3 justify-content-center">
        <div class="flex flex-column gap-2">
        <label for="password">{{ t("Account.repeatPassword") }}</label>
        <Password
            v-model="formData.repeatPassword"
            :feedback="false"
            autocomplete="off"
            toggleMask
            inputClass="w-20rem"
        />
        </div>
    </div>

    <div class="card flex justify-content-center">
        <Button label="Save" @click="changePassword()" />
    </div>
</template>


