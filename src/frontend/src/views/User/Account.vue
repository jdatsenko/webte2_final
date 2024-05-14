<script setup>
import { t } from "@/i18n";
import { useUserStore } from "@/stores/user.store";
import { router } from "@/router";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Tag from "primevue/tag";
import { onMounted } from "vue";

const { state, getUserQuestions } = useUserStore();

onMounted(async () => {
  await getUserQuestions();
});
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div
      class="flex gap-4 align-items-center justify-content-between flex-column md:flex-row"
    >
      <h1 class="p-text-bold p-text-center">{{ t("Account.title") }}</h1>
      <Button
        label="Change Password"
        @click="router.push('/user/change-password')"
      />
    </div>

    <div>
      <h3>Questions:</h3>
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
              {{ slotProps.data.code }}
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
      </DataTable>
    </div>
  </div>
</template>
