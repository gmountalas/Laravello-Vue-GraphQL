<template>
  <div class="bg-gray-300 rounded-sm p-2 mr-2 list">
    <div class="flex justify-between">
      <div class="text-gray-800 pl-2 pb-2 font-bold">{{ list.title }}</div>
    </div>

    <card
      v-for="card in list.cards"
      :key="card.id"
      :card="card"
      @deleted="$emit('card-deleted', { ...$event, listId: list.id })"
    ></card>

    <card-add-editor
      v-if="editing"
      @closed="editing = false"
      :list="list"
      @added="$emit('card-added', { ...$event, listId: list.id })"
    ></card-add-editor>
    <card-add-button v-else @click="editing = true"></card-add-button>
  </div>
</template>

<script>
import Card from "./Card";
import CardAddButton from "./CardAddButton";
import CardAddEditor from "./CardAddEditor";

export default {
  components: {
    Card,
    CardAddButton,
    CardAddEditor
  },
  props: {
    list: Object
  },
  data() {
    return {
      editing: false
    };
  }
};
</script>

<style scoped>
.list {
  width: 250px;
  min-width: 250px;
}
</style>
