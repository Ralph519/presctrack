<template>
  <tbody >
    <tr v-show="state.edit === false" class="white-text hover:font-bold" style="cusor:pointer">
      <td @click="startEdit" class="cursor-pointer">
        {{prescription.doctor_name}}
      </td>
      <td @click="startEdit" class="cursor-pointer">
        {{prescription.patient_name}}
      </td>
      <td @click="startEdit" class="cursor-pointer">
        {{prescription.items.item_description}}
      </td>
      <td @click="startEdit" class="cursor-pointer text-center">
        {{prescription.qty}}
      </td>
      <td class="cursor-pointer">
        <a rel="tooltip" title="Delete record" style="padding: 0px;" @click="remove(index)">
          <small style="cursor: pointer">Delete</small>
        </a>
      </td>
    </tr>

    <tr v-show="state.edit === true" style="cursor:pointer">
      <td>
        <input  type="text" style="width: 150px;" v-model="data.doctor_name" @keyup.enter="updateItem" placeholder="Update Doctor's Name">
      </td>
      <td>
        <input  type="text" style="width: 150px;" v-model="data.patient_name" @keyup.enter="updateItem" placeholder="Update Patient's Name">
      </td>
      <td>
        <!-- <input type="number" style="width: 40px;" v-model="data.item" @keyup.enter="updateItem" placeholder="Update Item"> -->
        <select v-model="data.item_id" @keyup.enter="updateItem">
          <option v-for="item in items" v-bind:value="item.id">{{item.item_description}}</option>
        </select>
      </td>
      <td>
        <input type="number" style="width: 40px;" v-model="data.qty" @keyup.enter="updateItem" placeholder="Update qty dispensed">
      </td>

      <td>
        <a class="btn btn-primary btn-sm update" v-on:click="updateItem" :disabled="data.doctor_name.length === 0">Update</a>
        <a class="btn btn-outline-primary btn-sm" v-on:click="cancelEdit">Cancel</a>
      </td>
    </tr>
  </tbody>

</template>

<script>
import swal from "sweetalert";

export default {
  props: ["prescription", "index", "items"],
  data() {
    return {
      state: {
        edit: false
      },
      data: {
        item_id: "",
        doctor_name: "",
        patient_name: "",
        qty: 0
      }
    };
  },
  mounted() {
    const t = this;
    // console.log(t.items);
    t.data.doctor_name = t.prescription.doctor_name;
    t.data.patient_name = t.prescription.patient_name;
    t.data.qty = t.prescription.qty;
    t.data.item_id = t.prescription.item_id;
  },
  methods: {
    updateItem() {
      const t = this;

      t.$nextTick(() => {
        bus.$emit("update-prescription", {
          data: t.data,
          index: t.index,
          id: t.prescription.id
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
          bus.$emit("remove-prescription", {
            index: t.index,
            id: t.prescription.id
          });
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
      t.data.doctor_name = t.prescription.doctor_name;
      t.data.patient_name = t.prescription.patient_name;
      t.data.qty = t.prescription.qty;
      t.data.item_id = t.prescription.item_id;
    }
  }
};
</script>
