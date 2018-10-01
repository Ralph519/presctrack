<template>
  <tbody >
    <tr v-show="state.edit === false" class="white-text hover:font-bold" style="cusor:pointer">
      <td @click="startEdit" class="cursor-pointer">
        {{item.item_description}}
      </td>
      <td @click="startEdit" class="cursor-pointer">
        {{item.generic_name}}
      </td>
      <td @click="startEdit" class="cursor-pointer">
        {{item.package}}
      </td>
      <td @click="startEdit" class="cursor-pointer">
        {{item.stocks_on_hand}}
      </td>
      <td class="cursor-pointer">
        <a rel="tooltip" title="Delete record" style="padding: 0px;" @click="remove(index)">
          <small style="cursor: pointer">Delete</small>
        </a>
      </td>
    </tr>

    <tr v-show="state.edit === true" style="cursor:pointer">
      <td>
        <input  type="text" style="width: 350px;" v-model="data.item_description" @keyup.enter="updateItem" placeholder="Update Description">
      </td>
      <td>
        <input  type="text" style="width: 150px;" v-model="data.generic_name" @keyup.enter="updateItem" placeholder="Update Generic Name">
      </td>
      <td>
        <input  type="text" style="width: 50px;" v-model="data.package" @keyup.enter="updateItem" placeholder="Update Generic Name">
      </td>
      <td>
        <input type="number" style="width: 70px;" v-model="data.stocks_on_hand" @keyup.enter="updateItem" placeholder="Update Stocks on hand">
      </td>

      <td>
        <a class="btn btn-primary btn-sm update" v-on:click="updateItem" :disabled="data.item_description.length === 0">Update</a>
        <a class="btn btn-outline-primary btn-sm" v-on:click="cancelEdit">Cancel</a>
      </td>
    </tr>
  </tbody>

</template>

<script>
import swal from "sweetalert";

export default {
  props: ["item", "index"],
  data() {
    return {
      state: {
        edit: false
      },
      data: {
        item_description: "",
        generic_name: "",
        pacakge: "",
        stocks_onhand: 0
      }
    };
  },
  mounted() {
    const t = this;
    t.data.item_description = t.item.item_description;
    t.data.generic_name = t.item.generic_name;
    t.data.package = t.item.package;
    t.data.stocks_on_hand = t.item.stocks_on_hand;
  },
  methods: {
    updateItem() {
      const t = this;

      t.$nextTick(() => {
        bus.$emit("update-item", {
          data: t.data,
          index: t.index,
          id: t.item.id
        });
      });

      t.state.edit = false;
    },
    remove() {
      const t = this;

      swal({
        title: "Are you sure?",
        text: "Delete the item?",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          bus.$emit("remove-item", { index: t.index, id: t.item.id });
        }
      });
    },
    startEdit() {
      const t = this;

      t.state.edit = true;
    },
    cancelEdit() {
      const t = this;

      t.state.edit = false;
      t.data.item_description = t.item.item_description;
      t.data.generic_name = t.item.generic_name;
      t.data.package = t.item.package;
      t.data.stocks_on_hand = t.item.stocks_on_hand;
    }
  }
};
</script>
