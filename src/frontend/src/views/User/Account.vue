<script setup>
import { t } from "@/i18n";
import { useUserStore } from "@/stores/user.store";
import { router } from "@/router";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Tag from "primevue/tag";
import { onMounted, ref } from "vue";
import SplitButton from "primevue/splitbutton";
import { useToast } from "primevue/usetoast";
import Dialog from "primevue/dialog";
import VueQrcode from "@chenfengyuan/vue-qrcode";
import { DeleteQuestion } from "@/api";
import { DuplicateQuestion } from "@/api";

const { state, getUserQuestions } = useUserStore();

const toast = useToast();

onMounted(async () => {
  await getUserQuestions();
});

function getSplitButtonItems(data) {
  return [
    {
      label: "Edit",
      command: () => {
        toast.add({
          severity: "success",
          summary: "Edit",
          detail: "Edit",
          life: 3000,
        });
      },
    },
    {
      label: "Duplicate",
      command: () => {
        const code = data.code;
        toast.add({
          severity: "warn",
          summary: `Duplicate ${code}`,
          detail: "Duplicate",
          life: 3000,
        });
        DuplicateQuestion.post({ code })
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.error("Error duplicating question:", error);
          });
          getUserQuestions();
      },
    },
    {
      label: "Delete",
      command: () => {
        const code = data.code;
        toast.add({
          severity: "warn",
          summary: `Delete ${code}`,
          detail: "Delete",
          life: 3000,
        });

        DeleteQuestion.post({ code })
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.error("Error deleting question:", error);
          });
          getUserQuestions();
      },
    },
  ];
}

const showQRCode = (code) => {
  isDialogVisible.value = true;
  qrCodeURL.value = `${window.location.origin}/question/${code}`;
};

const isDialogVisible = ref(false);
const qrCodeURL = ref("");
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div
      class="flex gap-4 align-items-center justify-content-between flex-column md:flex-row"
    >
      <h1 class="p-text-bold p-text-center">{{ t("Account.title") }}</h1>
      <Button label="Change Password" @click="router.push('/user/password')" />
    </div>

    <div>
      <h3>My questions:</h3>
      <DataTable
        :value="state.questions"
        paginator
        stripedRows
        :rows="5"
        :rowsPerPageOptions="[5, 10, 20, 50]"
      >
        <Column field="code" header="Code">
          <template #body="slotProps">
            <router-link
              :to="{
                name: 'questionStats',
                params: { code: slotProps.data.code },
              }"
            >
              <b>{{ slotProps.data.code }}</b>
            </router-link>
          </template>
        </Column>
        <Column field="subject" header="Subject"></Column>
        <Column field="question" header="Question"></Column>
        <Column field="response_count" header="Reponses"></Column>
        <Column field="type" header="Type">
          <template #body="slotProps">
            <Tag
              :value="slotProps.data.type"
              :severity="slotProps.data.type === 'choice' ? 'info' : 'warning'"
              rounded
            />
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
          <template #body="slotProps">
            <SplitButton
              :model="getSplitButtonItems(slotProps.data)"
              label="Show QR Code"
              @click="showQRCode(slotProps.data.code)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog
    v-model:visible="isDialogVisible"
    modal
    :pt="{
      root: 'border-none',
      mask: {
        style: 'backdrop-filter: blur(2px)',
      },
    }"
  >
    <template #container="{ closeCallback }">
      <div class="flex flex-column px-5 py-5 gap-2" style="border-radius: 12px">
        <span class="text-center" style="color: var(--text-color-secondary)">
          Scan the QR Code
        </span>
        <VueQrcode :value="qrCodeURL" :options="{ width: 300 }" />
        <Button label="Close" @click="closeCallback" />
      </div>
    </template>
  </Dialog>
</template>
