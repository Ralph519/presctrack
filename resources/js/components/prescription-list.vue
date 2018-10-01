<template>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-8 form-group">
        <label for="item">Item</label>
        <!-- <input type="text" class="form-control" v-model="newItemDesc" id="itemdescription" placeholder="Item Description" autofocus required> -->
        <select class="form-control" id="item" name="item" v-model="newItem" v-on:change="getInventory">
          <option v-for="item in items" v-bind:value="item.id">{{ item.item_description }}</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 form-group">
        <label for="doctorsname">Doctor's Name</label>
        <input type="text" class="form-control" v-model="newDoctorName" id="doctorsname" placeholder="Doctor's Name" required>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 form-group">
        <label for="patientsname">Patient's Name</label>
        <input type="text" class="form-control" v-model="newPatientName" id="patientsname" placeholder="Patient's Name" required>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 form-group">
        <label for="qty">Quantity Dispensed</label>
        <input type="number" step="1" class="form-control" v-model="newQty" id="qty" placeholder="Quantity Dispensed" required>
      </div>
      <div class="col-md-4 form-group">
        <label for="qty">Remaining Stocks</label>
        <input type="number" step="1" class="form-control" v-model="remainingQty" id="qty" placeholder="Quantity Dispensed" disabled>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="input-field col-md-12 text-right">
        <button class="btn btn-primary" v-on:click="addPrescription" :disabled="newDoctorName.length === 0">Save</button>
      </div>
    </div>

    <hr>

    <table id="reptable" class="table table-hover responsive-table bordered highlight">
      <thead>
        <tr>
          <th>Doctor's Name</th>
          <th>Patient's Name</th>
          <th>Item</th>
          <th>Qty Dispensed</th>
          <th>Action</th>
        </tr>
      </thead>

      <prescription-item v-for="(prescription, index) in prescriptions" :key="prescription.id" :prescription="prescription" :index="index" :items="items"></prescription-item>
    </table>

    <div v-if="prescriptions.length === 0">
       <p>There are no Prescription Items encoded yet</p>
     </div>
  </div>
</template>
<script>
import prescriptionItem from "./prescription-item";

export default {
  data() {
    return {
      prescriptions: [],
      newItem: "",
      newDoctorName: "",
      newPatientName: "",
      newQty: 0,
      items: [],
      inventory: [],
      remainingQty: 0
    };
  },
  created() {
    const t = this;

    this.getItems();
    this.getPrescriptions();
    this.initListeners();
  },
  methods: {
    initListeners() {
      const t = this;

      bus.$on("update-prescription", function(details) {
        t.updatePrescription(details);
      });

      bus.$on("remove-prescription", function(details) {
        t.removePrescription(details);
      });
    },
    getItems() {
      const t = this;
      axios.get("/items").then(({ data }) => {
        t.items = data;
      });
    },
    getInventory() {
      const t = this;
      axios.get("/inventory/" + t.newItem).then(({ data }) => {
        t.inventory = data;
        console.log(t.inventory);
        let nQty = 0;
        let nStocksOnHand = 0;
        if (t.inventory[0].qty != null) {
          nQty = t.inventory[0].qty;
        }

        nStocksOnHand = t.inventory[0].stocks_on_hand;

        t.remainingQty = nStocksOnHand - nQty;
        // console.log(nStocksOnHand - nQty);
      });
    },
    getPrescriptions() {
      const t = this;
      axios.get("/prescriptions").then(({ data }) => {
        t.prescriptions = data;
        // console.log(data);
      });
    },
    createPrescription(item_id, doctor_name, patient_name, qty) {
      const t = this;

      axios
        .post("/prescriptions", {
          item_id: item_id,
          doctor_name: doctor_name,
          patient_name: patient_name,
          qty: qty
        })
        .then(({ data }) => {
          // console.log(data);
          t.prescriptions.unshift(data);
        });
    },
    addPrescription() {
      const t = this;

      if (t.newDoctorName.length > 0) {
        t.createPrescription(
          t.newItem,
          t.newDoctorName,
          t.newPatientName,
          t.newQty
        );
        t.newItem = "";
        t.newDoctorName = "";
        t.newPatientName = "";
        t.newQty = 0;
        t.remainingQty = 0;
      }
    },
    updatePrescription(details) {
      const t = this;

      axios
        .patch("/prescriptions/" + details.id, details.data)
        .then(({ data }) => {
          console.log(data);
          t.prescriptions.splice(details.index, 1, data);
        });
    },
    removePrescription(details) {
      const t = this;

      axios.delete("/prescriptions/" + details.id).then(() => {
        t.prescriptions.splice(details.index, 1);
      });
    }
  },
  components: {
    prescriptionItem
  }
};
</script>
