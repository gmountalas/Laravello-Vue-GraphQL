<template>
  <div class="bg-gray-300 rounded-sm p-2 mr-2 list">
    <div class="flex justify-between">
      <div class="text-gray-800 pl-2 pb-2 font-bold">{{ list.title }}</div>
    </div>

    <card v-for="card in list.cards" :key="card.id" :card="card"></card>

    <card-editor></card-editor>
    <card-add-button></card-add-button>
  </div>
</template>

<script>
import Card from "./Card";
import CardAddButton from "./CardAddButton";
import CardEditor from "./CardEditor";

export default {
  components: {
    Card,
    CardAddButton,
    CardEditor
  },
  props: {
    list: Object
  }
};
</script>

<style scoped>
.list {
  width: 250px;
  min-width: 250px;
}
</style>
