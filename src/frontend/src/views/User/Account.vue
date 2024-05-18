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
import Dropdown from "primevue/dropdown";
import { DeleteQuestion, DuplicateQuestion, ChangeQuestionStatus } from "@/api";

const { state, getUserQuestions } = useUserStore();

const toast = useToast();

onMounted(async () => {
  await getUserQuestions();
  uniqueSubjects.value = [
    ...new Set(state.questions.map((q) => q.subject)),
  ].map((subject) => ({ subject }));
  if (state.user.isAdmin) {
    uniqueUsernames.value = [
      ...new Set(state.questions.map((q) => q.username)),
    ].map((username) => ({ username }));
  }
});

function getSplitButtonItems(data) {
  const items = [
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
            getUserQuestions();
            console.log(response);
          })
          .catch((error) => {
            console.error("Error duplicating question:", error);
          });
      },
    },
    {
      label: "Delete",
      command: async () => {
        const code = data.code;
        const res = await DeleteQuestion.post({ code });
        if (res.data.success) {
          toast.add({
            severity: "success",
            summary: "Success",
            detail: res.data.message,
            life: 3000,
          });
          getUserQuestions();
        } else {
          toast.add({
            severity: "error",
            summary: "Error",
            detail: res.data.message,
            life: 3000,
          });
        }
      },
    },
  ];
  items.push({
    label: data.isActive == '1' ? "Deactivate" : "Activate",
    command: async () => {
      const code = data.code;
      const res = await ChangeQuestionStatus.post({ code });
      if (res.data.success) {
        data.isActive = data.isActive == '1' ? '0' : '1';
        toast.add({
          severity: "success",
          summary: `${data.isActive == '1' ? "Activation" : "Deactivation"} Successful`,
          detail: res.data.message,
          life: 3000,
        });
        await getUserQuestions();
      } else {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: res.data.message,
          life: 3000,
        });
      }
    },
  });
  return items;
}

const showQRCode = (code) => {
  isDialogVisible.value = true;
  qrCodeURL.value = `${window.location.origin}/question/${code}`;
};

const isDialogVisible = ref(false);
const qrCodeURL = ref("");

const uniqueSubjects = ref([]);
const selectedSubject = ref(null);

const uniqueUsernames = ref([]);
const selectedUsername = ref(null);
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div class="flex gap-4 align-items-center justify-content-between flex-column md:flex-row">
      <h1 class="p-text-bold p-text-center">{{ t("Account.title") }}</h1>
      <Button label="Change Password" @click="router.push('/user/password')" />
    </div>

    <div>
      <h3>Questions:</h3>
      <div class="flex flex-row gap-2">
        <Dropdown v-model="selectedSubject" :options="uniqueSubjects" optionLabel="subject"
          placeholder="Select a subject" showClear class="w-12rem" />
        <Dropdown v-model="selectedUsername" :options="uniqueUsernames" optionLabel="username"
          placeholder="Select a user" showClear v-if="state.user.isAdmin" class="w-12rem" />
      </div>
      <DataTable :value="state.questions
          .filter(
            (q) =>
              selectedSubject === null ||
              q.subject === selectedSubject.subject
          )
          .filter(
            (q) =>
              selectedUsername === null ||
              q.username === selectedUsername.username
          )
        " paginator stripedRows :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]">
        <Column field="code" header="Code">
          <template #body="slotProps">
            <router-link :to="{
        name: 'result',
        params: { questionCode: slotProps.data.code },
      }">
              <b>{{ slotProps.data.code }}</b>
            </router-link>
          </template>
        </Column>
        <Column field="subject" header="Subject"></Column>
        <Column field="question" header="Question"></Column>
        <Column field="response_count" header="Reponses"></Column>
        <Column v-if="state.user.isAdmin" field="username" header="Username"></Column>
        <Column field="isActive" header="Is Active?">
          <template #body="slotProps">
            <Tag :value="slotProps.data.isActive == '1' ? 'Yes' : 'No'"
              :severity="slotProps.data.isActive == '1' ? 'success' : 'danger'" rounded />
          </template>
        </Column>
        <Column field="type" header="Type">
          <template #body="slotProps">
            <Tag :value="slotProps.data.type" :severity="slotProps.data.type === 'choice' ? 'info' : 'warning'"
              rounded />
          </template>
        </Column>
        <Column :pt="{
        bodyCell: 'text-center',
      }">
          <template #header>
            <span class="flex-1 text-center">Actions</span>
          </template>
          <template #body="slotProps">
            <SplitButton :model="getSplitButtonItems(slotProps.data)" label="Show QR Code"
              @click="showQRCode(slotProps.data.code)" />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog v-model:visible="isDialogVisible" modal :pt="{
        root: 'border-none',
        mask: {
          style: 'backdrop-filter: blur(2px)',
        },
      }">
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
