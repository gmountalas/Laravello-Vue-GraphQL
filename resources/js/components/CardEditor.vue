<template>
  <div>
    <textarea
      class=" rounded-md shadow-card py-1 px-2 outline-none w-full text-gray-900 text-sm bg-white h-16 resize-none"
      placeholder="Enter a title for the card..."
      v-model="title"
      ref="card"
      @keyup.esc="closed"
      @keyup.enter="addCard"
    ></textarea>

    <div class="flex">
      <button
        @click="addCard"
        class=" rounded-sm py-1 px-3 bg-indigo-700 text-white cursor-pointer hover:bg-indigo-600 outline-none"
      >
        Add card
      </button>
      <button
        @click="closed"
        class=" py-1 px-3 rounded-md ml-1 hover:bg-gray-400 cursor-pointer text-gray-500"
      >
        Cancel
      </button>
    </div>
  </div>
</template>

<script>
import CardAdd from "./../graphql/CardAdd.gql";
import BoardQuery from "./../graphql/BoardWithListsAndCards.gql";

export default {
  props: {
    list: Object
  },
  data() {
    return {
      title: null
    };
  },
  mounted() {
    this.$refs.card.focus();
  },
  methods: {
    addCard() {
      const self = this;

      this.$apollo.mutate({
        mutation: CardAdd,
        variables: {
          title: this.title,
          listId: this.list.id,
          order: this.list.cards.length + 1
        },
        update: (store, { data: { cardAdd } }) => {
          // Read the data from our cache for this query.
          const data = store.readQuery({
            query: BoardQuery,
            variables: { id: Number(self.list.board_id) }
          });
          // Add our card from the mutation to the end
          data.board.lists
            .find(list => list.id == self.list.id)
            .cards.push(cardAdd);
          // Write our data back to the cache.
          store.writeQuery({ query: BoardQuery, data });
        }
      });
      this.closed();
    },
    closed() {
      this.$emit("closed");
    }
  }
};
</script>
