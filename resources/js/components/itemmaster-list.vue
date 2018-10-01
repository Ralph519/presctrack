<template>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 form-group">
          <label for="itemdescription">Item Description</label>
          <input type="text" class="form-control" v-model="newItemDesc" id="itemdescription" placeholder="Item Description" autofocus required>
        </div>

        <div class="col-md-6 form-group">
          <label for="genericname">Generic Name</label>
          <input type="text" class="form-control" v-model="newGenerName" id="genericname" placeholder="Generic Name" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label for="package">Packaging</label>
          <input type="text" class="form-control" v-model="newPack" id="package" placeholder="Packaging" required>
        </div>

        <div class="col-md-6 form-group">
          <label for="stocksonhand">Stocks on hand</label>
          <input type="number" class="form-control" v-model="newStocksonhand" id="stocksonhand" placeholder="Stocks on hand" required>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="input-field col-md-12 text-right">
          <button class="btn btn-primary" v-on:click="addItem" :disabled="newItemDesc.length === 0">Add</button>
        </div>
      </div>

      <hr>

      <table id="reptable" class="table table-hover responsive-table bordered highlight">
        <thead>
          <tr>
            <th>Description</th>
            <th class="text-center">Generic Name</th>
            <th>Packaging</th>
            <th class="text-center">Stocks on hand</th>
            <th>Action</th>
          </tr>
        </thead>

        <itemmaster-item v-for="(item, index) in items" :key="item.id" :item="item" :index="index"></itemmaster-item>
      </table>

      <div v-if="items.length === 0">
  	     <p>There are no Prescription Items encoded yet</p>
       </div>
    </div>
</template>

<script>
import itemmasterItem from "./itemmaster-item";

export default {
  data() {
    return {
      items: [],
      newItemDesc: "",
      newGenerName: "",
      newPack: "",
      newStocksonhand: 0
    };
  },
  created() {
    const t = this;

    this.getItems();
    this.initListeners();
  },
  methods: {
    initListeners() {
      const t = this;

      bus.$on("update-item", function(details) {
        t.updateItems(details);
      });

      bus.$on("remove-item", function(details) {
        t.removeItems(details);
      });
    },
    getItems() {
      const t = this;
      axios.get("/items").then(({ data }) => {
        t.items = data;
        console.log(data);
      });
    },
    createItem(itemdescription, genericname, pack, stocksonhand) {
      const t = this;

      axios
        .post("/items", {
          itemdescription: itemdescription,
          genericname: genericname,
          package: pack,
          stocksonhand: stocksonhand
        })
        .then(({ data }) => {
          t.items.unshift(data);
        });
    },
    addItem() {
      const t = this;

      if (t.newItemDesc.length > 0) {
        t.createItem(
          t.newItemDesc,
          t.newGenerName,
          t.newPack,
          t.newStocksonhand
        );
        t.newItemDesc = "";
        t.newGenerName = "";
        t.newPack = "";
        t.newStocksonhand = 0;
      }
    },
    updateItems(details) {
      const t = this;

      axios.patch("/items/" + details.id, details.data).then(({ data }) => {
        t.items.splice(details.index, 1, data);
      });
    },
    removeItems(details) {
      const t = this;

      axios.delete("/items/" + details.id).then(() => {
        t.items.splice(details.index, 1);
      });
    }
  },
  components: {
    itemmasterItem
  }
};
</script>
