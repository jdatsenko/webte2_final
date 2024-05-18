<script setup>
import { onMounted, ref } from "vue";
import { useAdminStore } from "./admin.store";
import { useToast } from "primevue/usetoast";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dialog from "primevue/dialog";
import SplitButton from "primevue/splitbutton";
import InputText from "primevue/inputtext";
import DynamicDialog from "primevue/dynamicdialog";
import {
  ChangeUserPassword,
  ChangeUserUsername,
  DeleteUser,
  MakeUserAdmin,
  RevokeUserAdmin,
} from "@/api";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import { useDialog } from "primevue/usedialog";
import Button from "primevue/button";
import Register from "../Register.vue";

const toast = useToast();
const dialog = useDialog();
const confirm = useConfirm();
const { state, refetchUsers } = useAdminStore();

onMounted(async () => {
  await refetchUsers();
});

const selectedUser = ref({});
const changePasswordDialogVisible = ref(false);
const editUserDialogVisible = ref(false);

function getSplitButtonItems(data) {
  const items = [];
  items.push(
    {
      label: "Change password",
      command: () => {
        Object.assign(selectedUser.value, data);
        changePasswordDialogVisible.value = true;
      },
    },
    {
      label: "Delete",
      command: async () => {
        Object.assign(selectedUser.value, data);
        confirmDeleteUser();
      },
    }
  );
  if (data.roles_mask == 1) {
    items.push({
      label: "Revoke admin",
      command: async () => {
        const res = await RevokeUserAdmin.post({ id: data.id });
        if (res.data.success) {
          toast.add({
            severity: "success",
            summary: "Success",
            detail: res.data.message,
          });
          await refetchUsers();
        } else {
          toast.add({
            severity: "error",
            summary: "Error",
            detail: res.data.message,
          });
        }
      },
    });
  } else {
    items.push({
      label: "Grant admin",
      command: async () => {
        const res = await MakeUserAdmin.post({ id: data.id });
        if (res.data.success) {
          toast.add({
            severity: "success",
            summary: "Success",
            detail: res.data.message,
          });
          await refetchUsers();
        } else {
          toast.add({
            severity: "error",
            summary: "Error",
            detail: res.data.message,
          });
        }
      },
    });
  }
  return items;
}

function edit(data) {
  Object.assign(selectedUser.value, data);
  editUserDialogVisible.value = true;
}

const changePasswordFormData = ref({
  password: "",
  repeatPassword: "",
});

async function changePassword() {
  if (
    changePasswordFormData.value.password !==
    changePasswordFormData.value.repeatPassword
  ) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Passwords do not match",
    });
    return;
  }
  const res = await ChangeUserPassword.post({
    id: selectedUser.value.id,
    newPassword: changePasswordFormData.value.password,
  });
  if (res.data.success) {
    toast.add({
      severity: "success",
      summary: "Success",
      detail: res.data.message,
    });
    changePasswordDialogVisible.value = false;
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: res.data.message,
    });
  }
}

async function changeUsername() {
  if (selectedUser.value.username.trim() === "") {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Username cannot be empty",
    });
    return;
  }
  const res = await ChangeUserUsername.post({
    id: selectedUser.value.id,
    newUsername: selectedUser.value.username,
  });
  if (res.data.success) {
    toast.add({
      severity: "success",
      summary: "Success",
      detail: res.data.message,
    });
    editUserDialogVisible.value = false;
    const res = await refetchUsers();
    if (!res.data.success) {
      toast.add({
        severity: "error",
        summary: "Error",
        detail: res.data.message,
      });
    }
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: res.data.message,
    });
  }
}

const confirmDeleteUser = () => {
  confirm.require({
    message: "Do you want to delete this user?",
    header: "Deleting user",
    icon: "pi pi-info-circle",
    rejectLabel: "Cancel",
    acceptLabel: "Delete",
    rejectClass: "p-button-secondary p-button-outlined",
    acceptClass: "p-button-danger",
    accept: async () => {
      const res = await DeleteUser.post({ id: selectedUser.value.id });
      if (res.data.success) {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: res.data.message,
        });
        const res = await refetchUsers();
        if (!res.data.success) {
          toast.add({
            severity: "error",
            summary: "Error",
            detail: res.data.message,
          });
        }
      } else {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: res.data.message,
        });
      }
    },
    reject: () => {},
  });
};
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div
      class="flex gap-4 align-items-center justify-content-between flex-column md:flex-row"
    >
      <h1 class="p-text-bold p-text-center">Users</h1>
      <Button
        label="Create user"
        @click="
          dialog.open(Register, {
            data: {
              user: 'primetime',
            },
            props: {
              pt: {
                header: 'pb-0',
              },
            },
          })
        "
      />
    </div>
    <div class="px-6">
      <DataTable
        :value="state.users"
        :paginator="true"
        :rows="10"
        :rowsPerPageOptions="[5, 10, 20]"
      >
        <Column sortable field="username" header="Username"></Column>
        <Column sortable field="email" header="Email"></Column>
        <Column sortable field="roles_mask" header="Admin?">
          <template #body="{ data }">
            {{ data.roles_mask == 1 ? "Yes" : "No" }}
          </template>
        </Column>
        <Column sortable field="registered" header="Registration date">
          <template #body="{ data }">
            {{
              new Date(parseInt(data.registered * 1000)).toLocaleDateString()
            }}
          </template>
        </Column>
        <Column sortable field="last_login" header="Last login date">
          <template #body="{ data }">
            {{
              data.last_login
                ? new Date(
                    parseInt(data.last_login * 1000)
                  ).toLocaleDateString()
                : "Never"
            }}
          </template>
        </Column>
        <Column
          :pt="{
            bodyCell: 'text-center',
          }"
        >
          <template #header>
            <span class="flex-1 text-center">Actions</span>
          </template>
          <template #body="{ data }">
            <SplitButton
              :model="getSplitButtonItems(data)"
              label="Edit"
              @click="edit(data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog
    v-model:visible="changePasswordDialogVisible"
    modal
    header="Edit Profile"
    :style="{ width: '25rem' }"
  >
    <span class="p-text-secondary block mb-5">
      Change password for user {{ selectedUser?.username }}
    </span>
    <div class="flex align-items-center gap-3 mb-3">
      <label for="password" class="font-semibold w-6rem">Password</label>
      <InputText
        id="password"
        class="flex-auto"
        autocomplete="off"
        v-model="changePasswordFormData.password"
      />
    </div>
    <div class="flex align-items-center gap-3 mb-5">
      <label for="repeatPassword" class="font-semibold w-6rem">
        Repeat password
      </label>
      <InputText
        id="repeatPassword"
        class="flex-auto"
        autocomplete="off"
        v-model="changePasswordFormData.repeatPassword"
      />
    </div>
    <div class="flex justify-content-end gap-2">
      <Button
        type="button"
        label="Cancel"
        severity="secondary"
        @click="changePasswordDialogVisible = false"
      />
      <Button type="button" label="Save" @click="changePassword" />
    </div>
  </Dialog>

  <Dialog
    v-model:visible="editUserDialogVisible"
    modal
    header="Edit Profile"
    :style="{ width: '25rem' }"
  >
    <span class="p-text-secondary block mb-5"> Update information. </span>
    <div class="flex align-items-center gap-3 mb-3">
      <label for="email" class="font-semibold w-6rem">Email</label>
      <InputText
        id="email"
        class="flex-auto"
        v-model="selectedUser.email"
        readonly
        disabled
      />
    </div>
    <div class="flex align-items-center gap-3 mb-5">
      <label for="username" class="font-semibold w-6rem"> Username </label>
      <InputText
        id="username"
        class="flex-auto"
        v-model="selectedUser.username"
      />
    </div>
    <div class="flex justify-content-end gap-2">
      <Button
        type="button"
        label="Cancel"
        severity="secondary"
        @click="editUserDialogVisible = false"
      />
      <Button type="button" label="Save" @click="changeUsername" />
    </div>
  </Dialog>
  <ConfirmDialog />
  <DynamicDialog />
</template>
